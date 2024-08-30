<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request) {
        $product_id = $request->product_id;
        $action_type = $request->action_type;
        $product = Product::find($product_id);
        $cart_products = $this->cartGet('products');
        if (isset($cart_products[$product_id])) {
            if ($action_type == 'decrease') {
                $cart_products[$product_id]['quantity']--;
                if ($cart_products[$product_id]['quantity'] == 0) {
                    unset($cart_products[$product_id]);
                }
            }
            else {
                $cart_products[$product_id]['quantity']++;
            }
        }
        else {
            $cart_products[$product_id] = [
                'id' => $product->id,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        $this->cartSet('products', $cart_products);
        $cart_products = $this->cartGet('products');
        return response()->json($cart_products);
    }
}
