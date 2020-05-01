@extends('layout.master')

@section('title', 'Discount List')

@section('page')
<div class="row">
    <div class="col-12">
        <h2 class="text-center">Discount List</h2>
        <hr>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Discount Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($discounts as $index => $discount)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $discount->discount_code }}</td>
                        <td>{{ $discount->discount_percentage }} %</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop