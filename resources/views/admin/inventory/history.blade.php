@extends('layouts.admin')
@section('title', 'Inventory History')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Inventory History</h1>
        <p class="text-sm text-gray-400 mt-1">All stock movements recorded</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.inventory.export.csv') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export CSV
        </a>
        <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="mb-6">
    <div class="flex flex-wrap gap-3">
        <div class="relative flex-1 min-w-[200px] max-w-sm">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product..." class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg pl-9 pr-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
        </div>
        <select name="type" class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition min-w-[140px]">
            <option value="">All Types</option>
            <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>Stock In</option>
            <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Stock Out</option>
            <option value="adjustment" {{ request('type') === 'adjustment' ? 'selected' : '' }}>Adjustment</option>
        </select>
        <select name="product_id" class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition min-w-[200px]">
            <option value="">All Products</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Filter</button>
        @if(request('search') || request('type') || request('product_id'))
            <a href="{{ route('admin.inventory.history') }}" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Clear</a>
        @endif
    </div>
</form>

{{-- Table --}}
<div class="bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800 bg-gray-900/30">
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock Before</th>
                    <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock After</th>
                    <th class="px-4 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Change</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Reference</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Performed By</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Remarks</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/30">
                @forelse($transactions as $t)
                <tr class="hover:bg-white/[0.03] transition-colors">
                    <td class="px-4 py-3 text-gray-300 text-xs">{{ $t->date->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        @if($t->product)
                            <a href="{{ route('admin.products.edit', $t->product) }}" class="font-medium text-gray-200 hover:text-emerald-400 transition">{{ $t->product->name }}</a>
                            <p class="text-xs text-gray-500">{{ $t->product->sku }}</p>
                        @else
                            <span class="text-gray-500">Deleted</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $typeBadge = match($t->type) {
                                'in' => ['bg-emerald-500/10 text-emerald-400', 'Stock In'],
                                'out' => ['bg-red-500/10 text-red-400', 'Stock Out'],
                                'adjustment' => ['bg-amber-500/10 text-amber-400', 'Adjustment'],
                                default => ['bg-gray-500/10 text-gray-400', $t->type],
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $typeBadge[0] }}">{{ $typeBadge[1] }}</span>
                    </td>
                    <td class="px-4 py-3 text-right text-gray-300">{{ $t->stock_before }}</td>
                    <td class="px-4 py-3 text-right text-gray-300">{{ $t->stock_after }}</td>
                    <td class="px-4 py-3 text-right font-semibold">
                        @php
                            $diff = $t->stock_after - $t->stock_before;
                        @endphp
                        <span class="{{ $diff > 0 ? 'text-emerald-400' : ($diff < 0 ? 'text-red-400' : 'text-gray-400') }}">
                            {{ $diff > 0 ? '+' : '' }}{{ $diff }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500 text-xs font-mono">{{ $t->reference ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $t->performer?->name ?? 'System' }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs max-w-[200px] truncate" title="{{ $t->remarks }}">{{ $t->remarks ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="9" class="px-4 py-10 text-center text-gray-500">No inventory transactions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($transactions->hasPages())
    <div class="mt-5">{{ $transactions->links() }}</div>
@endif
@endsection
