@extends('layouts.admin')
@section('title', 'Orders')
@push('styles')
<style>
.status-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; margin-right: 6px; }
</style>
@endpush
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Orders']]" />

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Orders</h1>
        <p class="text-sm text-gray-400 mt-1">Manage customer orders</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.orders.export.csv') }}" class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            CSV
        </a>
        <a href="{{ route('admin.orders.export.excel') }}" class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Excel
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:border-gray-700 transition">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</p>
        <p class="text-xl font-bold text-white mt-1">{{ $totalOrders }}</p>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:border-gray-700 transition">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pending</p>
        <p class="text-xl font-bold text-amber-400 mt-1">{{ $pendingOrders }}</p>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:border-gray-700 transition">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Delivered</p>
        <p class="text-xl font-bold text-emerald-400 mt-1">{{ $deliveredOrders }}</p>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:border-gray-700 transition">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Cancelled</p>
        <p class="text-xl font-bold text-red-400 mt-1">{{ $cancelledOrders }}</p>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:border-gray-700 transition">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Today Orders</p>
        <p class="text-xl font-bold text-blue-400 mt-1">{{ $todayOrders }}</p>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-4 hover:border-gray-700 transition">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Today Revenue</p>
        <p class="text-xl font-bold text-emerald-400 mt-1">{{ formatPrice($todayRevenue) }}</p>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="bg-gray-900/50 border border-gray-800 rounded-xl p-5 mb-6">
    <div class="flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ID, invoice, name, phone..." class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Order Status</label>
            <select name="status" class="bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">All Statuses</option>
                @foreach($statuses as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Payment Status</label>
            <select name="payment_status" class="bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">All Payments</option>
                @foreach($paymentStatuses as $ps)
                    <option value="{{ $ps }}" {{ request('payment_status') === $ps ? 'selected' : '' }}>{{ ucfirst($ps) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Payment Method</label>
            <select name="payment_method" class="bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="">All Methods</option>
                @foreach($paymentMethods as $key => $label)
                    <option value="{{ $key }}" {{ request('payment_method') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Sort</label>
            <select name="sort" class="bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                <option value="highest" {{ request('sort') === 'highest' ? 'selected' : '' }}>Highest Amount</option>
                <option value="lowest" {{ request('sort') === 'lowest' ? 'selected' : '' }}>Lowest Amount</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-medium px-4 py-2 rounded-lg transition">Reset</a>
        </div>
    </div>
</form>

{{-- Orders Table --}}
<div class="bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-800 bg-gray-900/30">
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Disc</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Shipping</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Payment</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pay Status</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Items</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-t border-gray-800/50 hover:bg-white/[0.02] transition">
                    <td class="px-4 py-3 text-gray-300 font-mono text-xs">#{{ $order->id }}</td>
                    <td class="px-4 py-3 text-gray-400 font-mono text-xs">{{ $order->invoice_no ?? 'N/A' }}</td>
                    <td class="px-4 py-3">
                        <span class="text-gray-300 font-medium">{{ $order->customer_name }}</span>
                        @if($order->email)
                            <p class="text-xs text-gray-500">{{ $order->email }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $order->phone ?? 'N/A' }}</td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ formatPrice($order->subtotal) }}</td>
                    <td class="px-4 py-3 text-amber-400 text-xs">{{ $order->discount > 0 ? formatPrice($order->discount) : '-' }}</td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ formatPrice($order->shipping_charge) }}</td>
                    <td class="px-4 py-3 text-emerald-400 font-semibold text-sm">{{ formatPrice($order->grand_total) }}</td>
                    <td class="px-4 py-3 text-gray-400 text-xs capitalize">{{ str_replace('_', ' ', $order->payment_method ?? 'N/A') }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                            @switch($order->payment_status)
                                @case('paid') bg-emerald-500/10 text-emerald-400 @break
                                @case('unpaid') bg-amber-500/10 text-amber-400 @break
                                @case('pending') bg-blue-500/10 text-blue-400 @break
                                @case('refunded') bg-purple-500/10 text-purple-400 @break
                                @default bg-gray-500/10 text-gray-400
                            @endswitch
                        ">{{ $order->payment_status ? ucfirst($order->payment_status) : 'N/A' }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium
                            @switch($order->status)
                                @case('delivered') @case('completed') bg-emerald-500/10 text-emerald-400 @break
                                @case('confirmed') bg-blue-500/10 text-blue-400 @break
                                @case('processing') bg-indigo-500/10 text-indigo-400 @break
                                @case('packed') bg-cyan-500/10 text-cyan-400 @break
                                @case('shipped') bg-purple-500/10 text-purple-400 @break
                                @case('pending') bg-amber-500/10 text-amber-400 @break
                                @case('cancelled') bg-red-500/10 text-red-400 @break
                                @case('returned') bg-pink-500/10 text-pink-400 @break
                                @case('refunded') bg-orange-500/10 text-orange-400 @break
                                @default bg-gray-500/10 text-gray-400
                            @endswitch
                        ">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $order->items_count }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs whitespace-nowrap">{{ $order->ordered_at?->format('M d, Y') ?? $order->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.orders.show', $order) }}" class="px-2.5 py-1.5 text-xs font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition" title="View">View</a>
                            <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="px-2.5 py-1.5 text-xs font-medium rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 transition" title="Invoice">Print</a>
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="inline" onsubmit="return confirm('Delete order #{{ $order->id }}?')">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                                <button type="submit" class="px-2.5 py-1.5 text-xs font-medium rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition" title="Cancel">Cancel</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="14" class="px-4 py-12 text-center text-gray-500">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="px-4 py-3 border-t border-gray-800">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
