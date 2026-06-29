@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))

@push('styles')
<style>
.qty-btn { @apply w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition font-medium text-lg; }
.qty-input { @apply w-16 h-10 text-center border border-gray-200 rounded-lg text-sm font-medium text-gray-900 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none; }
input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
input[type=number] { -moz-appearance: textfield; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Products</a>
        <span>/</span>
        <a href="{{ route('products.category', $product->category->slug) }}" class="hover:text-indigo-600 transition">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        <x-product-gallery :product="$product" />
        <div>
            <x-product-info :product="$product" />

            <div class="mt-6 pt-6 border-t border-gray-100">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <span class="text-gray-400 text-sm">Quantity</span>
                        <div class="flex items-center gap-3 mt-1.5">
                            <button type="button" onclick="decrementQty()" class="qty-btn">-</button>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="qty-input">
                            <button type="button" onclick="incrementQty({{ $product->stock }})" class="qty-btn">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition text-sm">
                            Add to Cart
                        </button>
                        <button type="button" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition text-sm">
                            Buy Now
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($related->count() > 0)
        <section class="mt-16 pt-12 border-t border-gray-200">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($related as $rel)
                    <a href="{{ route('products.show', $rel->slug) }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                        <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center p-4">
                            <div class="text-4xl group-hover:scale-110 transition-transform">
                                @switch($rel->category->slug ?? '')
                                    @case('mens-t-shirt') 👕 @break
                                    @case('womens-t-shirt') 👚 @break
                                    @case('bags') 👜 @break
                                    @default ✨
                                @endswitch
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $rel->name }}</h3>
                            <p class="text-indigo-600 font-bold text-sm mt-1">${{ number_format($rel->price, 2) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
function incrementQty(max) {
    const input = document.getElementById('quantity');
    let val = parseInt(input.value) || 1;
    if (val < max) input.value = val + 1;
}
function decrementQty() {
    const input = document.getElementById('quantity');
    let val = parseInt(input.value) || 1;
    if (val > 1) input.value = val - 1;
}
</script>
@endpush