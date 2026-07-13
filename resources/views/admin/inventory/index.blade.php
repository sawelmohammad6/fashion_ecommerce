@extends('layouts.admin')
@section('title', 'Inventory Management')
@push('styles')
<style>
.inventory-stat-card { transition: all 0.2s ease; }
.inventory-stat-card:hover { border-color: rgba(16,185,129,0.3); }
</style>
@endpush
@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Inventory Management</h1>
        <p class="text-sm text-gray-400 mt-1">Manage stock levels across all products</p>
    </div>
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.inventory.stock-in') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Stock In
        </a>
        <a href="{{ route('admin.inventory.stock-out') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
            Stock Out
        </a>
        <a href="{{ route('admin.inventory.adjust') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Adjust
        </a>
        <a href="{{ route('admin.inventory.history') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            History
        </a>
    </div>
</div>

{{-- Stats Cards --}}
@php
    $totalStockValue = $products->sum(fn($p) => ($p->buying_price ?? 0) * $p->stock);
    $totalStock = $products->sum('stock');
    $inStockCount = $products->filter(fn($p) => $p->stock_status === 'in_stock')->count();
    $lowStockCount = $products->filter(fn($p) => $p->stock_status === 'low_stock')->count();
    $outOfStockCount = $products->filter(fn($p) => $p->stock_status === 'out_of_stock')->count();
@endphp

<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
    <div class="inventory-stat-card bg-gray-900/50 border border-gray-800 rounded-xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Stock</p>
        <p class="text-xl font-bold text-white">{{ number_format($totalStock) }}</p>
    </div>
    <div class="inventory-stat-card bg-gray-900/50 border border-gray-800 rounded-xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">In Stock</p>
        <p class="text-xl font-bold text-emerald-400">{{ number_format($inStockCount) }}</p>
    </div>
    <div class="inventory-stat-card bg-gray-900/50 border border-gray-800 rounded-xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Low Stock</p>
        <p class="text-xl font-bold text-amber-400">{{ number_format($lowStockCount) }}</p>
    </div>
    <div class="inventory-stat-card bg-gray-900/50 border border-gray-800 rounded-xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Out of Stock</p>
        <p class="text-xl font-bold text-red-400">{{ number_format($outOfStockCount) }}</p>
    </div>
    <div class="inventory-stat-card bg-gray-900/50 border border-gray-800 rounded-xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Stock Value</p>
        <p class="text-xl font-bold text-white">{{ formatPrice($totalStockValue) }}</p>
    </div>
    <div class="inventory-stat-card bg-gray-900/50 border border-gray-800 rounded-xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Products</p>
        <p class="text-xl font-bold text-white">{{ number_format($products->total()) }}</p>
    </div>
</div>

{{-- Search & Filter --}}
<form method="GET" class="mb-6">
    <div class="flex flex-wrap gap-3">
        <div class="relative flex-1 min-w-[200px] max-w-sm">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, SKU, category..." class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg pl-9 pr-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
        </div>
        <select name="filter" class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition min-w-[140px]">
            <option value="">All Stock</option>
            <option value="in" {{ request('filter') === 'in' ? 'selected' : '' }}>In Stock</option>
            <option value="low" {{ request('filter') === 'low' ? 'selected' : '' }}>Low Stock</option>
            <option value="out" {{ request('filter') === 'out' ? 'selected' : '' }}>Out of Stock</option>
        </select>
        <button type="submit" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Filter</button>
        @if(request('search') || request('filter'))
            <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Clear</a>
        @endif
        <a href="{{ route('admin.inventory.export.csv') }}?{{ http_build_query(request()->only(['search', 'filter'])) }}" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">
            <svg class="w-4 h-4 inline -mt-0.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            CSV
        </a>
    </div>
</form>

{{-- Table --}}
<div class="bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800 bg-gray-900/30">
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">SKU</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Alert</th>
                    <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Buying</th>
                    <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Selling</th>
                    <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Inv. Value</th>
                    <th class="px-4 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Updated</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/30">
                @forelse($products as $product)
                <tr class="hover:bg-white/[0.03] transition-colors">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-9 h-9 rounded-lg object-cover">
                            @else
                                <div class="w-9 h-9 rounded-lg bg-gray-800/50 flex items-center justify-center text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <a href="{{ route('admin.products.edit', $product) }}" class="font-medium text-gray-200 hover:text-emerald-400 transition">{{ $product->name }}</a>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $product->sku ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @if($product->category)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400">{{ $product->category->name }}</span>
                        @else
                            <span class="text-gray-600 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right font-semibold text-gray-200">{{ $product->stock }}</td>
                    <td class="px-4 py-3 text-right text-gray-500 text-xs">{{ $product->low_stock_alert_quantity ?? 5 }}</td>
                    <td class="px-4 py-3 text-right text-gray-300">{{ $product->buying_price ? formatPrice($product->buying_price) : '—' }}</td>
                    <td class="px-4 py-3 text-right text-gray-300">{{ formatPrice($product->final_price ?? $product->price) }}</td>
                    <td class="px-4 py-3 text-right font-semibold text-gray-200">{{ formatPrice(($product->buying_price ?? 0) * $product->stock) }}</td>
                    <td class="px-4 py-3 text-center">
                        @php
                            $badge = match($product->stock_status) {
                                'out_of_stock' => ['bg-red-500/10 text-red-400', 'bg-red-400', 'Out of Stock'],
                                'low_stock' => ['bg-amber-500/10 text-amber-400', 'bg-amber-400', 'Low Stock'],
                                default => ['bg-emerald-500/10 text-emerald-400', 'bg-emerald-400', 'In Stock'],
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $badge[0] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $badge[1] }}"></span>
                            {{ $badge[2] }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right text-gray-500 text-xs">{{ $product->updated_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="10" class="px-4 py-10 text-center text-gray-500">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($products->hasPages())
    <div class="mt-5">{{ $products->links() }}</div>
@endif
@endsection
