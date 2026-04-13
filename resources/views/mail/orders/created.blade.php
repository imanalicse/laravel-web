<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background: #f4f5f7; color: #1a1a2e; }
        .wrapper { max-width: 600px; margin: 0 auto; padding: 24px 16px; }
        .card { background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #e9ecef; }
        .header { background: #1a1a2e; color: #fff; padding: 24px; text-align: center; }
        .header h1 { margin: 0 0 4px; font-size: 20px; font-weight: 700; }
        .header p { margin: 0; color: #adb5bd; font-size: 14px; }
        .icon-circle { width: 56px; height: 56px; border-radius: 50%; background: #28a745; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; }
        .body { padding: 24px; }
        .greeting { font-size: 16px; margin-bottom: 16px; }
        .info-grid { display: table; width: 100%; margin-bottom: 20px; }
        .info-row { display: table-row; }
        .info-label { display: table-cell; padding: 6px 12px 6px 0; font-size: 13px; color: #6c757d; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; width: 120px; }
        .info-value { display: table-cell; padding: 6px 0; font-size: 14px; font-weight: 600; color: #1a1a2e; }
        .divider { height: 1px; background: #e9ecef; margin: 20px 0; }
        .section-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; margin-bottom: 12px; }
        .item { display: table; width: 100%; border-bottom: 1px solid #f1f3f5; }
        .item:last-child { border-bottom: none; }
        .item-name { display: table-cell; padding: 10px 0; font-size: 14px; font-weight: 500; }
        .item-qty { display: table-cell; padding: 10px 8px; font-size: 13px; color: #6c757d; text-align: center; white-space: nowrap; }
        .item-price { display: table-cell; padding: 10px 0; font-size: 14px; font-weight: 700; text-align: right; white-space: nowrap; }
        .total-row { display: table; width: 100%; margin-top: 16px; }
        .total-label { display: table-cell; font-size: 16px; font-weight: 700; padding: 8px 0; }
        .total-value { display: table-cell; font-size: 16px; font-weight: 700; text-align: right; padding: 8px 0; }
        .address { font-size: 14px; color: #495057; line-height: 1.6; }
        .footer { text-align: center; padding: 20px 24px; font-size: 13px; color: #6c757d; }
        .btn { display: inline-block; background: #0d6efd; color: #fff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; margin-top: 8px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header">
                <div class="icon-circle">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/%3E%3C/svg%3E" alt="check" width="28" height="28">
                </div>
                <h1>Order Confirmed</h1>
                <p>Order #{{ $order->id }}</p>
            </div>

            <div class="body">
                <p class="greeting">
                    Hi {{ $order->customer?->first_name ?? 'Customer' }},<br>
                    Thank you for your order! Here's a summary of your purchase.
                </p>

                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Order ID</span>
                        <span class="info-value">#{{ $order->id }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($order->order_date_time)->format('M d, Y \a\t h:i A') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Payment</span>
                        <span class="info-value">{{ ucfirst($order->payment_method) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="info-value">{{ ucfirst($order->order_status) }}</span>
                    </div>
                </div>

                @if($order->order_products && $order->order_products->count() > 0)
                    <div class="divider"></div>
                    <div class="section-title">Items Ordered</div>
                    @foreach($order->order_products as $item)
                        <div class="item">
                            <span class="item-name">{{ $item->product_name }}</span>
                            <span class="item-qty">x{{ $item->product_quantity }}</span>
                            <span class="item-price">${{ number_format($item->product_price, 2) }}</span>
                        </div>
                    @endforeach

                    <div class="total-row">
                        <span class="total-label">Total</span>
                        <span class="total-value">{{ $order->currency }} ${{ number_format($order->order_total, 2) }}</span>
                    </div>
                @endif

                @if($order->customer)
                    <div class="divider"></div>
                    <div class="section-title">Shipping Address</div>
                    <p class="address">
                        {{ $order->customer->first_name }} {{ $order->customer->last_name }}<br>
                        {{ $order->customer->address_line_1 }}
                        @if($order->customer->address_line_2), {{ $order->customer->address_line_2 }}@endif<br>
                        {{ $order->customer->city }}, {{ $order->customer->state }} {{ $order->customer->postcode }}<br>
                        {{ $order->customer->country }}
                    </p>
                @endif

                <div class="divider"></div>
                <div style="text-align: center;">
                    <a href="{{ url('/orders') }}" class="btn">View Your Orders</a>
                </div>
            </div>

            <div class="footer">
                <p>If you have any questions, just reply to this email.</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
