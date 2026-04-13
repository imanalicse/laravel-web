@extends('layouts.app')

@section('title', 'My Account - ' . config('app.name'))

@section('content')

    <div class="profile-page">
        <div class="container">
            <h1 class="profile-page-title">My Account</h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                {{-- Profile Info --}}
                <div class="col-lg-4">
                    <div class="profile-card">
                        <div class="profile-avatar">
                            <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <h4 class="profile-name">{{ $user->name }}</h4>
                        <span class="profile-email">{{ $user->email }}</span>

                        <div class="profile-meta">
                            <div class="profile-meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2"/>
                                </svg>
                                <span>Member since {{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="profile-meta-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7z"/>
                                </svg>
                                <span>{{ $orders->count() }} {{ Str::plural('order', $orders->count()) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="btn btn-primary w-100 profile-edit-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>

                {{-- Recent Orders --}}
                <div class="col-lg-8">
                    <div class="profile-orders">
                        <div class="profile-orders-header">
                            <h5 class="profile-orders-title">Recent Orders</h5>
                            @if($orders->count() > 0)
                                <a href="/orders" class="profile-orders-link">View all</a>
                            @endif
                        </div>

                        @if($orders->count() > 0)
                            <div class="profile-orders-list">
                                @foreach($orders as $order)
                                    <div class="profile-order-item">
                                        <div class="profile-order-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.929 1.757a.5.5 0 1 0-.858-.514L2.217 6H.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h.623l1.844 6.456A.75.75 0 0 0 3.69 15h8.622a.75.75 0 0 0 .722-.544L14.877 8h.623a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1.717L10.93 1.243a.5.5 0 1 0-.858.514L12.617 6H3.383zM4 10a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm3 0a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm4-1a1 1 0 0 1 1 1v2a1 1 0 1 1-2 0v-2a1 1 0 0 1 1-1"/>
                                            </svg>
                                        </div>
                                        <div class="profile-order-details">
                                            <div class="profile-order-top">
                                                <span class="profile-order-ref">#{{ $order->payment_reference_code }}</span>
                                                <span class="profile-order-status profile-order-status--{{ strtolower($order->order_status ?? 'pending') }}">
                                                    {{ ucfirst($order->order_status ?? 'Pending') }}
                                                </span>
                                            </div>
                                            <div class="profile-order-bottom">
                                                <span class="profile-order-date">{{ \Carbon\Carbon::parse($order->order_date_time)->format('M d, Y') }}</span>
                                                <span class="profile-order-method">{{ ucfirst($order->payment_method) }}</span>
                                                <span class="profile-order-total">{{ $order->currency }} ${{ number_format($order->order_total, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="profile-orders-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M5.929 1.757a.5.5 0 1 0-.858-.514L2.217 6H.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h.623l1.844 6.456A.75.75 0 0 0 3.69 15h8.622a.75.75 0 0 0 .722-.544L14.877 8h.623a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1.717L10.93 1.243a.5.5 0 1 0-.858.514L12.617 6H3.383zM4 10a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm3 0a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm4-1a1 1 0 0 1 1 1v2a1 1 0 1 1-2 0v-2a1 1 0 0 1 1-1"/>
                                </svg>
                                <h6>No orders yet</h6>
                                <p>When you place an order, it will appear here.</p>
                                <a href="/products" class="btn btn-primary hero-btn">Start Shopping</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
