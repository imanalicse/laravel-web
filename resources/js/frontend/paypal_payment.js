import $ from 'jquery';
document.addEventListener("DOMContentLoaded", function () {
    var csrfToken = $('meta[name="csrf-token"]').attr('content')
paypal
    .Buttons({
        style: {
            // color:  'blue',
            label:  'pay',
            height: 40
        },
        // Sets up the transaction when a payment button is clicked
        createOrder: function () {
            $(".js_payment_message").html("");
            return fetch("/paypal/createPayPalOrder", {
                method: "post",
                // use the "body" param to optionally pass additional order information
                // like product skus and quantities
                headers: {
                    'X-CSRF-Token': csrfToken
                },
            })
                .then((response) => response.json())
                .then((response) => {
                    if(response.status === 'success' && response.data && response.data.id) {
                        return response.data.id;
                    }
                    else {
                        if (response.message) {
                            $(".js_payment_message").html("<span class='error'>" + response.message + "</span>");
                        }
                        if (response.redirect) {
                            setTimeout(function () {
                                window.location.replace(response.redirect);
                            }, 4000);
                        }
                    }
                });
        },
        // Finalize the transaction after payer approval
        onApprove: function (data) {
            $(".js_payment_message").html("");
            //  return fetch(`/api/orders/${data.orderID}/capture`, {
            return fetch(`/paypal/orders/${data.orderID}/capture`, {
                method: "post",
                headers: {
                    'X-CSRF-Token': csrfToken,
                    'Content-Type': 'application/json',
                }
            })
                .then((response) => response.json())
                .then((orderData) => {
                    let response = orderData;
                    /*
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    console.log('transaction', transaction)
                    */
                    try {
                        if (response.status === 'success') {
                            $(".js_payment_message").html("<span class='success'>" + response.message + "</span>");
                            if (response.redirect) {
                                window.location.replace(response.redirect);
                            }
                        }
                        else {
                            $(".js_payment_message").html("<span class='error'>" + response.message + "</span>");
                            if (response.redirect) {
                                setTimeout(function () {
                                    window.location.replace(response.redirect);
                                }, 4000);
                            }
                        }
                    }
                    catch (e) {
                        console.error(e)
                    }
                });
        },
    })
    .render("#paypal-button-container");
})
