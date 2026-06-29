@extends('layouts.admin')
@section('title', 'Edit Product')
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-300 transition inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        Back to Products
    </a>
</div>

<div class="max-w-3xl">
    <h1 class="text-2xl font-bold text-white mb-6">Edit Product</h1>
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 space-y-5">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Category <span class="text-red-400">*</span></label>
                <select name="category_id" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('category_id') border-red-500/50 @enderror">
                    <option value="" class="bg-gray-900">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }} class="bg-gray-900">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Name <span class="text-red-400">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('name') border-red-500/50 @enderror">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Slug <span class="text-red-400">*</span></label>
                <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('slug') border-red-500/50 @enderror">
                @error('slug') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Price <span class="text-red-400">*</span></label>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('price') border-red-500/50 @enderror">
                    @error('price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Discount Price</label>
                    <input type="number" step="0.01" min="0" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('discount_price') border-red-500/50 @enderror">
                    @error('discount_price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1.5">Description</label>
            <textarea name="description" rows="4" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div><label class="block text-sm font-medium text-gray-400 mb-1.5">Fabric</label><input type="text" name="fabric" value="{{ old('fabric', $product->fabric) }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition"></div>
            <div><label class="block text-sm font-medium text-gray-400 mb-1.5">Color</label><input type="text" name="color" value="{{ old('color', $product->color) }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition"></div>
            <div><label class="block text-sm font-medium text-gray-400 mb-1.5">Print</label><input type="text" name="print" value="{{ old('print', $product->print) }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-400 mb-1.5">Sizes</label><input type="text" name="size" value="{{ old('size', $product->size) }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition" placeholder="S, M, L, XL"></div>
            <div><label class="block text-sm font-medium text-gray-400 mb-1.5">Stock <span class="text-red-400">*</span></label>
                <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('stock') border-red-500/50 @enderror">
                @error('stock') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror</div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1.5">Thumbnail Image</label>
            @if($product->image)
                <div class="mb-2"><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-20 h-20 rounded-lg object-cover border border-gray-700/50"></div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-500/10 file:text-emerald-400 hover:file:bg-emerald-500/20 transition">
            @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1.5">Gallery Images</label>
            @if($product->gallery_images)
                <div class="flex flex-wrap gap-2 mb-2">
                    @foreach($product->gallery_images as $index => $galleryImage)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $galleryImage) }}" class="w-14 h-14 rounded-lg object-cover border border-gray-700/50">
                            <a href="{{ route('admin.products.deleteGalleryImage', [$product, $index]) }}" class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition" onclick="return confirm('Remove this image?')">&times;</a>
                        </div>
                    @endforeach
                </div>
            @endif
            <input type="file" name="gallery_images[]" multiple accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-500/10 file:text-emerald-400 hover:file:bg-emerald-500/20 transition">
            <p class="text-xs text-gray-600 mt-1">Max 5 images, 2MB each.</p>
        </div>
        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} class="rounded bg-gray-800 border-gray-600 text-emerald-500 focus:ring-emerald-500/50">
                <span class="text-sm font-medium text-gray-400">Featured</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }} class="rounded bg-gray-800 border-gray-600 text-emerald-500 focus:ring-emerald-500/50">
                <span class="text-sm font-medium text-gray-400">Active</span>
            </label>
        </div>
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 text-sm font-semibold rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
