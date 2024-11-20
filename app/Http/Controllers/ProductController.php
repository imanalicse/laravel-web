<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getPaginatedProducts();
        $cart_products = $this->cartGet('products');
        $cart_products_json = json_encode($cart_products);

        return view('product.index', compact('products', 'cart_products_json'));
    }

    public function show(string $id)
    {
        //
    }
}
