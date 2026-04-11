@extends('layouts.app')

@section('title', 'Shop - ' . config('app.name'))

@section('content')

    <span class="cart_products_json d-none">{{$cart_products_json}}</span>

    {{-- Page header --}}
    <div class="shop-header">
        <div class="container">
            <h1 class="shop-title">Our Products</h1>
            <p class="shop-subtitle">Browse our collection of quality products</p>
        </div>
    </div>

    <div class="container py-4">
        <div class="product-grid">
            @forelse($products as $product)
                <div class="product-card" id="product-{{$product['id']}}">
                    <div class="product-card-img">
                        <img src="https://cdn.shopify.com/s/files/1/2303/2711/files/2_e822dae0-14df-4cb8-b145-ea4dc0966b34.jpg?v=1617059123" alt="{{ $product->name }}"/>
                    </div>
                    <div class="product-card-body">
                        <h5 class="product-card-title">{{ $product->name }}</h5>
                        <p class="product-card-price">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="product-card-footer">
                        <div class="add-to-cart-box" data-product_id="{{$product['id']}}">
                            <button class="btn btn-primary cart-btn-width add-to-cart-btn js-btn-add-cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                    <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                </svg>
                                Add to Cart
                            </button>
                            <div class="cart-added-box btn-group cart-btn-width d-none">
                                <button class="btn btn-outline-primary cart-decrease-action">-</button>
                                <button class="btn btn-outline-primary added-in-cart"><span class="quantity">1</span> in cart</button>
                                <button class="btn btn-outline-primary cart-increase-action">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793z"/>
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg>
                    <p>No products available yet.</p>
                    <a href="/" class="btn btn-primary">Back to Home</a>
                </div>
            @endforelse
        </div>

        @if(!empty($products) && $products->hasPages())
            <div class="shop-pagination">
                {{$products->links()}}
            </div>
        @endif
    </div>
@endsection
