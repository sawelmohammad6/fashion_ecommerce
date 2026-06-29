@props(['product'])

<a href="{{ route('products.show', $product->slug) }}"
   class="product-card group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:scale-[1.02] block"
   data-id="{{ $product->id }}"
   data-name="{{ $product->name }}"
   data-price="{{ number_format($product->price, 2) }}"
   data-discount="{{ $product->discount_price ? number_format($product->discount_price, 2) : '' }}"
   data-price-formatted="{{ formatPrice($product->price) }}"
   data-discount-formatted="{{ $product->discount_price ? formatPrice($product->discount_price) : '' }}"
   data-category-name="{{ $product->category->name ?? '' }}"
   data-category-slug="{{ $product->category->slug ?? '' }}"
   data-fabric="{{ $product->fabric }}"
   data-color="{{ $product->color }}"
   data-print="{{ $product->print }}"
   data-size="{{ $product->size }}"
   data-stock="{{ $product->stock }}"
   data-description="{{ \Illuminate\Support\Str::limit(strip_tags($product->description), 200) }}"
   data-image="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
   data-slug="{{ $product->slug }}"
   onmouseenter="showPreview(this)"
   onmouseleave="onCardLeave(this)">
    <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center p-2 sm:p-3 overflow-hidden">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                 class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-110">
        @else
            <div class="text-6xl select-none transition-transform duration-500 group-hover:scale-110">
                @switch($product->category->slug ?? '')
                    @case('mens-t-shirt') 👕 @break
                    @case('womens-t-shirt') 👚 @break
                    @case('bags') 👜 @break
                    @default ✨
                @endswitch
            </div>
        @endif
    </div>
    <div class="p-4 sm:p-5 space-y-2">
        <h3 class="font-semibold text-gray-900 text-sm sm:text-base truncate">{{ $product->name }}</h3>
        <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-400">
            @if($product->fabric)
                <span><span class="text-gray-300">Fabric:</span> {{ $product->fabric }}</span>
            @endif
            @if($product->color)
                <span><span class="text-gray-300">Color:</span> {{ $product->color }}</span>
            @endif
            @if($product->print)
                <span><span class="text-gray-300">Print:</span> {{ $product->print }}</span>
            @endif
            @if($product->size)
                <span><span class="text-gray-300">Size:</span> {{ $product->size }}</span>
            @endif
        </div>
        <div class="flex items-center justify-between pt-2">
             <span class="text-lg font-bold text-gray-900">{{ formatPrice($product->price) }}</span>
            <span class="px-4 py-1.5 bg-white text-cyan-600 text-xs font-semibold rounded-full border border-cyan-200 shadow-sm hover:bg-cyan-50 hover:border-cyan-300 hover:shadow-md transition-all duration-300 inline-flex items-center gap-1.5">
                Order Now
                <svg class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </span>
        </div>
    </div>
</a>
