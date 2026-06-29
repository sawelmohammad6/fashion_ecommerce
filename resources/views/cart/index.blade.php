@extends('layouts.app')

@section('title', 'Cart - ' . config('app.name'))

@push('styles')
<style>
input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
input[type=number] { -moz-appearance: textfield; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:text-indigo-700 transition inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Shopping Cart</h1>
        </div>

        @if(count($cartItems) > 0)
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear all items from cart?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-500 hover:text-red-600 transition">Clear Cart</button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cartItems) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <x-cart-item :item="$item" />
                @endforeach
            </div>

            <div>
                <x-cart-summary :total="$total" :count="$count" />
            </div>
        </div>
    @else
        <div class="text-center py-16">
            <div class="text-6xl mb-4">🛒</div>
            <p class="text-gray-500 text-lg mb-4">Your cart is empty.</p>
            <a href="{{ route('products.index') }}"
               class="inline-block px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition text-sm">
                Start Shopping
            </a>
        </div>
    @endif
</div>

<script>
function incrementCartQty(btn, max) {
    const input = btn.parentElement.querySelector('.cart-qty');
    let val = parseInt(input.value) || 1;
    if (val < max) { input.value = val + 1; input.form.submit(); }
}
function decrementCartQty(btn) {
    const input = btn.parentElement.querySelector('.cart-qty');
    let val = parseInt(input.value) || 1;
    if (val > 1) { input.value = val - 1; input.form.submit(); }
}
</script>
@endsection