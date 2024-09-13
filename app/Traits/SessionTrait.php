<?php
namespace App\Traits;

use App\Models\Product;

trait SessionTrait {

    public function sessionRead(string $key, $default = null) {
        return session()->get($key, $default);
    }

    public function sessionWrite(string $key, $value) {
        session()->put($key, $value);
    }

    public function sessionDelete(string $key) {
        session()->forget($key);
    }

    public function cartGet(string $sub_key = '', $default = null) {
        if (empty($sub_key)) {
            $cart = $this->sessionRead('cart', $default);
        }
        else {
            $cart = $this->sessionRead('cart.'.$sub_key, $default);
        }
        return $cart;
    }

    public function cartSet(string $sub_key, $value) {
        $this->sessionWrite('cart.' .$sub_key, $value);
    }

    public function cartDelete() {
        $this->sessionDelete('cart');
    }

    public function dbValidatedCart() {
        $order_total = 0;
        $new_cart_products = [];
        $cart = $this->cartGet();
        if (!empty($cart)) {
            $cart_products = $cart['products'] ?? [];
            $product_ids = array_column($cart_products, 'id');
            $products = Product::whereIn('id', $product_ids)->get();

            if (!empty($products)) {
                foreach ($products as $product) {
                    $product_id = $product['id'];
                    $price = floatval($product['price']);

                    $p = $cart_products[$product_id];
                    $quantity = $p['quantity'];
                    $product_total = $price * $quantity;
                    $new_cart_products[$product_id] = [
                        'id' => $product_id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $p['quantity'],
                        'product_total' => $product_total
                    ];

                    $order_total += $product_total;
                }
            }
            $this->cartSet('products', $new_cart_products);
            $this->cartSet('amount.order_total', $order_total);
            $this->cartSet('amount.currency', 'AUD');
        }
        return $this->cartGet();
    }
}
