@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Orders']]" />

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Orders</h2>
        <p class="text-sm text-gray-500 mt-0.5">Manage customer orders</p>
    </div>
</div>

<form method="GET" class="mb-6">
    <div class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ID, name, phone, email..."
               class="flex-1 min-w-[250px] rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        <select name="status" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <option value="">All Status</option>
            @foreach($statuses as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="payment_status" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <option value="">All Payment</option>
            @foreach($paymentStatuses as $ps)
                <option value="{{ $ps }}" {{ request('payment_status') === $ps ? 'selected' : '' }}>{{ ucfirst($ps) }}</option>
            @endforeach
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Filter</button>
        @if(request()->anyFilled(['search', 'status', 'payment_status', 'date_from', 'date_to']))
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 transition">Clear</a>
        @endif
    </div>
</form>

<x-admin::admin-table :headers="['Order #', 'Customer', 'Total', 'Status', 'Payment', 'Date']">
    @forelse($orders as $order)
        <tr>
            <td class="px-4 py-3 font-medium text-gray-900">#{{ $order->id }}</td>
            <td class="px-4 py-3">
                <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                <p class="text-xs text-gray-400">{{ $order->email }}</p>
            </td>
            <td class="px-4 py-3 font-semibold text-gray-900">${{ number_format($order->grand_total, 2) }}</td>
            <td class="px-4 py-3"><x-admin::status-badge :status="$order->status" type="order" /></td>
            <td class="px-4 py-3"><x-admin::status-badge :status="$order->payment_status" type="payment" /></td>
            <td class="px-4 py-3 text-sm text-gray-400">{{ $order->ordered_at ? $order->ordered_at->format('d M Y') : $order->created_at->format('d M Y') }}</td>
            <td class="px-4 py-3 text-right">
                <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition inline-block">View</a>
            </td>
        </tr>
    @empty
        <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">No orders found.</td></tr>
    @endforelse
</x-admin::admin-table>

<x-admin::pagination :paginator="$orders" />
@endsection