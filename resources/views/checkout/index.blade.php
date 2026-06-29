@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Home</a>
        <span>/</span>
        <a href="{{ route('cart.index') }}" class="hover:text-indigo-600 transition">Cart</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Checkout</span>
    </nav>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <div class="lg:col-span-3">
            <x-checkout-form />
        </div>

        <div class="lg:col-span-2">
            <div class="space-y-6">
                <x-order-summary :cartItems="$cartItems" :subtotal="$subtotal" :shippingCharge="$shippingCharge" :discount="$discount" :grandTotal="$grandTotal" />

                @if(session('coupon.code'))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-700">Coupon: {{ session('coupon.code') }}</p>
                            <p class="text-xs text-green-600">-${{ number_format(session('coupon.discount'), 2) }} discount</p>
                        </div>
                        <form action="{{ route('coupon.remove') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-red-500 hover:text-red-600 transition">Remove</button>
                        </form>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <form action="{{ route('coupon.apply') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="code" placeholder="Coupon code"
                                   class="flex-1 rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none uppercase">
                            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Apply</button>
                        </form>
                    </div>
                @endif

                <button type="submit" form="checkout-form"
                        class="w-full py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition text-sm">
                    Place Order
                </button>
            </div>
        </div>
    </div>
</div>

@endsection