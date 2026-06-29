@extends('admin.layouts.app')
@section('title', 'Orders')
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Orders']]" />
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-white">Orders</h2>
        <p class="text-sm text-white/40 mt-0.5">Manage customer orders</p>
    </div>
</div>
<form method="GET" class="mb-6">
    <div class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ID, name, email, phone..." class="input-glass flex-1 min-w-[200px] max-w-sm">
        <select name="status" class="select-glass">
            <option value="">All Status</option>
            @foreach(['pending','confirmed','processing','shipped','delivered','cancelled','returned'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="payment_status" class="select-glass">
            <option value="">Payment</option>
            @foreach(['pending','paid','failed','refunded'] as $ps)
                <option value="{{ $ps }}" {{ request('payment_status') === $ps ? 'selected' : '' }}>{{ ucfirst($ps) }}</option>
            @endforeach
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="input-glass w-36">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="input-glass w-36">
        <button type="submit" class="btn-secondary">Filter</button>
        @if(request()->anyFilled(['search','status','payment_status','date_from','date_to']))<a href="{{ route('admin.orders.index') }}" class="btn-secondary">Clear</a>@endif
    </div>
</form>
<x-admin::admin-table :headers="['ID', 'Customer', 'Total', 'Status', 'Payment', 'Date']">
    @forelse($orders as $order)
        <tr>
            <td class="text-white/60 font-medium">#{{ $order->id }}</td>
            <td><span class="text-white/80">{{ $order->customer_name }}</span><p class="text-xs text-white/30">{{ $order->email }}</p></td>
            <td class="text-white font-medium">{{ formatPrice($order->grand_total) }}</td>
            <td><x-admin::status-badge :status="$order->status" type="order" /></td>
            <td><x-admin::status-badge :status="$order->payment_status" type="payment" /></td>
            <td class="text-white/40 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
            <td class="text-right">
                <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">View</a>
            </td>
        </tr>
    @empty
        <tr><td colspan="7" class="px-4 py-10 text-center text-white/30">No orders found.</td></tr>
    @endforelse
</x-admin::admin-table>
<x-admin::pagination :paginator="$orders" />
@endsection
