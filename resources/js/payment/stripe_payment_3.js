import $ from 'jquery';
var stripe;
var stripePaymentForm;
document.addEventListener('DOMContentLoaded', async () => {
    const stripe_public_key = document.querySelector("#stripe_public_key").value;
    console.log('stripe_public_key', stripe_public_key)
    stripe = Stripe(stripe_public_key);

    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        hidePostalCode: true,
        style: {
            base: {
                iconColor: '#666EE8',
                color: '#31325F',
                lineHeight: '40px',
                fontWeight: 300,
                fontFamily: 'Helvetica Neue',
                fontSize: '15px',
                '::placeholder': {
                    color: '#CFD7E0',
                },
            },
        }
    });
    cardElement.mount('#card-element');


    const stripePaymentForm = document.querySelector('#payment-form');
    stripePaymentForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        stripePaymentForm.querySelector('button').disabled = true;

        $.ajax({
            url: '/stripe/create-payment-intent',
            method: 'GET',
            success: function (response) {
                try {
                    let resp =JSON.parse(response);
                    console.log('payment_intent_response: ', resp);
                    if (resp.status === 'success') {
                        let payment_intent = resp.intent_data;
                        makePayment(payment_intent, cardElement);
                    }
                }
                catch (e) {
                    console.error('error', e)
                }
            },
            error: function (xhr, status) {

            },
        })
    });
});

async function makePayment(payment_intent, cardElement) {
    let paymentIntent_client_secret = payment_intent.client_secret;
    // Confirm the card payment that was created server side:
    const {error, paymentIntent} = await stripe.confirmCardPayment(
        paymentIntent_client_secret, {
            payment_method: {
                card: cardElement,
            },
        },
    );
    if(error) {
        const error_message = error.message;
        console.log('error_message', error_message);
        console.log('error', error);
        alert(`error_message: ${error_message}`)
        stripePaymentForm.querySelector('button').disabled = false;
        return;
    }

    console.log('confirmPaymentIntent', paymentIntent);

    if (paymentIntent.id && paymentIntent.status === "succeeded") {
        console.log('Write code here to create order')
        $.ajax({
            url: '/stripe/order',
            method: 'POST',
            data: {
                payment_intent: paymentIntent
            },
            success: function (response) {
                try {
                    let resp =JSON.parse(response);
                    console.log('order response: ', resp);
                    if (resp.status === 'success') {

                    }
                }
                catch (e) {
                    console.error('error', e)
                }
            },
            error: function (xhr, status) {

            },
        });
    }
}
