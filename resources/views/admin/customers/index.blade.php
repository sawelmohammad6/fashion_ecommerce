@extends('admin.layouts.app')

@section('title', 'Customers')

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Customers']]" />

<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900">Customers</h2>
    <p class="text-sm text-gray-500 mt-0.5">View registered customers</p>
</div>

<form method="GET" class="mb-6">
    <div class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
               class="flex-1 max-w-sm rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Search</button>
        @if(request('search'))
            <a href="{{ route('admin.customers.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 transition">Clear</a>
        @endif
    </div>
</form>

<x-admin::admin-table :headers="['#', 'Name', 'Email', 'Orders', 'Joined']">
    @forelse($customers as $customer)
        <tr>
            <td class="px-4 py-3 text-gray-900 font-medium">#{{ $customer->id }}</td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-medium">{{ substr($customer->name, 0, 1) }}</div>
                    <span class="font-medium text-gray-900">{{ $customer->name }}</span>
                </div>
            </td>
            <td class="px-4 py-3 text-gray-500">{{ $customer->email }}</td>
            <td class="px-4 py-3"><span class="font-medium text-gray-900">{{ $customer->orders_count }}</span></td>
            <td class="px-4 py-3 text-gray-400 text-xs">{{ $customer->created_at->format('d M Y') }}</td>
            <td class="px-4 py-3 text-right">
                <a href="{{ route('admin.customers.show', $customer) }}" class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">View</a>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No customers found.</td></tr>
    @endforelse
</x-admin::admin-table>

<x-admin::pagination :paginator="$customers" />
@endsection