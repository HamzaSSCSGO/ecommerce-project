@extends('masters')
@section("content")

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
                    <li><a href="{{route('userlandingpage')}}">Home</a></li>
                    <li><a href="{{route('shopage')}}">Shop page</a></li>
                    {{-- <li><a href="single-product.html">Single product</a></li> --}}
                    <li><a href="{{route('usercart')}}">Cart</a></li>
                    <li ><a href="{{route('orders')}}">Orders</a></li>
                    <li class="active"><a href="404">404</a></li>
                    {{-- <li><a href="#">Others</a></li>
                    <li><a href="#">Contact</a></li> --}}
                </ul>
            </div>  
        </div>
    </div>
</div> <!-- End mainmenu area -->

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Don't tamper with my data b$%ch</h2>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Page title area -->

<div class="temper" >
    <div class=temper-wrapper {{-- style="height: 100%;" --}}>

        <img src="{{URL('img/batman-slap.gif')}}" alt="" class="image-tamper" style="margin: 100px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 40%;">
    </div>
</div>

@endsection