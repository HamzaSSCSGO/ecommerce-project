<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/logout',[LogoutController::class,'perform'])->name('logout');

Route::prefix('/')->group(function(){
    Route::get('/',[ProductController::class,'index'] )->name('landingpage'); 
    Route::get('/shop', function () {
        return view('/shop');
    })->name('shop');

    Route::get("/singleproduct/{id}",[ProductController::class,'singleProduct'])->name('singleproduct');

    Route::get("/search",[ProductController::class,'search'])->name('search');

    Route::post("add_to_cart",[ProductController::class,'addToCart'])->name('add_to_cart');

    Route::get("removecart/{id}",[ProductController::class,'removeCart'])->name('removecart'); 

/*     Route::get("ordernow",[ProductController::class,'orderNow']); 
 */

    Route::post("orderplace",[ProductController::class,'orderPlace'])->name('orderplace');

});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth']], function() { 
    /* Route::get('/user',[DashboardController::class,'index'] )->name('home');
    Route::get('/admin',[DashboardController::class,'index'] )->name('admin'); */
});
/* **********ADMIN ROUTE************* */
Route::group(['middleware' => ['auth', 'role:admin']], function() { 

    Route::get('/admin',[DashboardController::class,'index'] )->name('admin'); 
    /* Route::get('/create',[ProductController::class,'create'])->name('create'); */

    Route::prefix('admin')->group(function(){

        Route::get('/create',[ProductController::class,'create'])->name('create');
        Route::post('/store',[ProductController::class,'store'])->name('store');
        Route::get('/category',[CategoryController::class,'index'])->name('category');
        Route::post('/addcategory',[CategoryController::class,'addCategory'])->name('addcategory');

    });

    
});


/* *********USER ROUTE************************* */
Route::group(['middleware' => ['auth', 'role:user']], function() { 
/*     Route::get('/user',[DashboardController::class,'index'] )->name('home');
 */
    Route::prefix('user')->group(function(){
        Route::get('/home', [DashboardController::class,'index'])->name('userlandingpage');


        Route::get('/shop', function () {
            return view('/usershop');
        })->name('shopage');

        Route::get("/singleproduct/{id}",[ProductController::class,'usersingleProduct']);
        
        Route::get("/cart",[ProductController::class,'cart'])->name('usercart');

        Route::get("/orders",[ProductController::class,'myOrders'])->name('orders');

        Route::post('/rating',[RatingController::class,'addRating'])->name('addrating');

        Route::get('/404', function () {
            return view('/404');
        })->name('404');
        



    });
    

});



/* Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard'); */

require __DIR__.'/auth.php';
