@extends('adminmaster')
@section('content')

<table class="table" style="width: 100%;" >
    <thead>
        <tr>
            {{-- <th>
                <span class="custom-checkbox">
                    <input type="checkbox" id="selectAll">
                    <label for="selectAll"></label>
                </span>

            </th> --}}
            <th>id</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Product Image</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    @forelse($products as $product)
        <tr id="pre{{$product->id}}">
            {{-- <td>
                <span class="custom-checkbox">
                    <input type="checkbox" id="checkbox1" name="options[]" value="1">
                    <label for="checkbox1"></label>
                </span>
            </td> --}}
            <td>{{$product->id}}</td>
            <td style="text-align:center">{{$product->name}}</td>
            <td style="text-align:center">{{$product->description}}</td>
            <td style="text-align:center"><img width="100" height="100" src="{{Storage::url($product->gallery)}}"/></td>
            <td>
                <button type="button" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-info">Info</button>
                <button type="button" class="btn btn-danger">Delete</button>
                

                {{-- <a href="{{route('animal.edit', $animal->id)}}" class="edit" ><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                <a href="{{route('animal.delete',$animal->id)}}" class="delete" ><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a> 
                <a onClick="deleteRecord({{$animal->id}})" href="javascript:void(0)" class="delete" > <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a> --}}
            </td>
        </tr>
        @empty

        <tr>
            No Products yet

            <a href="{{-- {{route('animal.create')}} --}}">Back to create a product</a>
        </tr>

        @endforelse
        
    </tbody>
    {{-- {{$products->links()}} --}}
</table>


    

@endsection