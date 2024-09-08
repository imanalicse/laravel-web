<?php

namespace App\Http\Controllers\Payment;

use App\Enum\PaymentMethod;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class PayPalController extends Controller
{
    public function createPayPalOrder() {

        try {
            $cart = $this->cartGet();
//            $validation_result = $this->getComponent('Order.OrderProcess')->prePaymentOrderValidation($cart);
//            if ($validation_result['status'] == 'error') {
//                echo json_encode($validation_result);
//                die();
//            }
            $request_data = $this->payPalRequestData();
            if (empty($request_data)) {
                echo json_encode(['status' => 'error', 'message' => 'Request data is empty.']);
                die();
            }

            $access_token = $this->generatePapPalAccessToken();
            if (empty($access_token)) {
                $return_response = [
                    'status' => 'error',
                    'message' => 'Unable to create access token'
                ];
                echo json_encode($return_response, JSON_UNESCAPED_SLASHES);
                die();
            }

            $this->customLog( 'paypal_request_data: '. json_encode($request_data), 'pay_pal', 'pay_pal');

            $url = $this->getPayPalBaseUrl() . '/v2/checkout/orders';
            $response = Http::withToken($access_token)->post($url, $request_data);
            $status_code = $response->status();
            $response_data = $response->json();
            $this->customLog( "paypal_response_data:$status_code: ". $response->body(), 'pay_pal', 'pay_pal');
            if ($response->successful()) {
                $return_response = [
                    'status' => 'success',
                    'message' => 'PalPal order has been created successfully',
                    'data' => $response_data
                ];
                echo json_encode($return_response, JSON_UNESCAPED_SLASHES);
                die();
            }
            $this->customLog( 'paypal_order_response: '. $response->body(), 'pay_pal_error', 'pay_pal');
            $exception = $response_data['message'] ?? 'Unable to create PayPal Order';
            $return_response = [
                'status' => 'error',
                'message' => $exception
            ];
            echo json_encode($return_response, JSON_UNESCAPED_SLASHES);
            die();
        }
        catch (\Exception $exception) {
            $error_message = $exception->getMessage();
            $this->customLog( 'Error in createPayPalOrder: '. $exception->getMessage(), 'pay_pal_error', 'pay_pal');
            $return_response = [
                'status' => 'error',
                'message' => $error_message
            ];
            echo json_encode($return_response, JSON_UNESCAPED_SLASHES);
            die();
        }
    }

    public function capturePayPalPayment($paypal_order_id) {
        $return_response = [
            'status' => 'error',
            'message' => 'Unknown error'
        ];
            try {

                $cart = $this->cartGet();
//                $order_code_id = $cart['payment']['securepay_order_id'];
//                $cart = $this->getComponent('CommonFunction')->getCartFromDbByOrderCodeId($order_code_id);
//
//                $validation_result = $this->getComponent('Order.OrderProcess')->prePaymentOrderValidation($cart);
//                if ($validation_result['status'] == 'error') {
//                    echo json_encode($validation_result);
//                    die();
//                }

                $access_token = $this->generatePapPalAccessToken();
                if (empty($access_token)) {
                    $return_response['status'] = 'error';
                    $return_response['message'] = 'Unable to create access token';
                    echo json_encode($return_response);
                    die();
                }


                $url = $this->getPayPalBaseUrl() . '/v2/checkout/orders/' . $paypal_order_id . '/capture';
                /*
                $http = new Client();
                $headers = $this->getPayPalHeader($access_token);
                $response = $http->post($url, [], [
                    'headers' => $headers,
                ]);
                $status_code = $response->getStatusCode();
                $response_data = $response->getJson();
                */

                $response = Http::accept('application/json')->withToken($access_token)->post($url);
                $status_code = $response->status();
                $payment_response = $response->json();
                $response->onError(function(){
                    echo 'aaa';
                });
                if (!$response->successful()) {
                    $this->customLog("pay_pal_error_response: $status_code: ". $response->body(), 'pay_pal_error', 'pay_pal');
                    $return_response['status'] = 'error';
                    $return_response['message'] = 'Error in payment. Please try again.';
                    echo json_encode($return_response);
                    die();
                }

                $this->customLog('capture_pay_pal_payment_response:'. $response->body(), 'pay_pal', 'pay_pal');

                $purchase_unit = $payment_response['purchase_units'][0];
                $transaction = $purchase_unit['payments']['captures'][0];
                $merchant_reference_id = $purchase_unit['reference_id'];
                $transaction_id = $transaction['id'];

                $update_data = [];
                $update_data['order_code_id'] = $merchant_reference_id;
                $update_data['transaction_id'] = $transaction_id;
                $update_data['transaction_type'] = 'CAPTURED';
                $update_data['payment_status_text'] = $transaction['status'];
                $update_data['amount'] = $transaction['amount']['value'];
                $update_data['currency'] = $transaction['amount']['currency_code'];
                $update_data['payment_details'] = json_encode($payment_response);
                $update_data['payment_at'] = date('Y-m-d H:i:s', strtotime($transaction['create_time']));
                // $saved_payment = $this->getComponent("Payment")->updatePaymentByOrderCodeId($merchant_reference_id, $update_data);
                // $this->customLog('saved_pay_pal_payment:'. json_encode($saved_payment), 'pay_pal', 'pay_pal');

                if ($payment_response['status'] === 'COMPLETED' && !empty($transaction_id)) {
                    $return_response['status'] = 'error';
                    $return_response['message'] = 'Payment has been approved';
                    // Create New order
                    try {
                        $userId = $cart['customer']['id'];

                        $cart['payment']['payment_reference_number'] = $transaction_id;
                        $order_response = $this->createOrder($cart);
                        if ($order_response['status'] && isset($order_response['order_id']) && $order_response['order_id'] > 0) {
                            $order_id = $order_response['order_id'];
                            $update_data = [];
                            $update_data['order_id'] = $order_id;
                            $update_data['order_status'] = 1;
                            // $update_response = $this->getComponent("Payment")->updatePaymentByOrderCodeId($merchant_reference_id, $update_data);
                            if (!empty($update_response)) {
                                $return_response['message'] = 'Order has been created successfully';
                            }
                            else {
                                $this->customLog('Payment and order create but unable to update payment record: ' . json_encode($payment_response), 'order_error', 'pay_pal');
                                $this->customLog('cart_data: '. json_encode($cart), 'order_error', 'pay_pal');
                                $return_response['message'] = 'Order created but unable to update payment record';
                            }
                            $return_response['status'] = 'success';
                            $return_response['redirect'] = ''; // $this->generateUrl('/checkout/success');
                            echo json_encode($return_response);
                            die();
                        }
                        else {
                            // Payment done but not order
                            $this->customLog( 'payment_response: '. json_encode($payment_response), 'payment_but_not_order', 'pay_pal');
                            $this->customLog('cart_data: '. json_encode($cart), 'payment_but_not_order', 'pay_pal');
                            echo json_encode($order_response);
                            die();
                        }
                    }
                    catch (\Exception $exception) {
                        $this->customLog('payment_response: '. json_encode($payment_response), 'payment_but_not_order', 'pay_pal');
                        $this->customLog('cart_data: '. json_encode($cart), 'payment_but_not_order', 'pay_pal');
                        $return_response['status'] = 'error';
                        $return_response['message'] = 'Payment has been approved but order not placed. error: '. $exception->getMessage();
                        echo json_encode($return_response);
                        die();
                    }
                }
                else {
                    $return_response['status'] = 'error';
                    $return_response['message'] = 'Payment has been declined';
                }
            }
            catch (\Exception $exception) {
                $this->customLog('Error in capturePayPalPayment: ' . $exception->getMessage(), 'pay_pal_error', 'pay_pal');
                $return_response['status'] = 'error';
                $return_response['message'] = 'Exception: '. $exception->getMessage();
            }

        echo json_encode($return_response);
        die();
    }
}
