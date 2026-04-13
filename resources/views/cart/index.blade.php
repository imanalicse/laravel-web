@extends('layouts.app')

@section('title', 'Shopping Cart - ' . config('app.name'))

@section('content')

    <div class="cart-page">
        <div class="container">
            <h1 class="cart-page-title">Shopping Cart</h1>

            @if(!empty($products))
                <div class="row g-4">
                    {{-- Cart Items --}}
                    <div class="col-lg-8">
                        <div class="cart-items">
                            <div class="cart-items-header d-none d-md-flex">
                                <span class="cart-col-product">Product</span>
                                <span class="cart-col-price">Price</span>
                                <span class="cart-col-qty">Quantity</span>
                                <span class="cart-col-total">Total</span>
                                <span class="cart-col-action"></span>
                            </div>

                            @foreach($products as $product)
                                <div class="cart-item" id="cart-item-{{ $product['id'] }}">
                                    <div class="cart-col-product">
                                        <div class="cart-item-img">
                                            <img src="https://cdn.shopify.com/s/files/1/2303/2711/files/2_e822dae0-14df-4cb8-b145-ea4dc0966b34.jpg?v=1617059123" alt="{{ $product['name'] }}">
                                        </div>
                                        <div class="cart-item-info">
                                            <h6 class="cart-item-name">{{ $product['name'] }}</h6>
                                            <span class="cart-item-price-mobile d-md-none">${{ number_format($product['price'], 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="cart-col-price d-none d-md-flex">
                                        ${{ number_format($product['price'], 2) }}
                                    </div>
                                    <div class="cart-col-qty">
                                        <div class="cart-qty-control" data-product_id="{{ $product['id'] }}">
                                            <button class="cart-qty-btn js-cart-decrease" type="button">-</button>
                                            <span class="cart-qty-value">{{ $product['quantity'] }}</span>
                                            <button class="cart-qty-btn js-cart-increase" type="button">+</button>
                                        </div>
                                    </div>
                                    <div class="cart-col-total">
                                        $<span class="js-item-total">{{ number_format($product['product_total'], 2) }}</span>
                                    </div>
                                    <div class="cart-col-action">
                                        <button class="cart-remove-btn js-cart-remove" data-product_id="{{ $product['id'] }}" type="button" title="Remove item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="cart-actions-row">
                            <a href="/products" class="btn btn-outline-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                                </svg>
                                Continue Shopping
                            </a>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h5 class="cart-summary-title">Order Summary</h5>

                            <div class="cart-summary-row">
                                <span>Subtotal</span>
                                <span class="js-cart-subtotal">${{ number_format($amount['order_total'], 2) }}</span>
                            </div>
                            <div class="cart-summary-row">
                                <span>Shipping</span>
                                <span class="text-success">Free</span>
                            </div>

                            <div class="cart-summary-divider"></div>

                            <div class="cart-summary-row cart-summary-total">
                                <span>Total</span>
                                <span class="js-cart-total">{{ $amount['currency'] }} ${{ number_format($amount['order_total'], 2) }}</span>
                            </div>

                            <a href="/checkout" class="btn btn-primary w-100 cart-checkout-btn">
                                Proceed to Checkout
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                </svg>
                            </a>

                            <div class="cart-summary-secure">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                                </svg>
                                Secure SSL Encrypted Checkout
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="cart-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added any items to your cart yet.</p>
                    <a href="/products" class="btn btn-primary btn-lg hero-btn">Start Shopping</a>
                </div>
            @endif
        </div>
    </div>

@endsection
