@props(['item'])

<div class="cart-item bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
    <div class="flex items-center gap-4 sm:gap-6">
        <a href="{{ route('products.show', $item['slug']) }}"
           class="shrink-0 w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center text-3xl">
            @switch($item['category_slug'] ?? '')
                @case('mens-t-shirt') 👕 @break
                @case('womens-t-shirt') 👚 @break
                @case('bags') 👜 @break
                @default ✨
            @endswitch
        </a>

        <div class="flex-1 min-w-0">
            <a href="{{ route('products.show', $item['slug']) }}"
               class="font-semibold text-gray-900 hover:text-indigo-600 transition text-sm sm:text-base block truncate">
                {{ $item['name'] }}
            </a>
            <p class="text-indigo-600 font-bold text-sm sm:text-base mt-1">${{ number_format($item['price'], 2) }}</p>
        </div>

        <div class="flex items-center gap-3">
            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <button type="button" onclick="decrementCartQty(this)" class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition text-sm font-medium">-</button>
                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}"
                       class="cart-qty w-12 h-8 text-center border border-gray-200 rounded-lg text-sm font-medium text-gray-900 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                       onchange="this.form.submit()">
                <button type="button" onclick="incrementCartQty(this, {{ $item['stock'] }})" class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition text-sm font-medium">+</button>
            </form>
        </div>

        <div class="text-right shrink-0">
            <p class="cart-subtotal font-bold text-gray-900 text-sm sm:text-base">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
            <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="inline" onsubmit="return confirm('Remove this item from cart?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-red-500 hover:text-red-600 transition mt-1">Remove</button>
            </form>
        </div>
    </div>
</div>