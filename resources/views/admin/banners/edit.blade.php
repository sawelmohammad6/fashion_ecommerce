@extends('layouts.admin')
@section('title', 'Edit Banner')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Edit Banner</h1>
        <p class="text-sm text-gray-400 mt-1">Update banner details</p>
    </div>
    <a href="{{ route('admin.banners.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back
    </a>
</div>

<div class="max-w-2xl">
    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 space-y-6">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Banner Title</label>
            <input type="text" name="title" value="{{ old('title', $banner->title) }}" required
                   class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
            @error('title') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Banner Image</label>
            <div class="mb-4">
                <p class="text-xs text-gray-500 mb-2">Current banner:</p>
                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full max-h-48 rounded-lg object-cover border border-gray-700/50">
            </div>
            <div class="border-2 border-dashed border-gray-700/50 rounded-lg p-8 text-center hover:border-emerald-500/30 transition cursor-pointer" onclick="document.getElementById('imageInput').click()">
                <svg class="w-10 h-10 mx-auto text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm text-gray-400 mb-1">Click to replace banner image</p>
                <p class="text-xs text-gray-600">JPG, JPEG, PNG, or WebP. Max 5 MB. Leave empty to keep current.</p>
                <p id="fileName" class="text-xs text-emerald-400 mt-2 hidden"></p>
            </div>
            <input id="imageInput" type="file" name="image" accept="image/jpg,image/jpeg,image/png,image/webp" class="hidden" onchange="document.getElementById('fileName').textContent = this.files[0]?.name; document.getElementById('fileName').classList.remove('hidden')">
            @error('image') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', $banner->status) ? 'checked' : '' }}>
                <div class="w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
            </label>
            <span class="text-sm text-gray-300">Set as active banner</span>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Update Banner</button>
            <a href="{{ route('admin.banners.index') }}" class="px-6 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
