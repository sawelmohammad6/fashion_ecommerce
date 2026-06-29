@extends('layouts.app')

@section('title', 'Order #' . $order->id . ' - ' . config('app.name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Home</a>
        <span>/</span>
        <a href="{{ route('orders.index') }}" class="hover:text-indigo-600 transition">My Orders</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Order #{{ $order->id }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-lg text-gray-900">Order #{{ $order->id }}</h2>
                    <x-order-status :status="$order->status" />
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-400">Ordered</span><p class="font-medium text-gray-900">{{ $order->ordered_at ? $order->ordered_at->format('d M Y, h:i A') : $order->created_at->format('d M Y, h:i A') }}</p></div>
                    <div><span class="text-gray-400">Payment</span><p class="font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p></div>
                    <div><span class="text-gray-400">Payment Status</span><p class="font-medium text-{{ $order->payment_status === 'paid' ? 'green' : 'amber' }}-600 capitalize">{{ $order->payment_status }}</p></div>
                    <div><span class="text-gray-400">Total</span><p class="font-bold text-indigo-600">${{ number_format($order->grand_total, 2) }}</p></div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-lg text-gray-900 mb-4">Status Timeline</h2>
                <div class="space-y-3">
                    @php
                        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
                        $currentIndex = array_search($order->status, $statuses);
                    @endphp
                    @foreach($statuses as $i => $s)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium
                                {{ $i <= $currentIndex ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-400' }}">
                                {{ $i + 1 }}
                            </div>
                            <div>
                                <p class="text-sm font-medium {{ $i <= $currentIndex ? 'text-gray-900' : 'text-gray-400' }}">{{ ucfirst($s) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-lg text-gray-900 mb-4">Products</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 pb-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                            <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-2xl shrink-0">
                                @switch($item->product->category->slug ?? '')
                                    @case('mens-t-shirt') 👕 @break
                                    @case('womens-t-shirt') 👚 @break
                                    @case('bags') 👜 @break
                                    @default ✨
                                @endswitch
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 text-sm">{{ $item->product->name }}</p>
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
                <h2 class="font-bold text-lg text-gray-900 mb-4">Shipping Address</h2>
                <div class="text-sm space-y-1 text-gray-700">
                    <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                    <p>{{ $order->phone }}</p>
                    <p>{{ $order->email }}</p>
                    <p class="mt-2">{{ $order->address }}</p>
                    <p>{{ $order->upazila ? $order->upazila . ', ' : '' }}{{ $order->district }}</p>
                    <p>{{ $order->division }}{{ $order->postal_code ? ' - ' . $order->postal_code : '' }}</p>
                </div>
            </div>

            <a href="{{ route('orders.index') }}" class="block w-full py-3 text-center border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition text-sm">
                &larr; Back to Orders
            </a>
        </div>
    </div>
</div>
@endsection