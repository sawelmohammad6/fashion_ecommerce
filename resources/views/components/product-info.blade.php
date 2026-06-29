@props(['product'])

<div class="space-y-5">
    <div>
        <a href="{{ route('products.category', $product->category->slug) }}"
           class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
            {{ $product->category->name }}
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">{{ $product->name }}</h1>
    </div>

    <div class="text-3xl font-bold text-indigo-600">${{ number_format($product->price, 2) }}</div>

    <div class="grid grid-cols-2 gap-4 text-sm">
        @if($product->fabric)
            <div>
                <span class="text-gray-400">Fabric</span>
                <p class="font-medium text-gray-900">{{ $product->fabric }}</p>
            </div>
        @endif
        @if($product->color)
            <div>
                <span class="text-gray-400">Color</span>
                <p class="font-medium text-gray-900">{{ $product->color }}</p>
            </div>
        @endif
        @if($product->print)
            <div>
                <span class="text-gray-400">Print</span>
                <p class="font-medium text-gray-900">{{ $product->print }}</p>
            </div>
        @endif
        @if($product->size)
            <div>
                <span class="text-gray-400">Sizes</span>
                <div class="flex flex-wrap gap-1.5 mt-1">
                    @foreach(explode(', ', $product->size) as $size)
                        <span class="px-2.5 py-1 bg-gray-100 rounded-md text-xs font-medium text-gray-700">{{ trim($size) }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div>
        <span class="text-gray-400 text-sm">Stock Status</span>
        <p class="font-medium text-sm mt-0.5">
            @if($product->stock > 10)
                <span class="text-green-600">In Stock ({{ $product->stock }} available)</span>
            @elseif($product->stock > 0)
                <span class="text-amber-600">Low Stock ({{ $product->stock }} left)</span>
            @else
                <span class="text-red-600">Out of Stock</span>
            @endif
        </p>
    </div>

    @if($product->description)
        <div>
            <span class="text-gray-400 text-sm">Description</span>
            <p class="text-gray-700 text-sm mt-0.5 leading-relaxed">{{ $product->description }}</p>
        </div>
    @endif
</div>