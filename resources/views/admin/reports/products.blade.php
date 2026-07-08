@extends('layouts.admin')
@section('title', 'Products Report')
@push('styles')
<style>
.chart-placeholder { height: 260px; }
</style>
@endpush
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Reports', 'url' => route('admin.reports.index')], ['label' => 'Products Report']]" />

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Products Report</h1>
        <p class="text-sm text-gray-400 mt-1">Product performance and inventory analysis</p>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Products</p>
        <p class="text-2xl font-bold text-white">{{ $summary->total_products }}</p>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Active Products</p>
        <p class="text-2xl font-bold text-emerald-400">{{ $summary->active_products }}</p>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Stock</p>
        <p class="text-2xl font-bold text-white">{{ $summary->total_stock }}</p>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Avg Price</p>
        <p class="text-2xl font-bold text-white">{{ formatPrice($summary->avg_price) }}</p>
    </div>
</div>

<div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm font-semibold text-gray-300">Product Sales Performance</h2>
        <form method="GET">
            <select name="sort" onchange="this.form.submit()" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                <option value="revenue" {{ $sort === 'revenue' ? 'selected' : '' }}>By Revenue</option>
                <option value="qty" {{ $sort === 'qty' ? 'selected' : '' }}>By Quantity Sold</option>
            </select>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-800">
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sold</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Revenue</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr class="border-t border-gray-800/50 hover:bg-white/[0.02] transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($item->product && $item->product->image)<img src="{{ asset('storage/' . $item->product->image) }}" class="w-8 h-8 rounded-lg object-cover">@else<div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-xs text-gray-500">P</div>@endif
                            <span class="text-gray-300 font-medium">{{ $item->product->name ?? 'Deleted Product' }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-400">{{ $item->product ? formatPrice($item->product->price) : 'N/A' }}</td>
                    <td class="px-4 py-3">
                        <span class="{{ $item->product && $item->product->stock <= 5 ? 'text-red-400' : 'text-gray-400' }}">{{ $item->product->stock ?? 0 }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-300">{{ $item->total_sold }}</td>
                    <td class="px-4 py-3 text-emerald-400 font-semibold">{{ formatPrice($item->total_revenue) }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No product sales data yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>
@endsection
