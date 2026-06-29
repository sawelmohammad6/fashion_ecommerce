@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <x-admin::admin-card title="Total Products" :value="$totalProducts" color="indigo"
        icon="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
    <x-admin::admin-card title="Total Categories" :value="$totalCategories" color="blue"
        icon="M4 6h16M4 10h16M4 14h16M4 18h16" />
    <x-admin::admin-card title="Total Orders" :value="$totalOrders" color="purple"
        icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
    <x-admin::admin-card title="Pending Orders" :value="$pendingOrders" color="amber"
        icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    <x-admin::admin-card title="Delivered Orders" :value="$deliveredOrders" color="green"
        icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    <x-admin::admin-card title="Total Customers" :value="$totalCustomers" color="teal"
        icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
    <x-admin::admin-card title="Revenue" :value="'$' . number_format($revenue, 2)" color="pink"
        icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    <x-admin::admin-card title="Low Stock Items" :value="$lowStockCount" color="red"
        icon="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-lg text-gray-900 mb-4">Recent Orders</h2>
        <div class="space-y-3">
            @forelse($recentOrders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                    <div>
                        <p class="text-sm font-medium text-gray-900">#{{ $order->id }} - {{ $order->customer_name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->ordered_at ? $order->ordered_at->diffForHumans() : $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold">${{ number_format($order->grand_total, 2) }}</span>
                        <x-admin::status-badge :status="$order->status" type="order" />
                    </div>
                </a>
            @empty
                <p class="text-sm text-gray-400 text-center py-4">No orders yet.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-lg text-gray-900 mb-4">Latest Customers</h2>
        <div class="space-y-3">
            @forelse($latestCustomers as $customer)
                <a href="{{ route('admin.customers.show', $customer) }}" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-medium">
                            {{ substr($customer->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $customer->name }}</p>
                            <p class="text-xs text-gray-400">{{ $customer->email }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">{{ $customer->created_at->diffForHumans() }}</span>
                </a>
            @empty
                <p class="text-sm text-gray-400 text-center py-4">No customers yet.</p>
            @endforelse
        </div>
    </div>

    @if($lowStockProducts->count() > 0)
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-lg text-gray-900 mb-4">Low Stock Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($lowStockProducts as $product)
                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                        <p class="text-xs text-gray-500">{{ $product->category->name ?? 'N/A' }}</p>
                    </div>
                    <span class="text-sm font-bold text-red-600">{{ $product->stock }} left</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection