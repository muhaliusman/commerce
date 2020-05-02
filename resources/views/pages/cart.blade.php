@extends('layout.master')

@section('title', 'Cart')

@section('page')
<div class="row">
    <div class="col-12">
        <h2 class="text-center">Cart</h2>
        <hr>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 col-md-10">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Discount Code</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="products-in-cart">
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12 col-md-10 text-right">
        <button type="button" class="btn btn-primary btn-sm" id="process-order">Process</button>
    </div>
</div>
<div class="modal" id="modal-qty">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update QTY</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="qty">New Qty</label>
                    <input type="number" name="qty" id="qty" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="update-qty">Update</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal-discount">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Apply Discount Code</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="discount-code">Discount Code</label>
                    <input type="text" name="discount_code" id="discount-code" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="update-discount">Update</button>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<script>
function initTable() {
    $.ajax({
        url: 'cart/products',
        type: "get",
        dataType: "json",
        success: function (data) {
            var products = data.products;
            var tbody = '';
            for (var i = 0; i < products.length; i++) {
                var discCode = products[i].discount_code == undefined || products[i].discount_code == null ? '-' : products[i].discount_code;
                var discPerc = products[i].discount_percentage;
                var totalPrice = products[i].price * products[i].qty;
                var totalDisc = discPerc == 0 ? 0 : discPerc/100 * totalPrice;
                var priceAfterDisc =  totalPrice - totalDisc;
                tbody += '<tr>'+
                        '<td>'+(i+1)+'</td>'+
                        '<td>'+products[i].name+'</td>'+
                        '<td>$ '+products[i].price+'</td>'+
                        '<td>'+products[i].qty+'</td>'+
                        '<td>'+discCode+'</td>'+
                        '<td><b>$ '+priceAfterDisc.toFixed(2)+'</b></td>'+
                        '<td>'+
                            '<button class="btn btn-success btn-sm edit-qty" data-id="'+products[i].product_id+'" data-qty="'+products[i].qty+'">Edit Qty</button>&nbsp;'+
                            '<button class="btn btn-danger btn-sm delete-item" data-id="'+products[i].product_id+'">Delete Product</button>&nbsp;'+
                            '<button class="btn btn-primary btn-sm apply-discount" data-id="'+products[i].product_id+'" data-discount="'+discCode+'">Apply Discount</button>'+
                        '</td>'+
                    +'</tr>';
            }


            $('#products-in-cart').empty().append(tbody);
        },
        statusCode: {
            500 : function (data) {
                alert('Ups something wrong');
            }
        }
    });

}
$(function() {
    initTable();
    var updateProdId;
    var updateDiscId;

    $('#products-in-cart').on('click', '.delete-item', function() {
        var productId = $(this).data('id');
        $.ajax({
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            url: "cart/"+productId,
            type: "delete",
            dataType: "json",
            success: function (data) {
                initCart();
                initTable();
            },
            statusCode: {
                400 : function (data) {
                    alert(data.responseJSON.message);
                },
                500 : function (data) {
                    alert('Ups something wrong');
                }
            }
        });
    });

    $('#products-in-cart').on('click', '.edit-qty', function() {
        updateProdId = $(this).data('id');

        $('#qty').val($(this).data('qty'));
        $('#modal-qty').modal('show');
    });

    $('#products-in-cart').on('click', '.apply-discount', function() {
        updateDiscId = $(this).data('id');

        $('#discount-code').val($(this).data('discount'));
        $('#modal-discount').modal('show');
    });

    $('#update-qty').on('click', function() {
        var qty = $('#qty').val();

        $.ajax({
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                qty: qty
            },
            url: "cart/"+updateProdId+"/qty",
            type: "put",
            dataType: "json",
            success: function (data) {
                initTable();
            },
            statusCode: {
                400 : function (data) {
                    alert(data.responseJSON.message);
                },
                500 : function (data) {
                    alert('Ups something wrong');
                }
            }
        });
    });

    $('#update-discount').on('click', function() {
        var discountCode = $('#discount-code').val();

        $.ajax({
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                discount_code: discountCode
            },
            url: "cart/"+updateDiscId+"/discount",
            type: "put",
            dataType: "json",
            success: function (data) {
                initTable();
            },
            statusCode: {
                400 : function (data) {
                    alert(data.responseJSON.message);
                },
                500 : function (data) {
                    alert('Ups something wrong');
                }
            }
        });
    });

    $('#process-order').on('click', function() {
        $.ajax({
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            url: "order",
            type: "post",
            dataType: "json",
            success: function (data) {
                alert(data.message);
                window.location.href = "order";
            },
            statusCode: {
                400 : function (data) {
                    alert(data.responseJSON.message);
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