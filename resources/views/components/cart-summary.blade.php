@props(['total', 'count'])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
    <h3 class="font-bold text-lg text-gray-900">Cart Summary</h3>

    <div class="space-y-2 text-sm">
        <div class="flex justify-between text-gray-600">
            <span>Total Items</span>
            <span class="font-medium text-gray-900">{{ $count }}</span>
        </div>
        <div class="flex justify-between text-gray-600">
            <span>Subtotal</span>
            <span class="font-medium text-gray-900">${{ number_format($total, 2) }}</span>
        </div>
        <div class="border-t border-gray-100 pt-2 flex justify-between text-base">
            <span class="font-semibold text-gray-900">Estimated Total</span>
            <span class="font-bold text-indigo-600">${{ number_format($total, 2) }}</span>
        </div>
    </div>

    <button class="w-full py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition text-sm" disabled>
        Proceed to Checkout
    </button>

    <a href="{{ route('products.index') }}"
       class="block w-full py-3 text-center border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition text-sm">
        Continue Shopping
    </a>
</div>