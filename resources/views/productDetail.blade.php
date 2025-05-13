@extends('layout')

@section('content')

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <br><br>
        <div class="form-background" style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 100px;">
            <h3 style="color:black;">Detail</h3>

            <form action="{{ route('addCart') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">

                <div class="row">
                    <div class="col-md-5">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    </div>
                    <div class="col-md-7">
                        <h4>{{ $product->name }}</h4>
                        <p>{{ $product->description }}</p>
                        <p><strong>A:</strong></p>
                        <p><strong>B:</strong></p>

                        <button type="submit" class="btn btn-dark">Add to ...</button>
                        <a href="{{ route('showProduct') }}" class="btn btn-secondary ml-2">Back to Products</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
