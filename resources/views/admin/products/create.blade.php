@extends('admin.layouts.app')

@section('title', 'Create Product')

@push('styles')
<style>
input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
input[type=number] { -moz-appearance: textfield; }
</style>
@endpush

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Products', 'url' => route('admin.products.index')], ['label' => 'Create']]" />

<div class="max-w-3xl">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Create Product</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                <select name="category_id" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('category_id') border-red-300 @enderror">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('name') border-red-300 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug <span class="text-red-500">*</span></label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('slug') border-red-300 @enderror">
                @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('price') border-red-300 @enderror">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount Price</label>
                    <input type="number" step="0.01" min="0" name="discount_price" value="{{ old('discount_price') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('discount_price') border-red-300 @enderror">
                    @error('discount_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fabric</label>
                <input type="text" name="fabric" value="{{ old('fabric') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                <input type="text" name="color" value="{{ old('color') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Print</label>
                <input type="text" name="print" value="{{ old('print') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sizes</label>
                <input type="text" name="size" value="{{ old('size') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="S, M, L, XL">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock <span class="text-red-500">*</span></label>
                <input type="number" min="0" name="stock" value="{{ old('stock', 0) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('stock') border-red-300 @enderror">
                @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Image</label>
            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gallery Images (up to 5)</label>
            <input type="file" name="gallery_images[]" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            <p class="text-xs text-gray-400 mt-1">Max 5 images, 2MB each. jpg, jpeg, png, webp.</p>
            @error('gallery_images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="text-sm font-medium text-gray-700">Featured</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="text-sm font-medium text-gray-700">Active</span>
            </label>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Create Product</button>
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection