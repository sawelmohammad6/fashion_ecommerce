@extends('admin.layouts.app')
@section('title', $customer->name)
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Customers', 'url' => route('admin.customers.index')], ['label' => $customer->name]]" />
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="glass-card p-6 text-center lg:col-span-1">
        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-2xl font-bold text-white mx-auto mb-4">{{ substr($customer->name, 0, 1) }}</div>
        <h2 class="text-lg font-bold text-white">{{ $customer->name }}</h2>
        <p class="text-sm text-white/50">{{ $customer->email }}</p>
        <p class="text-sm text-white/50 mt-1">{{ $customer->phone ?? 'No phone' }}</p>
        <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-white/5">
            <div><p class="text-2xl font-bold text-emerald-400">{{ $orderCount }}</p><p class="text-xs text-white/40">Orders</p></div>
            <div><p class="text-2xl font-bold text-white">{{ formatPrice($totalSpent) }}</p><p class="text-xs text-white/40">Total Spent</p></div>
        </div>
    </div>
    <div class="lg:col-span-2 glass-card p-6">
        <h3 class="text-sm font-semibold text-white/80 mb-4">Order History</h3>
        <div class="space-y-3">
            @forelse($customer->orders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-3 rounded-xl bg-white/5 hover:bg-white/10 transition">
                    <div><p class="text-sm font-medium text-white/80">#{{ $order->id }} - {{ formatPrice($order->grand_total) }}</p><p class="text-xs text-white/30">{{ $order->created_at->format('M d, Y') }}</p></div>
                    <x-admin::status-badge :status="$order->status" type="order" />
                </a>
            @empty
                <p class="text-sm text-white/30 text-center py-4">No orders yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
