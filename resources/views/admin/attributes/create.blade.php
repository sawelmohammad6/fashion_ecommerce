@extends('layouts.admin')
@section('title', 'Create Attribute')
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.attributes.index') }}" class="text-sm text-gray-500 hover:text-gray-300 transition inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        Back to Attributes
    </a>
</div>

<div class="max-w-lg">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Create Attribute</h1>
            <p class="text-sm text-gray-400 mt-1">Define a new product attribute</p>
        </div>
    </div>

    <form action="{{ route('admin.attributes.store') }}" method="POST">
        @csrf

        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Attribute Details</h2>
                    <p class="text-xs text-gray-500">Basic information about this attribute</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" id="attrName" value="{{ old('name') }}"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('name') border-red-500/50 @enderror"
                           oninput="generateSlug(this.value)">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Slug <span class="text-red-400">*</span></label>
                    <input type="text" name="slug" id="attrSlug" value="{{ old('slug') }}"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('slug') border-red-500/50 @enderror font-mono">
                    @error('slug') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="relative inline-flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="status" value="1" checked class="sr-only peer">
                        <div class="w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:after:translate-x-full"></div>
                        <span class="text-sm font-medium text-gray-400 group-hover:text-gray-300 transition">Active</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-5 py-2.5 text-sm font-semibold rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Create Attribute</button>
            <a href="{{ route('admin.attributes.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const slugField = document.getElementById('attrSlug');
    if (slugField) {
        slugField.addEventListener('input', function() { this.dataset.modified = 'true'; });
    }
    function generateSlug(value) {
        const sf = document.getElementById('attrSlug');
        if (!sf || sf.dataset.modified) return;
        sf.value = value.toLowerCase().replace(/[^\w\s-]/g, '').replace(/[\s_]+/g, '-').replace(/^-+|-+$/g, '');
    }
</script>
@endpush
