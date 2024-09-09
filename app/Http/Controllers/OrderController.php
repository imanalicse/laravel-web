<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createStripeOrder(Request $request) {
        $payment_intent = $request->payment_intent;
        if ($payment_intent['id'] && $payment_intent['status'] === "succeeded") {
            $this->customLog('payment_confirm_response: '. json_encode($payment_intent), 'stripe', 'stripe');
            try {
                $cart = $this->dbValidatedCart();
                $order = new Order();
                $order->order_total = $cart['amount']['order_total'];
                $order->currency = $cart['amount']['currency'];
                $order->order_date_time = date('Y-m-d H:i:s');
                $order->order_status = 'Processing';
                $order->payment_reference_code = $payment_intent['id'];
                $order->payment_method = PaymentMethod::STRIPE;
                $order->save();
            }
            catch (\Exception $exception) {
                $error_message = $exception->getMessage();
                $this->customLog('create_order_exception: '. $error_message);
            }
        }
    }
}
