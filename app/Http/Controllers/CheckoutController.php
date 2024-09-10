<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->dbValidatedCart();
        if (empty($cart)) {
            return redirect()->to('/products')->with('error', 'Your cart is empty. Please add product to cart');
        }
        if (!Auth::check()) {
            return redirect()->to('/login');
        }
        $user = Auth::user();
        return view('checkout.index', compact('cart', 'user'));
    }

    public function checkout(Request $request): \Illuminate\Http\JsonResponse
    {

        $validated = $request->validate([
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email'=> 'required|email',
            'address_line_1'=> 'required',
            'country'=> 'required'
        ]);

        $customer = [
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->last_name,
          'phone' => $request->phone,
        ];

        $user = Auth::user();
        if (!empty($user)) {
            $customer['id'] = $user['id'];
        }

        $this->cartSet('customer', $customer);

        return response()->json([
            'status'=>'success',
            'user'=> $user
        ], 200);

    }

    public function createStripeOrder(Request $request) {
        $return_response = [
            'status' => 'error',
            'message' => 'Something went wrong',
            'redirect_url' => '',
        ];
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
                $return_response['status'] = 'success';
                $return_response['message'] = 'Order created';
                $return_response['redirect_url'] = '/order/success';
            }
            catch (\Exception $exception) {
                $error_message = $exception->getMessage();
                $this->customLog('create_order_exception: '. $error_message);
                $return_response['message'] = 'Order create exception: '. $error_message;
            }
        }
        else {
            $return_response['message'] = 'Payment is not successful.';
        }
        return response()->json($return_response);
    }

    public function orderSuccess() {
        return view('checkout.order-success');
    }
}
