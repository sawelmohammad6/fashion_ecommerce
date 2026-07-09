@extends('layouts.admin')
@section('title', 'Edit Coupon')
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Coupons', 'url' => route('admin.coupons.index')], ['label' => 'Edit']]" />
<div class="max-w-2xl">
    <h2 class="text-xl font-bold text-white mb-6">Edit Coupon</h2>
    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="glass-card p-6 space-y-5">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-white/60 mb-1">Code <span class="text-red-400">*</span></label><input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="input-glass">@error('code')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror</div>
            <div><label class="block text-sm font-medium text-white/60 mb-1">Type</label><select name="type" class="input-glass"><option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>Fixed ($)</option><option value="percentage" {{ old('type', $coupon->type) === 'percentage' ? 'selected' : '' }}>Percentage (%)</option></select></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-white/60 mb-1">Value</label><input type="number" step="0.01" min="0" name="value" value="{{ old('value', $coupon->value) }}" class="input-glass">@error('value')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror</div>
            <div><label class="block text-sm font-medium text-white/60 mb-1">Min Order Amount</label><input type="number" step="0.01" min="0" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount) }}" class="input-glass"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-white/60 mb-1">Usage Limit</label><input type="number" min="0" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" class="input-glass" placeholder="Unlimited"></div>
            <div><label class="block text-sm font-medium text-white/60 mb-1">Expiry Date</label><input type="date" name="expiry_date" value="{{ old('expiry_date', $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d') : '') }}" class="input-glass"></div>
        </div>
        <div><label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="status" value="1" {{ old('status', $coupon->status) ? 'checked' : '' }} class="rounded border-white/20 bg-white/5 text-emerald-500 focus:ring-emerald-500/50"><span class="text-sm font-medium text-white/60">Active</span></label></div>
        <div class="flex items-center gap-3 pt-2"><button type="submit" class="btn-primary">Update Coupon</button><a href="{{ route('admin.coupons.index') }}" class="btn-secondary">Cancel</a></div>
    </form>
</div>
@endsection
