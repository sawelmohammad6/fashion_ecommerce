@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Categories']]" />

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Categories</h2>
        <p class="text-sm text-gray-500 mt-0.5">Manage product categories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Category
    </a>
</div>

<form method="GET" class="mb-6">
    <div class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..."
               class="flex-1 max-w-sm rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition">Search</button>
        @if(request('search'))
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 transition">Clear</a>
        @endif
    </div>
</form>

<x-admin::admin-table :headers="['ID', 'Name', 'Slug', 'Status', 'Products', 'Created']">
    @forelse($categories as $category)
        <tr>
            <td class="px-4 py-3 text-gray-900 font-medium">#{{ $category->id }}</td>
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-10 h-10 rounded-lg object-cover">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-lg">📁</div>
                    @endif
                    <span class="font-medium text-gray-900">{{ $category->name }}</span>
                </div>
            </td>
            <td class="px-4 py-3 text-gray-500">{{ $category->slug }}</td>
            <td class="px-4 py-3"><x-admin::status-badge :status="$category->status" /></td>
            <td class="px-4 py-3 text-gray-500">{{ $category->products()->count() }}</td>
            <td class="px-4 py-3 text-gray-400 text-xs">{{ $category->created_at->format('d M Y') }}</td>
            <td class="px-4 py-3 text-right">
                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">Edit</a>
                    @if($category->trashed())
                        <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 text-xs font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition">Restore</button>
                        </form>
                    @else
                        <button type="button" onclick="openModal('deleteCategory-{{ $category->id }}')" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">Delete</button>
                        <x-admin::modal :id="'deleteCategory-' . $category->id" title="Delete Category?" action="{{ route('admin.categories.destroy', $category) }}">
                            Are you sure you want to delete <strong>{{ $category->name }}</strong>? This action can be undone via restore.
                        </x-admin::modal>
                    @endif
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No categories found.</td></tr>
    @endforelse
</x-admin::admin-table>

<x-admin::pagination :paginator="$categories" />
@endsection