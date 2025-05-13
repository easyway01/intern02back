@extends('layout')

@section('content')

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <br><br>
        <div class="form-background" style="background-color: #e9ecef; padding: 20px; border-radius: 10px; margin-top: 100px;"> <!-- Added margin-top -->
        <h3 style="color: black; text-align: center;">Add</h3> <!-- Centered the title -->

            <form action="{{ route('addProduct.store') }}" method="POST" enctype="multipart/form-data"> <!-- Added enctype for file uploads -->
                @csrf
                <div class="form-group">
                    <label for="productName">Novel Name</label>
                    <input class="form-control" type="text" id="productName" name="productName" required>
                </div>
                <div class="form-group">
                    <label for="productDescription">Description</label>
                    <input class="form-control" type="text" id="productDescription" name="productDescription" required>
                </div>
                <div class="form-group">
                    <label for="productImage">Image</label>
                    <input class="form-control" type="file" id="productImage" name="productImage">
                </div>
                <div class="form-group">
                    <label for="categoryID">Category</label>
                    <select name="categoryID" id="categoryID" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add New</button>
            </form>
        </div>
        <br><br>
    </div>
    <div class="col-sm-3"></div>
</div>

@endsection
