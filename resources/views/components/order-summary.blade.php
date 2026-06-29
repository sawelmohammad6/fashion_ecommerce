@props(['cartItems' => [], 'subtotal' => 0, 'shippingCharge' => 0, 'discount' => 0, 'grandTotal' => 0])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
    <h3 class="font-bold text-lg text-gray-900">Order Summary</h3>

    <div class="space-y-3 max-h-64 overflow-y-auto">
        @foreach($cartItems as $item)
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-xl shrink-0">
                    @switch($item['category_slug'] ?? '')
                        @case('mens-t-shirt') 👕 @break
                        @case('womens-t-shirt') 👚 @break
                        @case('bags') 👜 @break
                        @default ✨
                    @endswitch
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</p>
                    <p class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</p>
                </div>
                <p class="text-sm font-medium text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
            </div>
        @endforeach
    </div>

    <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
        <div class="flex justify-between text-gray-600">
            <span>Subtotal</span>
            <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="flex justify-between text-gray-600">
            <span>Shipping</span>
            <span class="font-medium">{{ $shippingCharge > 0 ? '$' . number_format($shippingCharge, 2) : 'Free' }}</span>
        </div>
        @if($discount > 0)
            <div class="flex justify-between text-green-600">
                <span>Discount</span>
                <span class="font-medium">-${{ number_format($discount, 2) }}</span>
            </div>
        @endif
        <div class="border-t border-gray-100 pt-2 flex justify-between text-base">
            <span class="font-semibold text-gray-900">Total</span>
            <span id="grandTotalDisplay" class="font-bold text-indigo-600">${{ number_format($grandTotal, 2) }}</span>
        </div>
    </div>
</div>