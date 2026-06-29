@extends('layouts.app')

@section('title', 'My Wishlist - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:text-indigo-700 transition inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            Home
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">My Wishlist</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm mb-6">{{ session('success') }}</div>
    @endif

    @if($wishlists->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($wishlists as $wishlist)
                @php $p = $wishlist->product @endphp
                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <a href="{{ route('products.show', $p->slug) }}" class="block aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center p-4">
                        @if($p->image)
                            <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-contain" loading="lazy">
                        @else
                            <span class="text-5xl">@switch($p->category->slug ?? '') @case('mens-t-shirt') 👕 @break @case('womens-t-shirt') 👚 @break @case('bags') 👜 @break @default ✨ @endswitch</span>
                        @endif
                    </a>
                    <div class="p-3 sm:p-4">
                        <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $p->name }}</h3>
                        <p class="text-indigo-600 font-bold text-sm mt-1">{{ formatPrice($p->final_price) }}</p>
                        <div class="flex gap-2 mt-2">
                            <form action="{{ route('wishlist.moveToCart', $p) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full py-1.5 text-xs font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Add to Cart</button>
                            </form>
                            <form action="{{ route('wishlist.destroy', $p) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 transition" onclick="return confirm('Remove from wishlist?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $wishlists->links() }}</div>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="text-5xl mb-4">🤍</div>
            <p class="text-gray-500 text-lg mb-4">Your wishlist is empty.</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition text-sm">Browse Products</a>
        </div>
    @endif
</div>
@endsection