@extends('adminmaster')
@section('content')

<form method="POST" action="{{ route('addcategory') }}" enctype="multipart/form-data">
    @csrf
    <small></small>
    <div class="wrapper centered">
    <article class="letter">
        <div class="side">
          <h1>Add Category</h1>
          <p>
            <input type="text" placeholder="product name" name="name">
          </p>

        <div class="side">
         
         
          <p>
            <button id="sendLetter">Send</button>
          </p>
        </div>
      </article>
      
    </div>
    </form>

@endsection