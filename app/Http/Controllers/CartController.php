<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->dbValidatedCart();
        $products = $cart['products'] ?? [];
        $amount = $cart['amount'] ?? ['order_total' => 0, 'currency' => 'AUD'];

        return view('cart.index', compact('products', 'amount'));
    }

    public function removeFromCart(Request $request): \Illuminate\Http\JsonResponse
    {
        $product_id = $request->product_id;
        $cart_products = $this->cartGet('products') ?? [];

        if (isset($cart_products[$product_id])) {
            unset($cart_products[$product_id]);
            $this->cartSet('products', $cart_products);
        }

        $cart = $this->dbValidatedCart();
        return response()->json($cart);
    }

    public function addToCart(Request $request): \Illuminate\Http\JsonResponse {
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
                'name'=> $product->name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        $this->cartSet('products', $cart_products);
        $cart_products = $this->cartGet('products');
        return response()->json($cart_products);
    }
}
