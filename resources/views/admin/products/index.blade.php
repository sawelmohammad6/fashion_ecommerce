@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Products']]" />

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Products</h2>
        <p class="text-sm text-gray-500 mt-0.5">Manage your product inventory</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Product
    </a>
</div>

<form method="GET" class="mb-6">
    <div class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
               class="flex-1 min-w-[200px] max-w-sm rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        <select name="category" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="stock" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            <option value="">All Stock</option>
            <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low Stock</option>
            <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Filter</button>
        @if(request('search') || request('category') || request('stock'))
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 transition">Clear</a>
        @endif
    </div>
</form>

<x-admin::admin-table :headers="['ID', 'Product', 'Category', 'Price', 'Stock', 'Status', 'Featured']">
    @forelse($products as $product)
        <tr>
            <td class="px-4 py-3 text-gray-900 font-medium">#{{ $product->id }}</td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-lg">👕</div>
                    @endif
                    <div>
                        <span class="font-medium text-gray-900">{{ $product->name }}</span>
                        <p class="text-xs text-gray-400">{{ $product->slug }}</p>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 text-gray-500 text-sm">{{ $product->category->name ?? 'N/A' }}</td>
            <td class="px-4 py-3">
                <span class="font-medium text-gray-900">${{ number_format($product->price, 2) }}</span>
                @if($product->discount_price)
                    <span class="text-xs text-green-600 block">${{ number_format($product->discount_price, 2) }}</span>
                @endif
            </td>
            <td class="px-4 py-3">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                    {{ $product->stock <= 0 ? 'bg-red-100 text-red-700' : ($product->stock <= 5 ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') }}">
                    {{ $product->stock <= 0 ? 'Out of Stock' : $product->stock }}
                </span>
            </td>
            <td class="px-4 py-3"><x-admin::status-badge :status="$product->status" /></td>
            <td class="px-4 py-3">
                @if($product->featured)
                    <span class="text-yellow-500 text-lg">★</span>
                @else
                    <span class="text-gray-300 text-lg">★</span>
                @endif
            </td>
            <td class="px-4 py-3 text-right">
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">Edit</a>
                    <button type="button" onclick="openModal('deleteProduct-{{ $product->id }}')" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">Delete</button>
                    <x-admin::modal :id="'deleteProduct-' . $product->id" title="Delete Product?" action="{{ route('admin.products.destroy', $product) }}">
                        Are you sure you want to delete <strong>{{ $product->name }}</strong>? This cannot be undone.
                    </x-admin::modal>
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="8" class="px-4 py-8 text-center text-gray-400">No products found.</td></tr>
    @endforelse
</x-admin::admin-table>

<x-admin::pagination :paginator="$products" />
@endsection