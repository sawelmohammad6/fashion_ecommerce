@extends('layouts.admin')
@section('title', 'Create Product')
@push('styles')
<style>
    .img-preview { transition: opacity 0.3s ease; }
</style>
@endpush
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-300 transition inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        Back to Products
    </a>
</div>

<div class="max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Create Product</h1>
            <p class="text-sm text-gray-400 mt-1">Add a new product to your catalog</p>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Section 1: Basic Information --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Basic Information</h2>
                    <p class="text-xs text-gray-500">Product name, category, and descriptions</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Product Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" id="productName" value="{{ old('name') }}"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('name') border-red-500/50 @enderror"
                           oninput="generateSlug(this.value)">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Slug <span class="text-red-400">*</span></label>
                    <input type="text" name="slug" id="productSlug" value="{{ old('slug') }}"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('slug') border-red-500/50 @enderror font-mono">
                    @error('slug') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Category <span class="text-red-400">*</span></label>
                    <select name="category_id" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('category_id') border-red-500/50 @enderror">
                        <option value="" class="bg-gray-900">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }} class="bg-gray-900">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" placeholder="e.g. Nike, Zara, H&M"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('brand') border-red-500/50 @enderror">
                    @error('brand') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Short Description <span class="text-red-400">*</span></label>
                <textarea name="description" rows="3"
                          class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('description') border-red-500/50 @enderror">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Full Description</label>
                <textarea name="full_description" rows="6"
                          class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">{{ old('full_description') }}</textarea>
                <p class="text-xs text-gray-600 mt-1">Supports HTML content for rich product descriptions.</p>
            </div>
        </div>

        {{-- Section 2: Pricing --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Pricing</h2>
                    <p class="text-xs text-gray-500">Cost, selling price, and discounting</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Buying Price (Cost)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">$</span>
                        <input type="number" step="0.01" min="0" name="buying_price" value="{{ old('buying_price') }}"
                               class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg pl-7 pr-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('buying_price') border-red-500/50 @enderror">
                    </div>
                    @error('buying_price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Regular Price <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">$</span>
                        <input type="number" step="0.01" min="0" name="price" id="regularPrice" value="{{ old('price') }}"
                               class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg pl-7 pr-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('price') border-red-500/50 @enderror"
                               oninput="calculateFinalPrice()">
                    </div>
                    @error('price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Discount Type</label>
                    <select name="discount_type" id="discountType" onchange="calculateFinalPrice()"
                            class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                        <option value="" class="bg-gray-900">No Discount</option>
                        <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }} class="bg-gray-900">Fixed ($)</option>
                        <option value="percentage" {{ old('discount_type') === 'percentage' ? 'selected' : '' }} class="bg-gray-900">Percentage (%)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Discount Value</label>
                    <input type="number" step="0.01" min="0" name="discount_price" id="discountPrice" value="{{ old('discount_price') }}"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('discount_price') border-red-500/50 @enderror"
                           oninput="calculateFinalPrice()">
                    @error('discount_price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Final Selling Price</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">$</span>
                        <input type="text" id="finalPrice" readonly
                               class="w-full bg-gray-800/30 border border-gray-700/30 rounded-lg pl-7 pr-4 py-2.5 text-sm text-emerald-400 font-semibold outline-none cursor-default">
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Media --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Media</h2>
                    <p class="text-xs text-gray-500">Product images and video</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Thumbnail Image <span class="text-red-400">*</span></label>
                    <div class="border-2 border-dashed border-gray-700/50 rounded-lg p-4 text-center hover:border-emerald-500/30 transition cursor-pointer" onclick="document.getElementById('thumbnailInput').click()">
                        <div id="thumbnailPreview" class="hidden mb-3">
                            <img id="thumbnailImg" class="w-24 h-24 rounded-lg object-cover mx-auto border border-gray-700/50">
                        </div>
                        <div id="thumbnailPlaceholder">
                            <svg class="w-8 h-8 text-gray-600 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-xs text-gray-500">Click to upload thumbnail</p>
                            <p class="text-xs text-gray-600 mt-0.5">jpg, jpeg, png, webp • Max 2MB</p>
                        </div>
                    </div>
                    <input type="file" name="image" id="thumbnailInput" accept="image/*" class="hidden" onchange="previewThumbnail(this)">
                    @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Gallery Images</label>
                    <div class="border-2 border-dashed border-gray-700/50 rounded-lg p-4 text-center hover:border-emerald-500/30 transition cursor-pointer" onclick="document.getElementById('galleryInput').click()">
                        <div id="galleryPreviews" class="flex flex-wrap gap-2 mb-3 hidden"></div>
                        <div id="galleryPlaceholder">
                            <svg class="w-8 h-8 text-gray-600 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-xs text-gray-500">Click to upload gallery images</p>
                            <p class="text-xs text-gray-600 mt-0.5">Max 5 images, 2MB each</p>
                        </div>
                    </div>
                    <input type="file" name="gallery_images[]" id="galleryInput" multiple accept="image/*" class="hidden" onchange="previewGallery(this)">
                    @error('gallery_images.*') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Product Video URL</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=..."
                       class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('video_url') border-red-500/50 @enderror">
                @error('video_url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Section 4: Product Variations --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Product Variations</h2>
                    <p class="text-xs text-gray-500">Add size, color, and other variant options</p>
                </div>
            </div>

            <div id="variationsContainer">
                <div class="variation-card bg-gray-900/30 border border-gray-700/50 rounded-xl p-4 mb-3">
                    <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-800/50">
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="toggleVariation(this)" class="p-1 rounded-lg text-gray-500 hover:text-gray-300 hover:bg-gray-800 transition">
                                <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <span class="text-sm font-semibold text-gray-300 variation-title">Variation #1</span>
                        </div>
                        <button type="button" onclick="removeVariation(this)" class="p-1.5 rounded-lg text-gray-500 hover:text-red-400 hover:bg-red-500/10 transition" title="Remove">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                    <div class="variation-body">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Size</label>
                                <input type="text" name="variations[0][size]" placeholder="S, M, L"
                                       class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Color</label>
                                <input type="text" name="variations[0][color]" placeholder="Red, Blue"
                                       class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Fabric</label>
                                <input type="text" name="variations[0][fabric]" placeholder="Cotton"
                                       class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Print</label>
                                <input type="text" name="variations[0][print]" placeholder="Solid"
                                       class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">SKU</label>
                                <input type="text" name="variations[0][sku]" placeholder="SKU-001"
                                       class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Extra Price</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 text-sm">$</span>
                                    <input type="number" step="0.01" min="0" name="variations[0][extra_price]" placeholder="0.00"
                                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg pl-7 pr-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Stock</label>
                                <input type="number" min="0" name="variations[0][stock]" placeholder="0"
                                       class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" onclick="addVariation()"
                    class="mt-2 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Variation
            </button>
        </div>

        {{-- Section 5: Inventory --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Inventory</h2>
                    <p class="text-xs text-gray-500">Stock management and tracking</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Stock <span class="text-red-400">*</span></label>
                    <input type="number" min="0" name="stock" value="{{ old('stock', 0) }}"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('stock') border-red-500/50 @enderror">
                    @error('stock') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" placeholder="e.g. PROD-001"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Barcode</label>
                    <input type="text" name="barcode" value="{{ old('barcode') }}" placeholder="UPC / EAN"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                </div>
            </div>
        </div>

        {{-- Section 6: Product Settings --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Product Settings</h2>
                    <p class="text-xs text-gray-500">Visibility and availability options</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-6">
                <label class="relative inline-flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:bg-amber-500 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:after:translate-x-full"></div>
                    <span class="text-sm font-medium text-gray-400 group-hover:text-gray-300 transition">Featured Product</span>
                </label>

                <label class="relative inline-flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:after:translate-x-full"></div>
                    <span class="text-sm font-medium text-gray-400 group-hover:text-gray-300 transition">Active</span>
                </label>

                <label class="relative inline-flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" name="pre_order" value="1" {{ old('pre_order') ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:bg-purple-500 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:after:translate-x-full"></div>
                    <span class="text-sm font-medium text-gray-400 group-hover:text-gray-300 transition">Pre Order</span>
                </label>
            </div>
        </div>

        {{-- Section 7: SEO --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">SEO</h2>
                    <p class="text-xs text-gray-500">Search engine optimization metadata</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Product title for search engines"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Meta Description</label>
                    <textarea name="meta_description" rows="2" placeholder="Brief description for search results"
                              class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">{{ old('meta_description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="fashion, clothing, style"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                    <p class="text-xs text-gray-600 mt-1">Comma-separated keywords</p>
                </div>
            </div>
        </div>

        {{-- Section 8: Product Attributes --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Product Attributes</h2>
                    <p class="text-xs text-gray-500">Select attribute values for this product</p>
                </div>
            </div>
            <div id="attributesContainer">
                <p class="text-sm text-gray-500">Select a category first to load available attributes.</p>
            </div>
        </div>

        {{-- Section 9: Actions --}}
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-5 py-2.5 text-sm font-semibold rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Save Product</button>
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</a>
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition ml-auto">Back</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script>
        const slugField = document.getElementById('productSlug');
        if (slugField) {
            slugField.addEventListener('input', function() { this.dataset.modified = 'true'; });
        }

        function generateSlug(value) {
            const slugField = document.getElementById('productSlug');
            if (!slugField || slugField.dataset.modified) return;
            slugField.value = value.toLowerCase()
                .replace(/[^\w\s-]/g, '').replace(/[\s_]+/g, '-').replace(/^-+|-+$/g, '');
        }

        function calculateFinalPrice() {
            const price = parseFloat(document.getElementById('regularPrice').value) || 0;
            const discountType = document.getElementById('discountType').value;
            const discountValue = parseFloat(document.getElementById('discountPrice').value) || 0;
            let finalPrice = price;

            if (discountType === 'fixed') {
                finalPrice = price - discountValue;
            } else if (discountType === 'percentage') {
                finalPrice = price - (price * discountValue / 100);
            }

            document.getElementById('finalPrice').value = Math.max(0, finalPrice).toFixed(2);
        }

        function previewThumbnail(input) {
            const preview = document.getElementById('thumbnailPreview');
            const placeholder = document.getElementById('thumbnailPlaceholder');
            const img = document.getElementById('thumbnailImg');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) { img.src = e.target.result; preview.classList.remove('hidden'); placeholder.classList.add('hidden'); };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewGallery(input) {
            const container = document.getElementById('galleryPreviews');
            const placeholder = document.getElementById('galleryPlaceholder');
            container.innerHTML = '';
            if (input.files && input.files.length > 0) {
                placeholder.classList.add('hidden');
                container.classList.remove('hidden');
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative group';
                    const img = document.createElement('img');
                    img.className = 'w-14 h-14 rounded-lg object-cover border border-gray-700/50';
                    reader.onload = function(e) { img.src = e.target.result; };
                    reader.readAsDataURL(file);
                    wrapper.appendChild(img);
                    container.appendChild(wrapper);
                });
            } else {
                placeholder.classList.remove('hidden');
                container.classList.add('hidden');
            }
        }

        let variationIndex = 1;

        function toggleVariation(btn) {
            const body = btn.closest('.variation-card').querySelector('.variation-body');
            body.classList.toggle('hidden');
            btn.querySelector('svg').classList.toggle('rotate-180');
        }

        function addVariation() {
            const container = document.getElementById('variationsContainer');
            const idx = variationIndex++;
            const num = container.querySelectorAll('.variation-card').length + 1;
            container.insertAdjacentHTML('beforeend',
                `<div class="variation-card bg-gray-900/30 border border-gray-700/50 rounded-xl p-4 mb-3">
                    <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-800/50">
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="toggleVariation(this)" class="p-1 rounded-lg text-gray-500 hover:text-gray-300 hover:bg-gray-800 transition">
                                <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <span class="text-sm font-semibold text-gray-300 variation-title">Variation #${num}</span>
                        </div>
                        <button type="button" onclick="removeVariation(this)" class="p-1.5 rounded-lg text-gray-500 hover:text-red-400 hover:bg-red-500/10 transition" title="Remove">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                    <div class="variation-body">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Size</label>
                                <input type="text" name="variations[${idx}][size]" placeholder="S, M, L" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Color</label>
                                <input type="text" name="variations[${idx}][color]" placeholder="Red, Blue" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Fabric</label>
                                <input type="text" name="variations[${idx}][fabric]" placeholder="Cotton" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Print</label>
                                <input type="text" name="variations[${idx}][print]" placeholder="Solid" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">SKU</label>
                                <input type="text" name="variations[${idx}][sku]" placeholder="SKU-001" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Extra Price</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-600 text-sm">$</span>
                                    <input type="number" step="0.01" min="0" name="variations[${idx}][extra_price]" placeholder="0.00" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg pl-7 pr-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Stock</label>
                                <input type="number" min="0" name="variations[${idx}][stock]" placeholder="0" class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                            </div>
                        </div>
                    </div>
                </div>`
            );
        }

        function removeVariation(btn) {
            const card = btn.closest('.variation-card');
            card.remove();
            document.querySelectorAll('#variationsContainer .variation-card').forEach((el, i) => {
                el.querySelector('.variation-title').textContent = 'Variation #' + (i + 1);
            });
        }

        calculateFinalPrice();

        const categorySelect = document.querySelector('select[name="category_id"]');
        const attributesContainer = document.getElementById('attributesContainer');

        if (categorySelect) {
            categorySelect.addEventListener('change', function() {
                loadAttributes(this.value);
            });
            if (categorySelect.value) {
                loadAttributes(categorySelect.value);
            }
        }

        function loadAttributes(categoryId) {
            if (!categoryId) {
                attributesContainer.innerHTML = '<p class="text-sm text-gray-500">Select a category first to load available attributes.</p>';
                return;
            }

            attributesContainer.innerHTML = '<p class="text-sm text-gray-500">Loading attributes...</p>';

            fetch('{{ route("admin.attributes.by-category", "__CAT__") }}'.replace('__CAT__', categoryId))
                .then(res => res.json())
                .then(data => {
                    if (!data.data || data.data.length === 0) {
                        attributesContainer.innerHTML = '<p class="text-sm text-gray-500">No attributes defined for this category.</p>';
                        return;
                    }

                    let html = '';
                    data.data.forEach(attr => {
                        if (!attr.values || attr.values.length === 0) return;

                        html += `<div class="mb-4 pb-4 border-b border-gray-800/30 last:border-0 last:mb-0 last:pb-0">`;
                        html += `<p class="text-sm font-medium text-gray-300 mb-2.5">${attr.name}</p>`;
                        html += `<div class="flex flex-wrap gap-2">`;

                        attr.values.forEach(val => {
                            html += `<label class="relative flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gray-800/40 border border-gray-700/50 cursor-pointer hover:border-emerald-500/30 transition has-[:checked]:bg-emerald-500/10 has-[:checked]:border-emerald-500/50 has-[:checked]:text-emerald-400">`;
                            html += `<input type="checkbox" name="attribute_values[]" value="${val.id}" class="sr-only peer">`;
                            html += `<span class="text-sm text-gray-400 peer-checked:text-emerald-400">${val.value}</span>`;
                            html += `</label>`;
                        });

                        html += `</div></div>`;
                    });

                    attributesContainer.innerHTML = html || '<p class="text-sm text-gray-500">No attribute values defined.</p>';
                })
                .catch(() => {
                    attributesContainer.innerHTML = '<p class="text-sm text-red-400">Failed to load attributes.</p>';
                });
        }
    </script>
@endpush
