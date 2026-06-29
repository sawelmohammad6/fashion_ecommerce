@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Reports']]" />

<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Reports & Statistics</h2>
    <p class="text-sm text-gray-500 mt-0.5">Sales, inventory, and performance overview</p>
</div>

@php
    use App\Models\Order;
    use App\Models\Product;
    use App\Models\User;
    use App\Services\InventoryService;
    use App\Services\OrderService;

    $inv = app(InventoryService::class);
    $orderSvc = app(OrderService::class);
    $totalProducts = Product::count();
    $totalOrders = Order::count();
    $revenue = $orderSvc->getRevenue();
    $customers = User::where('is_admin', false)->count();
    $statusTotals = $orderSvc->getOrderTotalsByStatus();
    $topProducts = $inv->getTopSellingProducts(5);
    $lowStock = $inv->getLowStockProducts(5, 5);
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <x-admin::admin-card title="Total Revenue" :value="'$' . number_format($revenue, 2)" color="green"
        icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    <x-admin::admin-card title="Total Orders" :value="$totalOrders" color="blue"
        icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
    <x-admin::admin-card title="Total Products" :value="$totalProducts" color="indigo"
        icon="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
    <x-admin::admin-card title="Total Customers" :value="$customers" color="teal"
        icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-lg text-gray-900 mb-4">Order Status Summary</h2>
        <div class="space-y-3">
            @foreach($statusTotals as $status => $count)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <x-admin::status-badge :status="$status" type="order" />
                    </div>
                    <span class="font-semibold text-gray-900">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-lg text-gray-900 mb-4">Top Selling Products</h2>
        @if($topProducts->count() > 0)
            <div class="space-y-3">
                @foreach($topProducts as $product)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">👕</div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400">{{ $product->total_sold }} sold</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold">${{ number_format($product->price, 2) }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-400 text-center py-4">No sales data yet.</p>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="font-bold text-lg text-gray-900 mb-4">Low Stock Alert</h2>
        @if($lowStock->count() > 0)
            <div class="space-y-3">
                @foreach($lowStock as $product)
                    <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">{{ $product->category->name ?? 'N/A' }}</p>
                        </div>
                        <span class="text-sm font-bold text-red-600">{{ $product->stock }} left</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-400 text-center py-4">All products well-stocked.</p>
        @endif
    </div>
</div>
@endsection