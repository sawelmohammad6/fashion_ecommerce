@extends('admin.layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Orders', 'url' => route('admin.orders.index')], ['label' => 'Order #' . $order->id]]" />

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-lg text-gray-900">Order #{{ $order->id }}</h2>
                <x-admin::status-badge :status="$order->status" type="order" />
            </div>

            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                    <select name="status" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        @foreach(\App\Services\OrderService::STATUSES as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                    <select name="payment_status" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        @foreach(\App\Services\OrderService::PAYMENT_STATUSES as $ps)
                            <option value="{{ $ps }}" {{ $order->payment_status === $ps ? 'selected' : '' }}>{{ ucfirst($ps) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Update Status</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-lg text-gray-900 mb-4">Products</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 pb-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                        @if($item->product && $item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-14 h-14 rounded-lg object-cover">
                        @else
                            <div class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center text-xl">👕</div>
                        @endif
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">{{ $item->product->name ?? 'Deleted Product' }}</p>
                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}</p>
                        </div>
                        <p class="font-medium text-gray-900 text-sm">${{ number_format($item->price * $item->quantity, 2) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-100 pt-4 mt-4 space-y-1 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-medium">${{ number_format($order->subtotal, 2) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Shipping</span><span class="font-medium">{{ $order->shipping_charge > 0 ? '$' . number_format($order->shipping_charge, 2) : 'Free' }}</span></div>
                @if($order->discount > 0)<div class="flex justify-between text-green-600"><span>Discount</span><span>-${{ number_format($order->discount, 2) }}</span></div>@endif
                <div class="flex justify-between text-base border-t border-gray-100 pt-2"><span class="font-semibold">Total</span><span class="font-bold text-indigo-600">${{ number_format($order->grand_total, 2) }}</span></div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-lg text-gray-900 mb-4">Customer Details</h2>
            <div class="text-sm space-y-3">
                <div><span class="text-gray-400 text-xs">Name</span><p class="font-medium text-gray-900">{{ $order->customer_name }}</p></div>
                <div><span class="text-gray-400 text-xs">Phone</span><p class="font-medium text-gray-900">{{ $order->phone }}</p></div>
                <div><span class="text-gray-400 text-xs">Email</span><p class="font-medium text-gray-900">{{ $order->email }}</p></div>
                @if($order->user)
                    <div><span class="text-gray-400 text-xs">Account</span><p class="font-medium text-gray-900">{{ $order->user->name }}</p></div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-lg text-gray-900 mb-4">Shipping Address</h2>
            <div class="text-sm space-y-1 text-gray-700">
                <p>{{ $order->address }}</p>
                <p>{{ $order->upazila ? $order->upazila . ', ' : '' }}{{ $order->district }}</p>
                <p>{{ $order->division }}{{ $order->postal_code ? ' - ' . $order->postal_code : '' }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-lg text-gray-900 mb-4">Payment Info</h2>
            <div class="text-sm space-y-2">
                <div><span class="text-gray-400 text-xs">Method</span><p class="font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p></div>
                <div><span class="text-gray-400 text-xs">Payment Status</span><x-admin::status-badge :status="$order->payment_status" type="payment" /></div>
            </div>
        </div>

        @if($order->notes)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="font-bold text-lg text-gray-900 mb-2">Order Notes</h2>
            <p class="text-sm text-gray-600">{{ $order->notes }}</p>
        </div>
        @endif

        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="block w-full py-3 text-center bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition text-sm">
            Print Invoice
        </a>
    </div>
</div>
@endsection