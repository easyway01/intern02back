@extends('layout')

@section('content')

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <br><br>
        <div class="form-background" style="background-color: #e9ecef; padding: 20px; border-radius: 10px; margin-top: 100px;">
        <h3 style="color:black;">Edit Product</h3>

        <form action="{{ route('updateProduct', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

            <div class="form-group">
                <label for="productname">Product Name</label>
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input class="form-control" type="text" id="productName" name="productName" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="productDescription">Description</label>
                <input class="form-control" type="text" id="productDescription" name="productDescription" value="{{ $product->description }}" required>
            </div>

            <div class="form-group">
                <label for="productImage">Image</label>
                <input class="form-control" type="file" id="productImage" name="productImage">
            </div>

            <!-- Display current image -->
            @if ($product->image)
                <img src="{{ asset('images/' . $product->image) }}" alt="Product Image" width="200" class="img-fluid"><br>
            @endif

            <div class="form-group">
                <label for="Category">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="{{ $product->category_id }}">{{ $product->category_id }}</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
                 
        </form>
        </div>
        <br><br>
    </div>
    <div class="col-sm-3"></div>
</div>

@endsection
