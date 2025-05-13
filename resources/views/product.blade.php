@extends('layout')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <br><br>

            {{-- 搜索框 --}}
            <form class="form-inline mb-3" method="GET" action="{{ route('searchProduct') }}">
                <input class="form-control mr-2" type="text" name="query" placeholder="Search Product by Name" value="{{ request('query') }}">
                <button class="btn btn-dark" type="submit">Search</button>

                {{-- 如果是在搜索结果页面，显示“显示全部”按钮 --}}
                @if(request()->has('query') && request('query') !== '')
                    <a href="{{ route('showProduct') }}" class="btn btn-secondary ml-2">Show All</a>
                @endif
            </form>

            <div class="form-background" style="background-color: white;">
                @if(count($products) > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <a href="{{ route('productDetail', ['id' => $product->id]) }}">
                                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" width="100" class="img-fluid">
                                        </a>
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->category_id }}</td>
                                    <td>
                                        <a href="{{ route('editProduct', ['id' => $product->id]) }}" class="btn btn-warning btn-xs">Edit</a>
                                        <a href="{{ route('deleteProduct', ['id' => $product->id]) }}" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No results found.</p>
                @endif
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>

@endsection
