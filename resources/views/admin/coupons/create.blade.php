@extends('admin.layouts.app')

@section('title', 'Create Coupon')

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Coupons', 'url' => route('admin.coupons.index')], ['label' => 'Create']]" />

<div class="max-w-2xl">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Create Coupon</h2>
    <form action="{{ route('admin.coupons.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Code <span class="text-red-500">*</span></label>
                <input type="text" name="code" value="{{ old('code') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none font-mono uppercase" placeholder="SUMMER20">
                @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Value <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" min="0" name="value" value="{{ old('value') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                @error('value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Min Order Amount</label>
                <input type="number" step="0.01" min="0" name="min_order_amount" value="{{ old('min_order_amount') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Usage Limit</label>
                <input type="number" min="1" name="usage_limit" value="{{ old('usage_limit') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Leave empty for unlimited">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
            <div class="flex items-end pb-2.5">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm font-medium text-gray-700">Active</span>
                </label>
            </div>
        </div>
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Create Coupon</button>
            <a href="{{ route('admin.coupons.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection