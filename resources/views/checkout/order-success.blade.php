@extends('layouts.app')

@section('title', 'Order Confirmed - ' . config('app.name'))

@section('content')

    <div class="order-success-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="order-success-header">
                        <div class="order-success-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        </div>
                        <h1 class="order-success-title">Order Confirmed!</h1>
                        <p class="order-success-subtitle">Thank you for your purchase. Your order has been placed successfully.</p>
                    </div>

                    @if($order)
                        <div class="order-success-card">
                            <div class="order-success-card-header">
                                <div>
                                    <span class="order-success-label">Order ID</span>
                                    <span class="order-success-value">#{{ $order->id }}</span>
                                </div>
                                <div>
                                    <span class="order-success-label">Date</span>
                                    <span class="order-success-value">{{ \Carbon\Carbon::parse($order->order_date_time)->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="order-success-label">Payment</span>
                                    <span class="order-success-value">{{ ucfirst($order->payment_method) }}</span>
                                </div>
                                <div>
                                    <span class="order-success-label">Status</span>
                                    <span class="order-success-status">{{ ucfirst($order->order_status) }}</span>
                                </div>
                            </div>

                            @if($order->order_products && $order->order_products->count() > 0)
                                <div class="order-success-items">
                                    <h6 class="order-success-items-title">Items Ordered</h6>
                                    @foreach($order->order_products as $item)
                                        <div class="order-success-item">
                                            <div class="order-success-item-info">
                                                <span class="order-success-item-name">{{ $item->product_name }}</span>
                                                <span class="order-success-item-qty">Qty: {{ $item->product_quantity }}</span>
                                            </div>
                                            <span class="order-success-item-price">${{ number_format($item->product_price, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($order->customer)
                                <div class="order-success-shipping">
                                    <h6 class="order-success-items-title">Shipping Details</h6>
                                    <p class="order-success-address">
                                        {{ $order->customer->first_name }} {{ $order->customer->last_name }}<br>
                                        {{ $order->customer->address_line_1 }}
                                        @if($order->customer->address_line_2), {{ $order->customer->address_line_2 }}@endif<br>
                                        {{ $order->customer->city }}, {{ $order->customer->state }} {{ $order->customer->postcode }}<br>
                                        {{ $order->customer->country }}
                                    </p>
                                </div>
                            @endif

                            <div class="order-success-total">
                                <span>Total</span>
                                <span>{{ $order->currency }} ${{ number_format($order->order_total, 2) }}</span>
                            </div>
                        </div>
                    @else
                        <div class="order-success-card">
                            <div class="order-success-ref">
                                <span class="order-success-label">Reference Code</span>
                                <span class="order-success-value">#{{ $reference_code }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="order-success-actions">
                        <a href="/products" class="btn btn-primary hero-btn">
                            Continue Shopping
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="ms-1" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                            </svg>
                        </a>
                        <a href="/orders" class="btn btn-outline-dark hero-btn">View Orders</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
