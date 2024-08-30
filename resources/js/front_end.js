import $ from 'jquery';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

document.addEventListener("DOMContentLoaded", function () {

    $(".js-btn-add-cart").on("click", function (event) {
        event.preventDefault();
        let self = $(this);
        let add_to_cart_box = $(this).parent();
        let product_id = add_to_cart_box.data('product_id');
        $.ajax({
            url: base_url+ '/add-to-cart',
            method:'POST',
            data: {
                product_id: product_id
            },
            success: function (response) {
                self.addClass('d-none');
                add_to_cart_box.find('.cart-added-box').removeClass('d-none');
            },
            error: function (error) {

            }
        });
    });

});
