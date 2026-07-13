@extends('layouts.admin')
@section('title', 'Stock Adjustment')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Stock Adjustment</h1>
        <p class="text-sm text-gray-400 mt-1">Increase, decrease, or reset stock levels</p>
    </div>
    <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Inventory
    </a>
</div>

<div class="max-w-2xl">
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
        <form action="{{ route('admin.inventory.adjust.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-300 mb-2">Product <span class="text-red-400">*</span></label>
                <select name="product_id" id="adjustProduct" required class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (SKU: {{ $product->sku ?: 'N/A' }}) — Current Stock: {{ $product->stock }}
                        </option>
                    @endforeach
                </select>
                @error('product_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-300 mb-2">Action <span class="text-red-400">*</span></label>
                <div class="flex gap-3">
                    <label class="flex items-center gap-2 px-4 py-2.5 rounded-lg bg-gray-800/50 border border-gray-700/50 cursor-pointer hover:border-emerald-500/30 transition has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-500/10">
                        <input type="radio" name="action" value="increase" {{ old('action', 'increase') === 'increase' ? 'checked' : '' }} class="text-emerald-500 focus:ring-emerald-500/30">
                        <span class="text-sm text-gray-300">Increase</span>
                    </label>
                    <label class="flex items-center gap-2 px-4 py-2.5 rounded-lg bg-gray-800/50 border border-gray-700/50 cursor-pointer hover:border-red-500/30 transition has-[:checked]:border-red-500/50 has-[:checked]:bg-red-500/10">
                        <input type="radio" name="action" value="decrease" {{ old('action') === 'decrease' ? 'checked' : '' }} class="text-red-500 focus:ring-red-500/30">
                        <span class="text-sm text-gray-300">Decrease</span>
                    </label>
                    <label class="flex items-center gap-2 px-4 py-2.5 rounded-lg bg-gray-800/50 border border-gray-700/50 cursor-pointer hover:border-amber-500/30 transition has-[:checked]:border-amber-500/50 has-[:checked]:bg-amber-500/10">
                        <input type="radio" name="action" value="reset" {{ old('action') === 'reset' ? 'checked' : '' }} class="text-amber-500 focus:ring-amber-500/30">
                        <span class="text-sm text-gray-300">Reset</span>
                    </label>
                </div>
                @error('action') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5" id="quantityFields">
                <div id="quantityField">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Quantity <span class="text-red-400">*</span></label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition" placeholder="e.g. 5">
                    @error('quantity') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div id="newStockField" class="hidden">
                    <label class="block text-sm font-medium text-gray-300 mb-2">New Stock Value <span class="text-red-400">*</span></label>
                    <input type="number" name="new_stock" min="0" value="{{ old('new_stock') }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition" placeholder="e.g. 20">
                    @error('new_stock') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Date <span class="text-red-400">*</span></label>
                    <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                    @error('date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-300 mb-2">Remarks</label>
                <textarea name="remarks" rows="2" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition" placeholder="Reason for adjustment">{{ old('remarks') }}</textarea>
                @error('remarks') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium rounded-lg bg-amber-500/10 text-amber-400 hover:bg-amber-500/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Apply Adjustment
                </button>
                <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="action"]');
    const quantityField = document.getElementById('quantityField');
    const newStockField = document.getElementById('newStockField');

    function toggleFields() {
        const selected = document.querySelector('input[name="action"]:checked');
        if (selected?.value === 'reset') {
            quantityField.classList.add('hidden');
            newStockField.classList.remove('hidden');
        } else {
            quantityField.classList.remove('hidden');
            newStockField.classList.add('hidden');
        }
    }

    radios.forEach(r => r.addEventListener('change', toggleFields));
    toggleFields();
});
</script>
@endsection
