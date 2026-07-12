@extends('layouts.admin')
@section('title', $attribute->name . ' Values')
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.attributes.index') }}" class="text-sm text-gray-500 hover:text-gray-300 transition inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        Back to Attributes
    </a>
</div>

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">{{ $attribute->name }}</h1>
        <p class="text-sm text-gray-400 mt-1">Manage values for this attribute</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Add Value Form --}}
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6 lg:col-span-1 h-fit">
        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-800/50">
            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-white">Add Value</h2>
                <p class="text-xs text-gray-500">Create a new value</p>
            </div>
        </div>

        <form action="{{ route('admin.attributes.values.store', $attribute) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Value <span class="text-red-400">*</span></label>
                    <input type="text" name="value" id="newValue" value="{{ old('value') }}" placeholder="e.g. Cotton"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('value') border-red-500/50 @enderror"
                           oninput="generateValueSlug(this.value)">
                    @error('value') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Slug <span class="text-red-400">*</span></label>
                    <input type="text" name="slug" id="newValueSlug" value="{{ old('slug') }}" placeholder="cotton"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 font-mono placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition @error('slug') border-red-500/50 @enderror">
                    @error('slug') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Sort Order</label>
                    <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $attribute->values->max('sort_order') + 1) }}"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                </div>
                <button type="submit" class="w-full px-4 py-2.5 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Add Value</button>
            </div>
        </form>
    </div>

    {{-- Values List --}}
    <div class="lg:col-span-2">
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden shadow-sm">
            <div class="px-4 py-3.5 border-b border-gray-800/50 flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">{{ $attribute->values->count() }} value(s)</p>
            </div>

            @if($attribute->values->count() > 0)
                <div class="divide-y divide-gray-800/30" id="valuesList">
                    @foreach($attribute->values as $value)
                        <div class="flex items-center gap-3 px-4 py-3 hover:bg-white/[0.03] transition-colors" data-value-id="{{ $value->id }}">
                            <div class="flex-1 flex items-center gap-3 min-w-0">
                                <span class="text-sm font-medium text-gray-200">{{ $value->value }}</span>
                                <span class="text-xs text-gray-500 font-mono">{{ $value->slug }}</span>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <span class="text-xs text-gray-600 mr-2">#{{ $value->sort_order }}</span>
                                <button type="button" onclick="editValue(
                                    {{ $value->id }},
                                    '{{ $value->value }}',
                                    '{{ $value->slug }}',
                                    {{ $value->sort_order }}
                                )" class="p-1.5 rounded-lg text-gray-500 hover:text-emerald-400 hover:bg-emerald-500/10 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.attributes.values.destroy', [$attribute, $value]) }}" method="POST" onsubmit="return confirm('Delete this value?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-gray-500 hover:text-red-400 hover:bg-red-500/10 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-4 py-12 text-center text-gray-500">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    <p class="text-sm">No values yet.</p>
                    <p class="text-xs text-gray-600 mt-1">Use the form on the left to add values.</p>
                </div>
            @endif
        </div>
    </div>
</div>

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
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Sort Order</label>
                    <input type="number" min="0" name="sort_order" id="editValueSortOrder"
                           class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-4 py-2 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Save Changes</button>
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</button>
                </div>
            </div>
        </form>
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

    function editValue(id, value, slug, sortOrder) {
        document.getElementById('editValueInput').value = value;
        document.getElementById('editValueSlug').value = slug;
        document.getElementById('editValueSortOrder').value = sortOrder;
        document.getElementById('editValueForm').action = '{{ route("admin.attributes.values.update", [$attribute, "__VALUE_ID__"]) }}'.replace('__VALUE_ID__', id);
        document.getElementById('editValueModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editValueModal').classList.add('hidden');
    }
</script>
@endpush
