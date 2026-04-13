import $ from 'jquery';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function updateCartBadge(cartProducts) {
    let count = 0;
    if (cartProducts) {
        Object.values(cartProducts).forEach(function (p) {
            count += parseInt(p.quantity || 0);
        });
    }
    $('.js-cart-count').text(count);
}

document.addEventListener("DOMContentLoaded", function () {
    // --- Product listing page: init from JSON ---
    let cart_products_json = $(".cart_products_json").text();
    if (cart_products_json) {
        let cart_products = JSON.parse(cart_products_json);
        if (cart_products) {
            updateCartBadge(cart_products);
            Object.entries(cart_products).forEach(([product_id, product_object]) => {
                let product_selector = $('#product-' + product_id);
                product_selector.find('.add-to-cart-btn').addClass('d-none');
                product_selector.find('.cart-added-box').removeClass('d-none');
                product_selector.find('.cart-added-box .quantity').text(product_object.quantity);
            });
        }
    }

    // --- Product listing: Add to cart ---
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
            self.addClass('d-none');
            add_to_cart_box.find('.cart-added-box').removeClass('d-none');
            updateCartBadge(response);
        });
    });

    // --- Product listing: Increase quantity ---
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
            let quantity = response[product_id]['quantity'];
            quantity_element.text(quantity);
            updateCartBadge(response);
        });
    });

    // --- Product listing: Decrease quantity ---
    $(".cart-decrease-action").on("click", function (event) {
        event.preventDefault();
        let add_to_cart_box = $(this).closest('.add-to-cart-box');
        let product_id = add_to_cart_box.data('product_id');
        let quantity_element = add_to_cart_box.find('.quantity');
        let quantity = parseInt(add_to_cart_box.find('.quantity').text());
        if (quantity <= 0) {
            return false;
        }
        let data = {
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
            updateCartBadge(response);
        });
    });

    // --- Cart page: Increase quantity ---
    $(document).on("click", ".js-cart-increase", function () {
        let control = $(this).closest('.cart-qty-control');
        let product_id = control.data('product_id');
        cartAjax({ product_id: product_id, action_type: 'increase' }, function (response) {
            let product = response[product_id];
            if (product) {
                control.find('.cart-qty-value').text(product.quantity);
                let item = $('#cart-item-' + product_id);
                item.find('.js-item-total').text(parseFloat(product.price * product.quantity).toFixed(2));
                updateCartSummary(response);
            }
            updateCartBadge(response);
        });
    });

    // --- Cart page: Decrease quantity ---
    $(document).on("click", ".js-cart-decrease", function () {
        let control = $(this).closest('.cart-qty-control');
        let product_id = control.data('product_id');
        let qty = parseInt(control.find('.cart-qty-value').text());
        if (qty <= 1) {
            removeCartItem(product_id);
            return;
        }
        cartAjax({ product_id: product_id, action_type: 'decrease' }, function (response) {
            let product = response?.[product_id];
            if (product) {
                control.find('.cart-qty-value').text(product.quantity);
                let item = $('#cart-item-' + product_id);
                item.find('.js-item-total').text(parseFloat(product.price * product.quantity).toFixed(2));
                updateCartSummary(response);
            }
            updateCartBadge(response);
        });
    });

    // --- Cart page: Remove item ---
    $(document).on("click", ".js-cart-remove", function () {
        let product_id = $(this).data('product_id');
        removeCartItem(product_id);
    });
});

function removeCartItem(product_id) {
    $.ajax({
        url: window.base_url + '/cart/remove',
        method: 'POST',
        data: { product_id: product_id },
        success: function (response) {
            $('#cart-item-' + product_id).fadeOut(300, function () {
                $(this).remove();
                let products = response?.products || {};
                updateCartBadge(products);
                if (Object.keys(products).length === 0) {
                    location.reload();
                } else {
                    updateCartSummary(products);
                }
            });
        }
    });
}

function updateCartSummary(cartProducts) {
    let total = 0;
    Object.values(cartProducts).forEach(function (p) {
        total += parseFloat(p.price) * parseInt(p.quantity);
    });
    $('.js-cart-subtotal').text('$' + total.toFixed(2));
    $('.js-cart-total').text('AUD $' + total.toFixed(2));
}

function cartAjax(data, cb) {
    $.ajax({
        url: window.base_url + '/add-to-cart',
        method: 'POST',
        data: data,
        success: function (response) {
            cb(response);
        },
        error: function (error) {
        }
    });
}
