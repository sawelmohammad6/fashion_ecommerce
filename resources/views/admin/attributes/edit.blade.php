@extends('layouts.admin')
@section('title', 'Edit Attribute')
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.attributes.index') }}" class="text-sm text-gray-500 hover:text-gray-300 transition inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        Back to Attributes
    </a>
</div>

<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Attribute</h1>
            <p class="text-sm text-gray-400 mt-1">Manage attribute and its values</p>
        </div>
    </div>

    {{-- Update Attribute Form --}}
    <form action="{{ route('admin.attributes.update', $attribute) }}" method="POST" class="mb-6">
        @csrf @method('PUT')

        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-white">Attribute Details</h2>
                    <p class="text-xs text-gray-500">Update attribute information</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $attribute->name) }}"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('name') border-red-500/50 @enderror">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Slug <span class="text-red-400">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug', $attribute->slug) }}"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('slug') border-red-500/50 @enderror font-mono">
                    @error('slug') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="relative inline-flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="status" value="1" {{ old('status', $attribute->status) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:after:translate-x-full"></div>
                        <span class="text-sm font-medium text-gray-400 group-hover:text-gray-300 transition">Active</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-5 py-2.5 text-sm font-semibold rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Update Attribute</button>
            <a href="{{ route('admin.attributes.index') }}" class="px-5 py-2.5 text-sm font-semibold rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</a>
        </div>
    </form>

    {{-- Attribute Values Section --}}
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 mb-5">
        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-white">Attribute Values</h2>
                <p class="text-xs text-gray-500">Add, edit, or remove values for this attribute</p>
            </div>
        </div>

        {{-- Existing Values --}}
        @if($attribute->values->count() > 0)
            <div class="space-y-2 mb-4">
                @foreach($attribute->values as $value)
                    <div class="flex items-center gap-2 bg-gray-800/30 border border-gray-700/50 rounded-lg px-4 py-2.5">
                        <span class="flex-1 text-sm text-gray-300">{{ $value->value }}</span>
                        <span class="text-xs text-gray-500 font-mono">{{ $value->slug }}</span>
                        <button type="button" onclick="editValue({{ $value->id }}, '{{ $value->value }}', '{{ $value->slug }}')"
                                class="p-1.5 rounded-lg text-gray-500 hover:text-emerald-400 hover:bg-emerald-500/10 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form action="{{ route('admin.attributes.values.destroy', [$attribute, $value]) }}" method="POST" onsubmit="return confirm('Delete this value?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg text-gray-500 hover:text-red-400 hover:bg-red-500/10 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 text-center py-4">No values yet. Add one below.</p>
        @endif

        {{-- Add New Value Form --}}
        <form action="{{ route('admin.attributes.values.store', $attribute) }}" method="POST" class="mt-4 pt-4 border-t border-gray-800/50">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Value <span class="text-red-400">*</span></label>
                    <input type="text" name="value" id="newValue" placeholder="e.g. Cotton"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('value') border-red-500/50 @enderror"
                           oninput="generateValueSlug(this.value)">
                    @error('value') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Slug <span class="text-red-400">*</span></label>
                    <input type="text" name="slug" id="newValueSlug" placeholder="cotton"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-3 py-2 text-sm text-gray-300 placeholder-gray-600 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('slug') border-red-500/50 @enderror font-mono">
                    @error('slug') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">
                        Add Value
                    </button>
                </div>
            </div>
        </form>

        {{-- Edit Value Modal --}}
        <div id="editValueModal" class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center p-4" onclick="if(event.target===this) closeEditModal()">
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 w-full max-w-md shadow-2xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-white">Edit Value</h3>
                    <button type="button" onclick="closeEditModal()" class="p-1 rounded-lg text-gray-500 hover:text-gray-300 hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form id="editValueForm" method="POST">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Value <span class="text-red-400">*</span></label>
                            <input type="text" name="value" id="editValueInput"
                                   class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Slug <span class="text-red-400">*</span></label>
                            <input type="text" name="slug" id="editValueSlug"
                                   class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 font-mono outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                        </div>
                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit" class="px-4 py-2 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Save Changes</button>
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const valueSlugField = document.getElementById('newValueSlug');
    if (valueSlugField) {
        valueSlugField.addEventListener('input', function() { this.dataset.modified = 'true'; });
    }
    function generateValueSlug(value) {
        const sf = document.getElementById('newValueSlug');
        if (!sf || sf.dataset.modified) return;
        sf.value = value.toLowerCase().replace(/[^\w\s-]/g, '').replace(/[\s_]+/g, '-').replace(/^-+|-+$/g, '');
    }

    function editValue(id, value, slug) {
        document.getElementById('editValueInput').value = value;
        document.getElementById('editValueSlug').value = slug;
        document.getElementById('editValueForm').action = '{{ route("admin.attributes.values.update", [$attribute, "__VALUE_ID__"]) }}'.replace('__VALUE_ID__', id);
        document.getElementById('editValueModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editValueModal').classList.add('hidden');
    }
</script>
@endpush
