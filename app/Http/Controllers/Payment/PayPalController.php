<?php

namespace App\Http\Controllers\Payment;

use App\Enum\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Support\Facades\Http;

class PayPalController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function createPayPalOrder(): \Illuminate\Http\JsonResponse {
        $return_data = ['is_success' => false, 'message' => '', 'data' => []];
        try {
            $cart = $this->cartGet();
            $request_data = $this->payPalRequestData();
            if (empty($request_data)) {
                $return_data['message'] = 'Request data is empty.';
                return response()->json($return_data);
            }

            $access_token = $this->generatePapPalAccessToken();
            if (empty($access_token)) {
                $return_data['message'] = 'Unable to create access token';
                return response()->json($return_data);
            }

            $this->customLog( 'paypal_request_data: '. json_encode($request_data), 'pay_pal', 'pay_pal');

            $url = $this->getPayPalBaseUrl() . '/v2/checkout/orders';
            $response = Http::withToken($access_token)->post($url, $request_data);
            $status_code = $response->status();
            $payment_response_data = $response->json();
            $this->customLog( "paypal_response_data:$status_code: ". $response->body(), 'pay_pal', 'pay_pal');
            if ($response->successful()) {
                $return_data['is_success'] = true;
                $return_data['message'] = 'PalPal order has been created successfully';
                $return_data['data'] = $payment_response_data;
                return response()->json($return_data);
            }
            $this->customLog( 'paypal_order_response: '. $response->body(), 'pay_pal_error', 'pay_pal');
            $exception = $payment_response_data['message'] ?? 'Unable to create PayPal Order';
            $return_data['message'] = $exception;
            return response()->json($return_data);
        }
        catch (\Exception $exception) {
            $error_message = $exception->getMessage();
            $this->customLog( 'Error in createPayPalOrder: '. $exception->getMessage(), 'pay_pal_error', 'pay_pal');
            $return_data['message'] = $error_message;
            return response()->json($return_data, 500);
        }
    }

    public function capturePayPalPayment($paypal_order_id): \Illuminate\Http\JsonResponse {
        $return_response = [
            'is_success' => 0,
            'message' => 'Unknown error'
        ];
            try {

                $cart = $this->cartGet();
                $this->customLog('cart_data: ' . json_encode($cart), 'pay_pal', 'pay_pal');

                $access_token = $this->generatePapPalAccessToken();
                if (empty($access_token)) {
                    $return_response['is_success'] = 0;
                    $return_response['message'] = 'Unable to create access token';
                    return response()->json($return_response);
                }


                $url = $this->getPayPalBaseUrl() . '/v2/checkout/orders/' . $paypal_order_id . '/capture';

                $response = Http::accept('application/json')->withToken($access_token)->post($url, (object) []);
                $status_code = $response->status();
                $payment_response = $response->json();
                if (!$response->successful()) {
                    $this->customLog("pay_pal_error_response: $status_code: ". $response->body(), 'pay_pal_error', 'pay_pal');
                    $return_response['is_success'] = 0;
                    $return_response['message'] = 'Error in payment. Please try again.';
                    return response()->json($return_response);
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

                if ($payment_response['status'] === 'COMPLETED' && !empty($transaction_id)) {
                    $this->customLog('payment_completed: transaction_id=' . $transaction_id . ', amount=' . ($update_data['amount'] ?? '') . ', currency=' . ($update_data['currency'] ?? ''), 'pay_pal', 'pay_pal');
                    $return_response['is_success'] = 0;
                    $return_response['message'] = 'Payment has been approved';
                    // Create New order
                    try {
                        $userId = $cart['customer']['id'];

                        $cart['payment_reference_code'] = $transaction_id;
                        $cart['payment_method'] = PaymentMethod::PAY_PAL;
                        $order_response = $this->orderService->createOrder($cart);
                        $order_id = $order_response['data']['order_id'] ?? null;
                        if ($order_response['is_success'] && $order_id > 0) {
                            $this->cartDelete();
                            $return_response['message'] = 'Order has been created successfully';
                            $return_response['is_success'] = 1;
                            $return_response['redirect'] = '/order/success/' . $order_id;
                            return response()->json($return_response);
                        }
                        else {
                            // Payment done but not order
                            $this->customLog( 'payment_response: '. json_encode($payment_response), 'payment_but_not_order', 'pay_pal');
                            $this->customLog('cart_data: '. json_encode($cart), 'payment_but_not_order', 'pay_pal');
                            return response()->json($order_response);
                        }
                    }
                    catch (\Exception $exception) {
                        $this->customLog('create_order_exception: ' . $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine(), 'payment_but_not_order', 'pay_pal');
                        $this->customLog($exception->getTraceAsString(), 'payment_but_not_order', 'pay_pal');
                        $this->customLog('payment_response: '. json_encode($payment_response), 'payment_but_not_order', 'pay_pal');
                        $this->customLog('cart_data: '. json_encode($cart), 'payment_but_not_order', 'pay_pal');
                        $return_response['is_success'] = 0;
                        $return_response['message'] = 'Payment has been approved but order not placed. error: '. $exception->getMessage();
                        return response()->json($return_response, 500);
                    }
                }
                else {
                    $return_response['is_success'] = 0;
                    $return_response['message'] = 'Payment has been declined';
                }
            }
            catch (\Exception $exception) {
                $this->customLog('Error in capturePayPalPayment: ' . $exception->getMessage(), 'pay_pal_error', 'pay_pal');
                $return_response['is_success'] = 0;
                $return_response['message'] = 'Exception: '. $exception->getMessage();
            }

        return response()->json($return_response);
    }
}
