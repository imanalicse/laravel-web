<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->dbValidatedCart();
        if (empty($cart)) {
            return redirect()->to('/products')->with('error', 'Your cart is empty. Please add product to cart');
        }
        return view('checkout.index', compact('cart'));
    }
}
