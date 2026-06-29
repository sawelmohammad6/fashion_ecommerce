@extends('admin.layouts.app')

@section('title', $customer->name)

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Customers', 'url' => route('admin.customers.index')], ['label' => $customer->name]]" />

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl font-bold mx-auto mb-3">
                {{ substr($customer->name, 0, 1) }}
            </div>
            <h2 class="font-bold text-lg text-gray-900">{{ $customer->name }}</h2>
            <p class="text-sm text-gray-500">{{ $customer->email }}</p>
            <p class="text-xs text-gray-400 mt-1">Joined {{ $customer->created_at->format('d M Y') }}</p>

            <div class="border-t border-gray-100 mt-4 pt-4 space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Orders</span><span class="font-semibold">{{ $orderCount }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Total Spent</span><span class="font-semibold text-indigo-600">${{ number_format($totalSpent, 2) }}</span></div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-lg text-gray-900 mb-4">Order History</h2>

            @if($customer->orders->count() > 0)
                <div class="space-y-3">
                    @foreach($customer->orders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-4 rounded-lg border border-gray-100 hover:bg-gray-50 transition">
                            <div>
                                <p class="font-medium text-gray-900">#{{ $order->id }} - ${{ number_format($order->grand_total, 2) }}</p>
                                <p class="text-xs text-gray-400">{{ $order->ordered_at ? $order->ordered_at->format('d M Y') : $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-admin::status-badge :status="$order->status" type="order" />
                                <x-admin::status-badge :status="$order->payment_status" type="payment" />
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-8">No orders yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection