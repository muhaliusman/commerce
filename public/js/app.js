function initCart() {
    $.ajax({
        url: 'cart/total',
        type: "get",
        dataType: "json",
        success: function (data) {
            $('#total-in-cart').text(data.total);
        },
        statusCode: {
            500 : function (data) {
                alert('Ups something wrong');
            }
        }
    });
}

$(function() {
    initCart();
});