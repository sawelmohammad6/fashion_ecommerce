@extends('layouts.admin')
@section('title', 'Coupons')
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Coupons']]" />
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div><h2 class="text-xl font-bold text-white">Coupons</h2><p class="text-sm text-white/40 mt-0.5">Manage discount coupons</p></div>
    <a href="{{ route('admin.coupons.create') }}" class="btn-primary"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>Add Coupon</a>
</div>
<x-admin::admin-table :headers="['Code', 'Type', 'Value', 'Min Order', 'Used', 'Expiry', 'Status']">
    @forelse($coupons as $coupon)
        <tr>
            <td><span class="font-mono font-bold text-emerald-400">{{ $coupon->code }}</span></td>
            <td class="text-white/50 uppercase text-xs">{{ $coupon->type }}</td>
            <td class="text-white/80">{{ $coupon->type === 'percentage' ? $coupon->value . '%' : formatPrice($coupon->value) }}</td>
            <td class="text-white/50">{{ formatPrice($coupon->min_order_amount) }}</td>
            <td class="text-white/50">{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}</td>
            <td class="text-white/40 text-sm">{{ $coupon->expiry_date ? $coupon->expiry_date->format('M d, Y') : 'N/A' }}</td>
            <td><x-admin::status-badge :status="$coupon->status" /></td>
            <td class="text-right">
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Edit</a>
                    <button onclick="openModal('deleteCoupon-{{ $coupon->id }}')" class="px-3 py-1.5 text-xs font-medium rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition">Delete</button>
                    <x-admin::modal :id="'deleteCoupon-' . $coupon->id" title="Delete Coupon?" action="{{ route('admin.coupons.destroy', $coupon) }}">Delete <strong>{{ $coupon->code }}</strong>?</x-admin::modal>
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="8" class="px-4 py-10 text-center text-white/30">No coupons found.</td></tr>
    @endforelse
</x-admin::admin-table>
<x-admin::pagination :paginator="$coupons" />
@endsection
