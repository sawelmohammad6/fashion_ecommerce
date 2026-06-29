<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; color: #333; }
        .header { display: flex; justify-content: space-between; align-items: start; margin-bottom: 40px; }
        .title { font-size: 28px; font-weight: bold; color: #4f46e5; margin: 0; }
        .meta { font-size: 13px; color: #666; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { text-align: left; padding: 10px 12px; background: #f3f4f6; font-size: 12px; text-transform: uppercase; color: #666; }
        td { padding: 12px; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        .total-row td { font-weight: bold; border-top: 2px solid #333; }
        .grand-total td { font-size: 16px; color: #4f46e5; }
        .footer { text-align: center; font-size: 12px; color: #999; margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; }
        .address { margin-bottom: 30px; }
        @media print { body { margin: 0; } }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1 class="title">{{ config('app.name') }}</h1>
            <p class="meta">Invoice</p>
        </div>
        <div class="meta">
            <p><strong>Order #{{ $order->id }}</strong></p>
            <p>Date: {{ $order->ordered_at ? $order->ordered_at->format('d M Y') : $order->created_at->format('d M Y') }}</p>
            <p>Status: {{ ucfirst($order->status) }}</p>
        </div>
    </div>

    <div class="address">
        <p class="meta"><strong>Bill To:</strong></p>
        <p class="meta">{{ $order->customer_name }}</p>
        <p class="meta">{{ $order->phone }}</p>
        <p class="meta">{{ $order->email }}</p>
        <p class="meta">{{ $order->address }}, {{ $order->district }}, {{ $order->division }}</p>
    </div>

    <table>
        <thead>
            <tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <tr><td style="text-align:right">Subtotal</td><td style="width:120px;text-align:right">${{ number_format($order->subtotal, 2) }}</td></tr>
        <tr><td style="text-align:right">Shipping</td><td style="text-align:right">{{ $order->shipping_charge > 0 ? '$' . number_format($order->shipping_charge, 2) : 'Free' }}</td></tr>
        @if($order->discount > 0)
            <tr><td style="text-align:right">Discount</td><td style="text-align:right;color:#16a34a">-${{ number_format($order->discount, 2) }}</td></tr>
        @endif
        <tr class="grand-total"><td style="text-align:right">Grand Total</td><td style="text-align:right">${{ number_format($order->grand_total, 2) }}</td></tr>
    </table>

    <div class="footer">
        <p>{{ config('app.name') }} &mdash; Thank you for your business!</p>
    </div>

    <script>window.print();</script>
</body>
</html>