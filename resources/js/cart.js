import $ from 'jquery';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let cart_products_json = $(".cart_products_json").text();
    if (cart_products_json) {
        let cart_products = JSON.parse(cart_products_json);
        if (cart_products) {
            Object.entries(cart_products).forEach(([product_id, product_object]) => {
                console.log(product_id, product_object);
                let product_selector = $('#product-' + product_id);
                product_selector.find('.add-to-cart-btn').addClass('d-none');
                product_selector.find('.cart-added-box').removeClass('d-none');
                product_selector.find('.cart-added-box .quantity').text(product_object.quantity);
            });
        }
    }

    $(".js-btn-add-cart").on("click", function (event) {
        event.preventDefault();
        let self = $(this);
        let add_to_cart_box = $(this).closest('.add-to-cart-box');
        let product_id = add_to_cart_box.data('product_id');
        let data = {
            product_id: product_id,
            action_type: 'increase'
        };
        cartAjax(data, function (response) {
            console.log('response', response)
            self.addClass('d-none');
            add_to_cart_box.find('.cart-added-box').removeClass('d-none');
        });
    });

    $(".cart-increase-action").on("click", function (event) {
        event.preventDefault();
        let add_to_cart_box = $(this).closest('.add-to-cart-box');
        let product_id = add_to_cart_box.data('product_id');
        let quantity_element = add_to_cart_box.find('.quantity');
        let data = {
            product_id: product_id,
            action_type: 'increase'
        };

        cartAjax(data, function (response) {
            console.log('response', response)
            let quantity = response[product_id]['quantity'];
            quantity_element.text(quantity);
        });
    });

    $(".cart-decrease-action").on("click", function (event) {
        event.preventDefault();
        let add_to_cart_box = $(this).closest('.add-to-cart-box');
        let product_id = add_to_cart_box.data('product_id');
        let quantity_element = add_to_cart_box.find('.quantity');
        let quantity = parseInt(add_to_cart_box.find('.quantity').text());
        if (quantity <= 0) {
            return false;
        }
        let data =  {
            product_id: product_id,
            action_type: 'decrease'
        };
        cartAjax(data, function (response) {
            let quantity = response?.[product_id]?.quantity;
            if (!quantity) {
                add_to_cart_box.find('.add-to-cart-btn').removeClass('d-none');
                add_to_cart_box.find('.cart-added-box').addClass('d-none');
            }
            else {
                quantity_element.text(quantity);
            }
        })
    });
});

function cartAjax(data, cb) {
    $.ajax({
        url: base_url+ '/add-to-cart',
        method:'POST',
        data: data,
        success: function (response) {
            cb(response);
        },
        error: function (error) {

        }
    });
}
