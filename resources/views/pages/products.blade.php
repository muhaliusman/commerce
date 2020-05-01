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
                <button data-id="{{ $product->id }}" class="btn btn-primary add-to-cart">Add To Cart</button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@stop

@push('script')
<script>
$(function() {
    $('.add-to-cart').on('click', function() {
        var id = $(this).data('id');

        $.ajax({
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product: id
            },
            url: "cart",
            type: "post",
            dataType: "json",
            success: function (data) {
                alert(data.message);
                initCart(); // in app.js
            },
            statusCode: {
                404 : function (data) {
                    alert('Ups product not found');
                },
                500 : function (data) {
                    alert('Ups something wrong');
                }
            }
        });
    });
});
</script>
@endpush