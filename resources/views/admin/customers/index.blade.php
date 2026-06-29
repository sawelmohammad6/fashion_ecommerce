@extends('admin.layouts.app')
@section('title', 'Customers')
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Customers']]" />
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div><h2 class="text-xl font-bold text-white">Customers</h2><p class="text-sm text-white/40 mt-0.5">View your customers</p></div>
</div>
<form method="GET" class="mb-6">
    <div class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customers..." class="input-glass max-w-sm">
        <button type="submit" class="btn-secondary">Search</button>
        @if(request('search'))<a href="{{ route('admin.customers.index') }}" class="btn-secondary">Clear</a>@endif
    </div>
</form>
<x-admin::admin-table :headers="['Name', 'Email', 'Phone', 'Orders', 'Joined']">
    @forelse($customers as $customer)
        <tr>
            <td>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-xs font-bold text-white">{{ substr($customer->name, 0, 1) }}</div>
                    <span class="font-medium text-white/80">{{ $customer->name }}</span>
                </div>
            </td>
            <td class="text-white/50">{{ $customer->email }}</td>
            <td class="text-white/50">{{ $customer->phone ?? 'N/A' }}</td>
            <td class="text-white/80">{{ $customer->orders_count }}</td>
            <td class="text-white/40 text-sm">{{ $customer->created_at->format('M d, Y') }}</td>
            <td class="text-right"><a href="{{ route('admin.customers.show', $customer) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">View</a></td>
        </tr>
    @empty
        <tr><td colspan="6" class="px-4 py-10 text-center text-white/30">No customers found.</td></tr>
    @endforelse
</x-admin::admin-table>
<x-admin::pagination :paginator="$customers" />
@endsection
