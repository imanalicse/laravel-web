<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);

        return view('product.index', compact('products'));
    }

    public function show(string $id)
    {
        //
    }
}
