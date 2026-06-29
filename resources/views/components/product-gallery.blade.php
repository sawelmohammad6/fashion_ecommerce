@props(['product'])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center overflow-hidden">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        @else
            <div class="text-8xl sm:text-9xl select-none">
                @switch($product->category->slug ?? '')
                    @case('mens-t-shirt') 👕 @break
                    @case('womens-t-shirt') 👚 @break
                    @case('bags') 👜 @break
                    @default ✨
                @endswitch
            </div>
        @endif
    </div>
</div>
