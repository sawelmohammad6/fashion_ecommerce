@extends('layouts.app')

@section('title', 'Order Confirmed - ' . config('app.name'))

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 sm:p-12">
        <div class="text-6xl mb-4">✅</div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h1>
        <p class="text-gray-500 mb-8">Thank you for your purchase. Your order has been confirmed.</p>

        <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Order Number</span>
                <span class="font-semibold text-gray-900">#{{ $order->id }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Customer</span>
                <span class="font-semibold text-gray-900">{{ $order->customer_name }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Payment Method</span>
                <span class="font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Order Total</span>
                <span class="font-bold text-indigo-600">${{ number_format($order->grand_total, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Status</span>
                <x-order-status :status="$order->status" />
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Estimated Delivery</span>
                <span class="font-semibold text-gray-900">5-7 Business Days</span>
            </div>
        </div>

        <a href="{{ route('products.index') }}" class="inline-block px-8 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition text-sm">
            Continue Shopping
        </a>

        <a href="{{ route('orders.index') }}" class="inline-block px-8 py-3 ml-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition text-sm">
            View Orders
        </a>
    </div>
</div>
@endsection