@extends('layouts.admin')
@section('title', 'Create Coupon')
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Coupons', 'url' => route('admin.coupons.index')], ['label' => 'Create']]" />
<div class="max-w-2xl">
    <h2 class="text-xl font-bold text-white mb-6">Create Coupon</h2>
    <form action="{{ route('admin.coupons.store') }}" method="POST" class="glass-card p-6 space-y-5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-white/60 mb-1">Code <span class="text-red-400">*</span></label>
                <input type="text" name="code" value="{{ old('code') }}" class="input-glass @error('code') border-red-500/50 @enderror" placeholder="SUMMER20">
                @error('code') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror</div>
            <div><label class="block text-sm font-medium text-white/60 mb-1">Type <span class="text-red-400">*</span></label>
                <select name="type" class="input-glass"><option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed ($)</option><option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option></select></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-white/60 mb-1">Value <span class="text-red-400">*</span></label>
                <input type="number" step="0.01" min="0" name="value" value="{{ old('value') }}" class="input-glass @error('value') border-red-500/50 @enderror">
                @error('value') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror</div>
            <div><label class="block text-sm font-medium text-white/60 mb-1">Min Order Amount</label>
                <input type="number" step="0.01" min="0" name="min_order_amount" value="{{ old('min_order_amount', 0) }}" class="input-glass"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-white/60 mb-1">Usage Limit</label>
                <input type="number" min="0" name="usage_limit" value="{{ old('usage_limit') }}" class="input-glass" placeholder="Unlimited"></div>
            <div><label class="block text-sm font-medium text-white/60 mb-1">Expiry Date</label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="input-glass"></div>
        </div>
        <div><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="rounded border-white/20 bg-white/5 text-emerald-500 focus:ring-emerald-500/50"><span class="text-sm font-medium text-white/60">Active</span></label></div>
        <div class="flex items-center gap-3 pt-2"><button type="submit" class="btn-primary">Create Coupon</button><a href="{{ route('admin.coupons.index') }}" class="btn-secondary">Cancel</a></div>
    </form>
</div>
@endsection
