@props(['order'])

<a href="{{ route('orders.show', $order) }}" class="block bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <p class="text-xs text-gray-400">Order #{{ $order->id }}</p>
            <p class="font-semibold text-gray-900 mt-0.5">{{ $order->customer_name }}</p>
            <p class="text-sm text-gray-500">{{ $order->ordered_at ? $order->ordered_at->format('d M Y, h:i A') : $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="font-bold text-indigo-600">{{ formatPrice($order->grand_total) }}</p>
                <p class="text-xs text-gray-500">{{ $order->items_count ?? $order->items->count() }} item(s)</p>
            </div>
            <x-order-status :status="$order->status" />
        </div>
    </div>
</a>