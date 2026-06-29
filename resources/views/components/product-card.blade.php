@props(['product'])

<a href="{{ route('products.show', $product->slug) }}"
   class="product-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-md block"
   data-id="{{ $product->id }}"
   data-name="{{ $product->name }}"
   data-fabric="{{ $product->fabric }}"
   data-color="{{ $product->color }}"
   data-print="{{ $product->print }}"
   data-size="{{ $product->size }}"
   data-price="{{ number_format($product->price, 2) }}"
   data-category-slug="{{ $product->category->slug ?? '' }}"
   onmouseenter="showPreview(this)"
   onmouseleave="hidePreview(this)">
    <div class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center p-4">
        <div class="text-5xl select-none">
            @switch($product->category->slug ?? '')
                @case('mens-t-shirt') 👕 @break
                @case('womens-t-shirt') 👚 @break
                @case('bags') 👜 @break
                @default ✨
            @endswitch
        </div>
    </div>
    <div class="p-3 sm:p-4 space-y-1.5">
        <h3 class="font-semibold text-gray-900 text-sm sm:text-base truncate">{{ $product->name }}</h3>
        <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500">
            @if($product->fabric)
                <span><span class="text-gray-400">Fabric:</span> {{ $product->fabric }}</span>
            @endif
            @if($product->color)
                <span><span class="text-gray-400">Color:</span> {{ $product->color }}</span>
            @endif
            @if($product->print)
                <span><span class="text-gray-400">Print:</span> {{ $product->print }}</span>
            @endif
            @if($product->size)
                <span><span class="text-gray-400">Size:</span> {{ $product->size }}</span>
            @endif
        </div>
        <div class="flex items-center justify-between pt-2">
            <span class="text-lg font-bold text-indigo-600">${{ number_format($product->price, 2) }}</span>
            <span class="px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-lg hover:bg-indigo-700 transition inline-block">
                Order Now
            </span>
        </div>
    </div>
</a>