<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);
        $cart_products = $this->cartGet('products');
        $cart_products_json = json_encode($cart_products);

        return view('product.index', compact('products', 'cart_products_json'));
    }

    public function show(string $id)
    {
        //
    }
}
