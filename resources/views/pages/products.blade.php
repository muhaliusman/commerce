@extends('layout.master')

@section('title', 'Product List')

@section('page')
<div class="row">
    <div class="col-12">
        <h2 class="text-center">Product List</h2>
        <hr>
    </div>
</div>
<div class="row justify-content-center">
    @foreach ($products as $product)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-2">
        <div class="card">
            <div class="product-img-wrapper">
                <img class="card-img-top product-img" src="{{ asset($product->image) }}" alt="Card image cap">
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">
                    Price : <b>$ {{ $product->price }}</b>
                </p>
                <a href="#" class="btn btn-primary">Add To Cart</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@stop