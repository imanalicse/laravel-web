<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

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
          'address_line_1' => $request->input('address_line_1'),
          'address_line_2' => $request->input('address_line_2'),
          'country' => $request->input('country'),
          'state' => $request->input('state'),
          'city' => $request->input('city'),
          'postcode' => $request->input('postcode'),
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

    public function createStripeOrder(Request $request): \Illuminate\Http\JsonResponse {
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
                $payment_intent_id = $payment_intent['id'];
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                $paymentIntent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
                $reference_code = $paymentIntent->metadata->reference_code;
                $cart['payment_reference_code'] = $reference_code;
                $order_response = $this->orderService->createOrder($cart);
                $this->customLog('order_response: '. json_encode($order_response), 'stripe', 'stripe');
                if (!empty($order_response)) {
                    $this->cartDelete();
                }

                $return_response['status'] = 'success';
                $return_response['message'] = 'Order created';
                $return_response['redirect_url'] = '/order/success/'.$order_response;
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

    public function orderSuccess($reference_code) {
        return view('checkout.order-success', ['reference_code' => $reference_code]);
    }
}
