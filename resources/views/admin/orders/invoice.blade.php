<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Invoice #{{ $order->invoice_no ?? $order->id }} - {{ config('app.name') }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: system-ui, -apple-system, sans-serif; background: #0f172a; color: #e2e8f0; padding: 40px; max-width: 900px; margin: auto; }
    .invoice { border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 40px; background: rgba(255,255,255,0.02); }
    .top { display: flex; justify-content: space-between; align-items: start; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 2px solid rgba(16,185,129,0.3); }
    .store-name { font-size: 24px; font-weight: 800; color: #10b981; letter-spacing: -0.5px; }
    .store-name span { color: #64748b; font-weight: 400; font-size: 12px; display: block; margin-top: 2px; }
    .invoice-title { font-size: 32px; font-weight: 800; color: #f1f5f9; letter-spacing: 2px; margin-top: 6px; }
    .badge { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 11px; font-weight: 600; background: rgba(16,185,129,0.15); color: #34d399; }
    .meta { color: rgba(255,255,255,0.4); font-size: 13px; line-height: 1.8; }
    .meta strong { color: #e2e8f0; }
    .section { margin-bottom: 24px; }
    .section-title { font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; margin: 16px 0; }
    th { text-align: left; padding: 10px 8px; color: rgba(255,255,255,0.4); border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
    td { padding: 10px 8px; border-bottom: 1px solid rgba(255,255,255,0.04); }
    .totals { width: 320px; margin-left: auto; margin-top: 12px; }
    .totals td { padding: 5px 8px; border: none; }
    .totals tr:last-child td { padding-top: 10px; border-top: 2px solid rgba(16,185,129,0.3); font-size: 18px; font-weight: 700; }
    .footer { text-align: center; margin-top: 32px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05); color: rgba(255,255,255,0.2); font-size: 11px; }

    @media print {
        body { background: white; color: #1e293b; padding: 20px; }
        .invoice { background: white; border-color: #e2e8f0; }
        .store-name span { color: #94a3b8; }
        .invoice-title { color: #0f172a; }
        .meta { color: #94a3b8; }
        .meta strong { color: #1e293b; }
        .section-title { color: #94a3b8; }
        .badge { background: #d1fae5; color: #059669; }
        th { color: #64748b; border-color: #e2e8f0; }
        td { border-color: #f1f5f9; }
        .footer { color: #94a3b8; }
    }
</style>
</head>
<body>
<div class="invoice">
    <div class="top">
        <div>
            <div class="store-name">{{ config('app.name') }}<span>Ecommerce Store</span></div>
            <div class="invoice-title">INVOICE</div>
        </div>
        <div style="text-align:right;">
            <span class="badge">{{ strtoupper($order->status) }}</span>
            <div class="meta" style="margin-top: 10px;">
                <strong>Invoice #:</strong> {{ $order->invoice_no ?? 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}<br>
                <strong>Date:</strong> {{ $order->ordered_at?->format('M d, Y') ?? $order->created_at->format('M d, Y') }}<br>
                <strong>Order ID:</strong> #{{ $order->id }}
            </div>
        </div>
    </div>

    <div class="grid-2 section">
        <div>
            <div class="section-title">Bill To</div>
            <div class="meta">
                <strong>{{ $order->customer_name }}</strong><br>
                {{ $order->email }}<br>
                {{ $order->phone }}<br>
                {{ $order->address }}<br>
                {{ $order->city ?? $order->district }}, {{ $order->country ?? $order->division }} {{ $order->postal_code }}
            </div>
        </div>
        <div style="text-align:right;">
            <div class="section-title">Store Information</div>
            <div class="meta">
                <strong>{{ config('app.name') }}</strong><br>
                {{ config('app.url') }}<br>
                @if(config('mail.from.address')){{ config('mail.from.address') }}@endif
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Order Items</div>
        <table>
            <thead>
                <tr><th style="width:50%">Item</th><th style="text-align:center">Price</th><th style="text-align:center">Qty</th><th style="text-align:right">Total</th></tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                    <td style="text-align:center">{{ formatPrice($item->price) }}</td>
                    <td style="text-align:center">{{ $item->quantity }}</td>
                    <td style="text-align:right;font-weight:600;color:#34d399">{{ formatPrice($item->price * $item->quantity) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Payment Information</div>
        <div class="meta" style="margin-bottom: 12px;">
            <strong>Method:</strong> {{ str_replace('_', ' ', ucfirst($order->payment_method ?? 'N/A')) }} &bull;
            <strong>Status:</strong> {{ ucfirst($order->payment_status ?? 'N/A') }}
            @if($order->transaction_id) &bull; <strong>Transaction:</strong> {{ $order->transaction_id }}@endif
        </div>
    </div>

    <table class="totals">
        <tr><td>Subtotal</td><td style="text-align:right">{{ formatPrice($order->subtotal) }}</td></tr>
        @if($order->tax > 0)<tr><td>Tax</td><td style="text-align:right">{{ formatPrice($order->tax) }}</td></tr>@endif
        <tr><td>Shipping</td><td style="text-align:right">{{ formatPrice($order->shipping_charge) }}</td></tr>
        @if($order->discount > 0)<tr><td style="color:#34d399">Discount</td><td style="text-align:right;color:#34d399">-{{ formatPrice($order->discount) }}</td></tr>@endif
        @if($order->coupon_code)<tr><td style="color:#818cf8">Coupon ({{ $order->coupon_code }})</td><td style="text-align:right;color:#818cf8">-{{ formatPrice($order->discount) }}</td></tr>@endif
        <tr><td style="color:#e2e8f0">Grand Total</td><td style="text-align:right;color:#10b981">{{ formatPrice($order->grand_total) }}</td></tr>
    </table>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>{{ config('app.name') }} &mdash; All rights reserved.</p>
    </div>
</div>
<script>window.print();</script>
</body>
</html>
