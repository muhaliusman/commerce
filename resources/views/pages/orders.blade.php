@extends('layout.master')

@section('title', 'Order List')

@section('page')
<div class="row">
    <div class="col-12">
        <h2 class="text-center">Order List</h2>
        <hr>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total Price</th>
                        <th>Disc. Code</th>
                        <th>Total Discount</th>
                        <th>Price After Discount</th>
                        <th>Order Datetime</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->product->name }}</td>
                        <td>$ {{ $order->price }}</td>
                        <td>{{ $order->qty }}</td>
                        <td>{{ $order->total_price }}</td>
                        <td>{{ $order->discount ? $order->discount->discount_code : '-' }}</td>
                        <td>{{ $order->discount_value }}</td>
                        <td>{{ $order->price_after_discount }}</td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop