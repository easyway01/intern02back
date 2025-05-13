@extends('layout')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <br><br>
            <div class="form-background bg-white p-3 rounded shadow">
                @if(count($products) > 0)
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
    <a href="{{ route('productDetail', ['id' => $product->id]) }}" target="_blank">
        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 120px; height: auto;">
    </a>
</td>

                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->category_id }}</td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="{{ route('editProduct', ['id' => $product->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ route('deleteProduct', ['id' => $product->id]) }}" class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center">No results found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
