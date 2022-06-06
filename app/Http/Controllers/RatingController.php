<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{

    public function addRating(Request $request)
    {
        /* dd($request); */
        $ratings= Rating::select('rating')->where('product_id',$request->product_id)->get()->toArray();
        /* $ratings= Rating::all('rating')->toArray(); */
        /* dd($ratings); */

        $review= new Review;
        $review->review= $request->review;
        $review->product_id= $request->product_id;
        $review->user_id= Auth::user()->id;
        $review->save();

        $rating = new Rating;
        $rating->rating= $request->product_rating;
        $rating->product_id= $request->product_id;
        $rating->user_id=Auth::user()->id;
        $rating->save();
        $product =Product::find($rating->product_id);
        /* return view('usersingle-product',['product'=>$data, 'ratings'=>$ratings]); */
        /* return view('usersingle-product',compact(['product', 'ratings'])); */
        return redirect('user/home');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* return $stars_rated=$request->product_rating; */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
