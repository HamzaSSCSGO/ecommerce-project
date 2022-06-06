@extends('adminmaster')
@section('content')

<form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
    @csrf
    <small></small>
    <div class="wrapper centered">
    <article class="letter">
        <div class="side">
          <h1>Add Product</h1>
          <p>
            <input type="text" placeholder="product name" name="name">
          </p>

          <p>
            <input type="text" placeholder="price" name="price">
          </p>

          <p>
            <textarea placeholder="description" name="description"></textarea>
          </p>

        </div>

        <div class="side">
            <select name="category_id" id="category">
                @forelse($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @empty
                <p>empty</p>
                @endforelse
                </select>
        </div>

        <div class="side">
         <p>
         <input type="file" placeholder="product image" name="gallery"/>
         </p>
         
          <p>
            <button id="sendLetter">Send</button>
          </p>
        </div>
      </article>
      
    </div>
    </form>

@endsection