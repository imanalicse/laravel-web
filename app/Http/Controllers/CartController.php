<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request) {

        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $cart_products = $this->cartGet('products');
        if (isset($cart[$product_id])) {
            $cart_products[$product_id]['quantity']++;
        }
        else {
            $cart_products[$product_id] = [
                'id' => $product->id,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        $this->cartSet('products', $cart_products);
        $cart = $this->cartGet();
    }
}
