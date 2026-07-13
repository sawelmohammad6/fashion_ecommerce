@extends('layouts.admin')
@section('title', 'Stock In')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Stock In</h1>
        <p class="text-sm text-gray-400 mt-1">Add stock to products</p>
    </div>
    <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Inventory
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
        <form action="{{ route('admin.inventory.stock-in.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-300 mb-2">Product <span class="text-red-400">*</span></label>
                <select name="product_id" required class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (SKU: {{ $product->sku ?: 'N/A' }}) — Current Stock: {{ $product->stock }}
                        </option>
                    @endforeach
                </select>
                @error('product_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Quantity <span class="text-red-400">*</span></label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" required class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition" placeholder="e.g. 10">
                    @error('quantity') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Purchase Price</label>
                    <input type="number" name="purchase_price" min="0" step="0.01" value="{{ old('purchase_price') }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition" placeholder="e.g. 15.50">
                    @error('purchase_price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Supplier</label>
                    <input type="text" name="supplier" value="{{ old('supplier') }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition" placeholder="Supplier name (optional)">
                    @error('supplier') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Date <span class="text-red-400">*</span></label>
                    <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                    @error('date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-300 mb-2">Remarks</label>
                <textarea name="remarks" rows="2" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition" placeholder="Optional remarks">{{ old('remarks') }}</textarea>
                @error('remarks') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Stock
                </button>
                <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
