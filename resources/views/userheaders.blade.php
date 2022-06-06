<?php 
use App\Http\Controllers\ProductController;
$total=0;
$totalPrice=0;
if(Session::has('user'))
{
  $total= ProductController::cartItem();
  $totalPrice= ProductController::priceCount();

}
?>

<div class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="user-menu">
                    <ul>
                        <li><a href="#"><i class="fa fa-user"></i> My Account</a></li>
                        <li><a href="#"><i class="fa fa-heart"></i> Wishlist</a></li>
                        <li><a href="/cart"><i class="fa fa-user"></i> My Cart</a></li>
                        <li><a href="checkout.html"><i class="fa fa-user"></i> Checkout</a></li>
                        @if(Session::has('user'))
                        <li class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Session::get('user')['name']}}
                          <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="/logout">Logout</a></li>
                          </ul>
                        </li>
                        @else
                        <li><a href="/login">Login</a></li>
                        @endif
                        {{-- <li><a href="login"><i class="fa fa-user"></i> Login</a></li> --}}
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="header-right">
                    <ul class="list-unstyled list-inline">
                       

                        <li class="dropdown dropdown-small">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><span class="key">language :</span><span class="value">English </span><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">English</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">German</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End header area -->

<div class="site-branding-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="logo">
                    <h1>{{-- <a href="./"><img src="{{URL('img/logo.png')}}"></a> --}}ECOM Projet</h1>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="shopping-item">
                    <a href="/cart">Cart - <span class="cart-amunt">{{$totalPrice}}</span> <i class="fa fa-shopping-cart"></i> <span class="product-count">{{$total}}</span></a>
                </div>
                {{-- <ul>
                @if(Session::has('user'))
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Session::get('user')['name']}}
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/logout">Logout</a></li>
            </ul>
          </li>
          @else
          <li><a href="/login">Login</a></li>
          @endif
        </ul> --}}
            </div>
        </div>
    </div>
</div> <!-- End site branding area -->

<div class="mainmenu-area">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div> 
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/home">Home</a></li>
                    <li><a href="/shop">Shop page</a></li>
                    <li><a href="/singleproduct">Single product</a></li>
                    <li><a href="/cart">Cart</a></li>
                    {{-- <li><a href="checkout.html">Checkout</a></li>
                    <li><a href="#">Category</a></li> --}}
                    <li><a href="/orders">Orders</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>  
        </div>
    </div>
</div> <!-- End mainmenu area -->