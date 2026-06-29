@extends('admin.layouts.app')

@section('title', 'Coupons')

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Coupons']]" />

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Coupons</h2>
        <p class="text-sm text-gray-500 mt-0.5">Manage discount coupons</p>
    </div>
    <a href="{{ route('admin.coupons.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Add Coupon
    </a>
</div>

<x-admin::admin-table :headers="['Code', 'Type', 'Value', 'Min Order', 'Used', 'Limit', 'Expiry', 'Status']">
    @forelse($coupons as $coupon)
        <tr>
            <td class="px-4 py-3 font-mono font-bold text-gray-900">{{ $coupon->code }}</td>
            <td class="px-4 py-3 capitalize text-gray-600">{{ $coupon->type }}</td>
            <td class="px-4 py-3 font-medium">{{ $coupon->type === 'percentage' ? $coupon->value . '%' : '$' . number_format($coupon->value, 2) }}</td>
            <td class="px-4 py-3 text-gray-500">{{ $coupon->min_order_amount ? '$' . number_format($coupon->min_order_amount, 2) : '-' }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $coupon->used_count }}</td>
            <td class="px-4 py-3 text-gray-500">{{ $coupon->usage_limit ?? '∞' }}</td>
            <td class="px-4 py-3 text-sm text-gray-500">{{ $coupon->expiry_date ? $coupon->expiry_date->format('d M Y') : '-' }}</td>
            <td class="px-4 py-3"><x-admin::status-badge :status="$coupon->status" /></td>
            <td class="px-4 py-3 text-right">
                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">Edit</a>
                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Delete this coupon?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="9" class="px-4 py-8 text-center text-gray-400">No coupons yet.</td></tr>
    @endforelse
</x-admin::admin-table>

<x-admin::pagination :paginator="$coupons" />
@endsection