<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request) {
        echo '<pre>';
        print_r($request->all());
        echo '</pre>';
    }
}
