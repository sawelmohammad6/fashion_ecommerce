<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>Invoice #{{ $order->id }} - {{ config('app.name') }}</title>
<style>body{font-family:sans-serif;background:#0f172a;color:#e2e8f0;padding:40px;max-width:800px;margin:auto}.invoice{border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:40px;background:rgba(255,255,255,0.02)}h1{font-size:28px;color:#10b981;margin:0 0 4px}.header{display:flex;justify-content:space-between;align-items:start;margin-bottom:32px}.meta{color:rgba(255,255,255,0.4);font-size:14px;line-height:1.8}table{width:100%;border-collapse:collapse;font-size:14px}th{text-align:left;padding:12px 8px;color:rgba(255,255,255,0.4);border-bottom:1px solid rgba(255,255,255,0.1);font-size:12px;text-transform:uppercase;letter-spacing:0.5px}td{padding:12px 8px;border-bottom:1px solid rgba(255,255,255,0.05)}.total-row td{font-weight:bold;border-top:2px solid rgba(16,185,129,0.3)}.footer{text-align:center;margin-top:32px;color:rgba(255,255,255,0.3);font-size:12px}.badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:12px;background:rgba(16,185,129,0.15);color:#34d399}@media print{body{background:white;color:#1e293b;padding:20px}.invoice{background:white;border-color:#e2e8f0}.meta{color:#94a3b8}th{color:#64748b}td{border-color:#f1f5f9}.badge{background:#d1fae5;color:#059669}.footer{color:#94a3b8}h1{color:#059669}}</style></head>
<body>
<div class="invoice">
    <div class="header">
        <div><h1>{{ config('app.name') }}</h1><p style="color:rgba(255,255,255,0.3);margin:2px 0 0">Invoice</p></div>
        <div style="text-align:right"><span class="badge">{{ ucfirst($order->status) }}</span><p class="meta" style="margin-top:8px">Date: {{ $order->created_at->format('M d, Y') }}</p></div>
    </div>
    <div style="display:flex;justify-content:space-between;margin-bottom:32px">
        <div class="meta"><strong style="color:#e2e8f0">Bill To:</strong><br>{{ $order->customer_name }}<br>{{ $order->email }}<br>{{ $order->phone }}</div>
        <div class="meta" style="text-align:right"><strong style="color:#e2e8f0">Order ID:</strong><br>#{{ $order->id }}<br>{{ $order->address }}, {{ $order->upazila }}<br>{{ $order->district }}, {{ $order->postal_code }}</div>
    </div>
    <table><thead><tr><th>Item</th><th>Price</th><th>Qty</th><th style="text-align:right">Total</th></tr></thead>
        <tbody>
            @foreach($order->items as $item)
            <tr><td>{{ $item->product->name ?? 'Product' }}</td><td>{{ formatPrice($item->price) }}</td><td>{{ $item->quantity }}</td><td style="text-align:right">{{ formatPrice($item->price * $item->quantity) }}</td></tr>
            @endforeach
        </tbody>
    </table>
    <div style="width:300px;margin-left:auto;margin-top:16px">
        <div style="display:flex;justify-content:space-between;color:rgba(255,255,255,0.5);font-size:14px;padding:4px 0"><span>Subtotal</span><span>{{ formatPrice($order->subtotal) }}</span></div>
        <div style="display:flex;justify-content:space-between;color:rgba(255,255,255,0.5);font-size:14px;padding:4px 0"><span>Shipping</span><span>{{ formatPrice($order->shipping_charge) }}</span></div>
        @if($order->discount > 0)<div style="display:flex;justify-content:space-between;color:#34d399;font-size:14px;padding:4px 0"><span>Discount</span><span>-{{ formatPrice($order->discount) }}</span></div>@endif
        <div style="display:flex;justify-content:space-between;font-size:18px;font-weight:bold;padding:8px 0;border-top:2px solid rgba(16,185,129,0.3);margin-top:4px"><span style="color:#e2e8f0">Total</span><span style="color:#10b981">{{ formatPrice($order->grand_total) }}</span></div>
    </div>
    <div class="footer"><p>Thank you for your business!</p></div>
</div>
<script>window.print();</script>
</body>
</html>
