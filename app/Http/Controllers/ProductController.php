<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getPaginatedProducts(10);
// dd($products);
        //$products = Product::orderBy('id', 'desc')->paginate(10);
        $cart_products = $this->cartGet('products');
        $cart_products_json = json_encode($cart_products);

        return view('product.index', compact('products', 'cart_products_json'));
    }

    public function show(string $id)
    {
        //
    }
}
