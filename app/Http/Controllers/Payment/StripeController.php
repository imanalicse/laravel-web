<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;

class StripeController extends Controller
{
    public function createPaymentIntent(): \Illuminate\Http\JsonResponse {

        $stripe_secret_key = config('services.stripe.secret');

        $stripe = new \Stripe\StripeClient([
            'api_key' => $stripe_secret_key,
            'stripe_version' => '2020-08-27',
        ]);

        $cart = $this->dbValidatedCart();
        $payable_amount = $cart['amount']['order_total'];
        $currency = $cart['amount']['currency'];

        $response = ['status' => 'error', 'message' => ''];
        try {
            $payment_reference_code = $this->generateOrderReferenceCode($cart);
            $payment_intent_data = [
                'payment_method_types' => ['card'],
                'amount' => $payable_amount * 100,
                'currency' => $currency,
                'metadata' => [
                    'reference_code' => $payment_reference_code
                ]
            ];
            $this->customLog('payment_intent_request_data: '. json_encode($payment_intent_data), 'stripe', 'stripe');
            $paymentIntent = $stripe->paymentIntents->create($payment_intent_data);
            $paymentIntent_json = json_encode($paymentIntent, JSON_UNESCAPED_SLASHES);
            $paymentIntent_arr = json_decode($paymentIntent_json, true);
            $this->customLog('payment_intent_response_data_: '. $paymentIntent_json, 'stripe', 'stripe');
            $response['intent_data'] = $paymentIntent_arr;
            $response['status'] = 'success';
        }
        catch (\Stripe\Exception\ApiErrorException $exception) {
            $error_message = $exception->getMessage();
            $response['message'] = 'Exception: '. $error_message;
            return response()->json($response, 400);
        }
        catch (\Exception $exception) {
            $error_message = $exception->getMessage();
            $response['message'] = 'Exception: '. $error_message;
            return response()->json($response, 500);
        }

        return response()->json($response);
    }
}
