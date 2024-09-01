<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
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
}
