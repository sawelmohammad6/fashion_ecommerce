@extends('admin.layouts.app')
@section('title', 'Order #' . $order->id)
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Orders', 'url' => route('admin.orders.index')], ['label' => 'Order #' . $order->id]]" />
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="glass-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-white">Order Items</h2>
                <x-admin::status-badge :status="$order->status" type="order" />
            </div>
            <div class="divide-y divide-white/5">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between py-3 first:pt-0 last:pb-0">
                        <div class="flex items-center gap-3">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-sm">👕</div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-white/80">{{ $item->product->name ?? 'Product' }}</p>
                                <p class="text-xs text-white/30">Qty: {{ $item->quantity }} x {{ formatPrice($item->price) }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-white">{{ formatPrice($item->price * $item->quantity) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-white/5 mt-4 pt-4 space-y-1 text-sm">
                <div class="flex justify-between"><span class="text-white/40">Subtotal</span><span class="text-white/70">{{ formatPrice($order->subtotal) }}</span></div>
                <div class="flex justify-between"><span class="text-white/40">Shipping</span><span class="text-white/70">{{ formatPrice($order->shipping_charge) }}</span></div>
                @if($order->discount > 0)<div class="flex justify-between"><span class="text-white/40">Discount</span><span class="text-emerald-400">-{{ formatPrice($order->discount) }}</span></div>@endif
                <div class="flex justify-between text-base font-bold pt-2 border-t border-white/5"><span class="text-white">Grand Total</span><span class="text-emerald-400">{{ formatPrice($order->grand_total) }}</span></div>
            </div>
        </div>
        @if($order->notes)
        <div class="glass-card p-6">
            <h3 class="text-sm font-semibold text-white/80 mb-2">Order Notes</h3>
            <p class="text-sm text-white/50">{{ $order->notes }}</p>
        </div>
        @endif
    </div>
    <div class="space-y-6">
        <div class="glass-card p-6">
            <h3 class="text-sm font-semibold text-white/80 mb-4">Customer Details</h3>
            <div class="space-y-2 text-sm">
                <p class="flex justify-between"><span class="text-white/40">Name</span><span class="text-white/70">{{ $order->customer_name }}</span></p>
                <p class="flex justify-between"><span class="text-white/40">Email</span><span class="text-white/70">{{ $order->email }}</span></p>
                <p class="flex justify-between"><span class="text-white/40">Phone</span><span class="text-white/70">{{ $order->phone }}</span></p>
                <p class="flex justify-between"><span class="text-white/40">Address</span><span class="text-white/70 text-right max-w-[200px]">{{ $order->address }}, {{ $order->upazila }}, {{ $order->district }}</span></p>
            </div>
        </div>
        <div class="glass-card p-6">
            <h3 class="text-sm font-semibold text-white/80 mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-white/40 mb-1">Order Status</label>
                    <select name="status" class="select-glass w-full">
                        @foreach(['pending','confirmed','processing','shipped','delivered','cancelled','returned'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-white/40 mb-1">Payment Status</label>
                    <select name="payment_status" class="select-glass w-full">
                        @foreach(['pending','paid','failed','refunded'] as $ps)
                            <option value="{{ $ps }}" {{ $order->payment_status === $ps ? 'selected' : '' }}>{{ ucfirst($ps) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary w-full justify-center">Update Order</button>
            </form>
        </div>
        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="btn-secondary w-full justify-center">Print Invoice</a>
    </div>
</div>
@endsection
