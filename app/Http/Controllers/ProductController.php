<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Mail\TestMail;
use App\Models\Rating;
use App\Models\Product;
use App\Mail\NotifyMail;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        return view('landingpage',compact('products'));
    }

    function singleProduct($id)
    {
        
        $data =Product::find($id);
        return view('single-product',['product'=>$data]);
        
    }

    function search(Request $req)
    {
        $data= Product::
        where('name', 'like', '%'.$req->input('query').'%')
        ->get();
        return view('shop',['products'=>$data]);
    }

    function usersingleProduct($id)
    {
        
        
        $product =Product::find($id);
        $rating= Rating::select('rating')->where('product_id',$product->id)->sum('ratings.rating')/* ->get() *//* ->toArray() */;
        $number= Rating::select('rating')->where('product_id',$product->id)->count();
        /* dd($number); */
        if($number>0){
            $ratings=$rating/$number;
        /* dd($data); */
        return view('usersingle-product',compact(['product', 'ratings','number']));

        }else{
            return view('usersingle-product',compact(['product', 'number']));
        }
        
        
    }


    function addToCart(Request $req)
    {
        /* dd($req); */
        if(Auth::check())
        {
            /* $products=Product::all(); */
           $cart= new Cart;
           $cart->user_id=Auth::user()->id;
           $cart->product_id=$req->product_id;
           $cart->save();
           return redirect('user/home') /* view('userlandingpage',compact('products')) */;

        }
        else
        {
            return redirect('/login');
        }
    }

    static function cartItem()
    {
     $userId=Auth::user()->id;
     /* dd(Auth::user()); */
     return Cart::where('user_id',$userId)->count();
    }


    function cart(Request $req)
    {
        /* Session::get('user')['id'] */
        /* dd($req->session()->has('user')); */
        if(Auth::check())
        {
            $intent = auth()->user()->createSetupIntent();
        $userId=Auth::user()->id;
       $products= DB::table('carts')
        ->join('products','carts.product_id','=','products.id')
        ->where('carts.user_id',$userId)
        ->select('products.*','carts.id as cart_id')
        ->get();

        /* $product=$products[0]; */
        /* dd($product); */


        $total=  DB::table('carts')
         ->join('products','carts.product_id','=','products.id')
         ->where('carts.user_id',$userId)
         ->sum('products.price');

         /* dd($products); */

         /* $allCart= Cart::where('user_id',$userId)->get(); */
            /* dd($allCart); */

        return view('usercart',compact(['products','total','intent'/* ,'product' */]));
        }
        else
        {
            return redirect('/login');
        }

    }

    function removeCart($id)
    {
        Cart::destroy($id);
        return redirect('user/cart');
    }


    function orderPlace(Request $req)
    {

        $user          = Auth::user();
        $userId=Auth::user()->id;

        $products= DB::table('carts')
        ->join('products','carts.product_id','=','products.id')
        ->where('carts.user_id',$userId)
        ->select('products.*','carts.id as cart_id')
        ->get();

        /* dd($products); */

        $total=  DB::table('carts')
         ->join('products','carts.product_id','=','products.id')
         ->where('carts.user_id',$userId)
         ->sum('products.price');

        /* dd($req); */

        
        /* $paymentMethod = $req->input('payment_method'); */
    
        $amount = $req->amount;

        if($amount!=$total){
            return view('404');
        }else{
            $paymentMethod= $req->payment_method;


        
            $allCart= Cart::where('user_id',$userId)->get();

            /* dd($allCart); */
            /*  */

            $userName = Auth::user()->name;
            $details=[
                'title' => 'Mail from EcomeProject',
                'description'=> $userName . ' just bought from your website for a total of ' . $total,
                'body' => $products,
            ];

            Mail::to("the.mma.hound@gmail.com")->send(new TestMail($details));

            /* $userEmail=Auth::user()->email; */

        /*  $mail_data=[
                'recipient' => 'the.mma.hound@gmail.com',
                'fromEmail' => 'ecomproject@gmail.com',
                'fromName' => 'hasanabi',
                'subject' => 'new sale',
                'body' => 'youjust sold several items',
            ]; */

            /* Mail::to('the.mma.hound@gmail.com')->send(new NotifyMail); */

        

            /* Mail::send('email-template',$mail_data, function($message) use($mail_data){
                $message->to($mail_data['recipient'])
                        ->from($mail_data['fromEmail'],$mail_data['fromName'])
                        ->subject($mail_data['subject']);
            }); */

            /*  */

            $user->createOrGetStripeCustomer();

            $paymentMethod = $user->addPaymentMethod($paymentMethod);

            $user->charge($amount*100, $paymentMethod->id);

            

            foreach($allCart as $cart)
            {
                $order= new Order;
                /* $user->createOrGetStripeCustomer();
                $user->updateDefaultPaymentMethod($paymentMethod);
                $user->charge($req->price * 100, $paymentMethod); */   
                $order->product_id=$cart['product_id'];
                $order->user_id=$cart['user_id'];
                $order->status="pending";
                $order->payment_method=$req->payment;
                $order->payment_status="pending";
                $order->address=$req->address;
                $order->save();
                Cart::where('user_id',$userId)->delete(); 
            }
            $req->input();         
        
            return redirect('user/home');

        }


        
    }


    function myOrders(Request $req)
    {
        if(Auth::check())
        {
        $userId=Auth::user()->id;
        $orders= DB::table('orders')
         ->join('products','orders.product_id','=','products.id')
         ->where('orders.user_id',$userId)
         ->get();
 
         return view('orders',['orders'=>$orders]);
        }
        else
        {
            return redirect('/login');
        }
    }


    static function priceCount()
    {
        $userId=Auth::user()->id;
        $total=  DB::table('carts')
         ->join('products','carts.product_id','=','products.id')
         ->where('carts.user_id',$userId)
         ->sum('products.price');
         return $total;

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        /* dd($categories); */
        return view('create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:products',
            'price'=>'required',
            'gallery'=>'required|max:2048',
            'description'=>'required',
            'category_id'=>'required',
            
        ]/* ,[
            'author_name.required'=>'Author name is required',
            'author_name.unique'=>'Author is unique',
            'about_author.required'=>'Biography is required',
            'about_author.string'=>'The biography must be only characters',
            'author_image.max'=>'max file upload size is 2M',
           
        ] */);

        $path=$request->file('gallery')->store('public/files');
       

        Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'price'=>$request->price,
            'category_id'=>$request->category_id,
            'gallery'=>$path,
            
        ]);
        
        // $request->session()->put('message', 'category is created');
        return redirect('admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
