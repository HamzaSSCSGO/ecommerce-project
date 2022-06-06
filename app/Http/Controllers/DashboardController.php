<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
   {
    $products=Product::all();
       if(Auth::user()->hasRole('user')){
            return view('userlandingpage',compact('products'));
       }elseif(Auth::user()->hasRole('admin')){
        return view('adminpage',compact('products'));
   }
   }

   public function perform()
    {
        Session::flush();
        
        Auth::logout();

        return redirect('/');
    }



    

}
