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
                        @auth
                            <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-3 border border-gray-300 text-gray-600 hover:text-red-500 hover:border-red-300 rounded-lg transition text-sm" title="{{ $product->isInWishlist(auth()->id()) ? 'Remove from wishlist' : 'Add to wishlist' }}">
                                    <svg class="w-5 h-5 {{ $product->isInWishlist(auth()->id()) ? 'text-red-500 fill-red-500' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </form>
                        @endauth
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
                        <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center p-4 overflow-hidden">
                            @if($rel->image)
                                <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                            @else
                                <div class="text-4xl group-hover:scale-110 transition-transform">
                                    @switch($rel->category->slug ?? '')
                                        @case('mens-t-shirt') 👕 @break
                                        @case('womens-t-shirt') 👚 @break
                                        @case('bags') 👜 @break
                                        @default ✨
                                    @endswitch
                                </div>
                            @endif
                        </div>
                        <div class="p-3 sm:p-4">
                            <h3 class="font-semibold text-gray-900 text-sm truncate">{{ $rel->name }}</h3>
                            <p class="text-indigo-600 font-bold text-sm mt-1">{{ formatPrice($rel->price) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mt-16 pt-12 border-t border-gray-200">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Customer Reviews</h2>
        @php $reviews = $product->reviews()->with('user')->where('status', true)->latest()->get(); @endphp

        @if($reviews->count() > 0)
            <div class="flex items-center gap-2 mb-6">
                <div class="flex text-amber-400">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= $product->avg_rating ? 'fill-current' : 'fill-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                    @endfor
                </div>
                <span class="text-sm font-medium text-gray-700">{{ $product->avg_rating }} out of 5</span>
                <span class="text-sm text-gray-400">({{ $product->reviews_count }} reviews)</span>
            </div>
        @endif

        @auth
            @php $userReview = $product->reviews()->where('user_id', auth()->id())->first(); @endphp
            @if(!$userReview)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-4">Write a Review</h3>
                    <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="flex gap-1" id="starRating">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="hidden peer">
                                    <label for="star{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-amber-400 hover:text-amber-400 transition-colors">
                                        <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                    </label>
                                @endfor
                            </div>
                            @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                            <textarea name="comment" rows="3" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Share your experience..."></textarea>
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Submit Review</button>
                    </form>
                </div>
            @endif
        @endauth

        <div class="space-y-4">
            @forelse($reviews as $review)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-medium">{{ substr($review->user->name, 0, 1) }}</div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $review->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($review->user_id === auth()->id())
                            <div class="flex gap-2">
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete your review?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-600 transition">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="flex text-amber-400 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'fill-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        @endfor
                    </div>
                    @if($review->comment)
                        <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-8">No reviews yet. Be the first to review!</p>
            @endforelse
        </div>
    </section>
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