import $ from 'jquery';

const PaymentMethod = Object.freeze({
    STRIPE: 'Stripe',
    PAY_PAL: 'PayPal',
    OFFLINE: 'Offline',
});

document.addEventListener('DOMContentLoaded', async () => {
    checkoutPayment();
});


function checkoutPayment() {
    var pay_now_btn = $('.js_pay_now_btn_common');
    if (pay_now_btn.length > 0) {
        pay_now_btn.on('click', function () {
            let selected_payment_method = $("input[name='payment_method']:checked").val();
            console.log('selected_payment_method', selected_payment_method)
            if (!selected_payment_method) {
                $(".js_payment_message").html("<span class='error'>Please select payment method</span>");
            }
            else if (selected_payment_method === PaymentMethod.STRIPE) {
                $("#stripe-pay-now-btn").trigger("click");
            }
            else if (selected_payment_method === PaymentMethod.OFFLINE) {
                console.log('Offline')
            }
        });
    }

    let terms_conditions_common = $(".js_terms_conditions_common");
    let paypal_button_container = $("#paypal-button-container");
    let pay_now_general_button = $(".js_pay_now_btn_common");
    let js_stripe_payment_form_wrapper = $('.js_stripe_payment_form_wrapper');
    let js_secure_payment_form_wrapper = $('.js_secure_payment_form_wrapper');
    let stripe_pay_button = $('#stripe-pay-now-additional-btn');
    let offline_pay_button = $('#js_offline_pay_btn');
    paypal_button_container.addClass('d-none');
    let is_enabled_stripe_3d_payment = $(".is_enabled_stripe_3d_payment").val() ? 1 : 0;

    $("input[name='payment_method']").on("change", function () {
        let payment_method = $("input[name='payment_method']:checked").val();

        js_stripe_payment_form_wrapper.addClass('d-none');
        js_secure_payment_form_wrapper.addClass('d-none');
        pay_now_general_button.addClass('d-none');
        paypal_button_container.addClass('d-none');

        terms_conditions_common.addClass('d-none');
        if (is_enabled_stripe_3d_payment && payment_method === PaymentMethod.STRIPE) {
        }
        else {
            $('.' + payment_method + "_terms_conditions").removeClass('d-none');
        }

        if (payment_method === PaymentMethod.STRIPE) {
            js_stripe_payment_form_wrapper.removeClass('d-none');
            stripe_pay_button.removeClass('d-none');
        }
        else if (payment_method === PaymentMethod.PAY_PAL) {
            paypal_button_container.removeClass('d-none');
        }
        else if (payment_method === PaymentMethod.OFFLINE) {
            offline_pay_button.removeClass('d-none');
        }
    });

    let default_payment_method  = $(".js_default_payment_method")?.val();
    if (default_payment_method) {
        $("input[name='payment_method'][value='" + default_payment_method + "']")?.trigger('click');
    }
    else {
        $("input[name='payment_method']:first")?.trigger('click');
    }
}
