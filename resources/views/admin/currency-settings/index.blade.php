@extends('layouts.admin')
@section('title', 'Currency Settings')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Currency Settings</h1>
        <p class="text-sm text-gray-400 mt-1">Manage your website currency</p>
    </div>
    <a href="{{ route('admin.currency-settings.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Add Currency
    </a>
</div>

<div class="bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Symbol</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rate</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Default</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50">
                @forelse($currencies as $currency)
                    <tr class="hover:bg-white/[0.02] transition">
                        <td class="px-4 py-3 text-gray-500 font-medium">#{{ $currency->id }}</td>
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-300">{{ $currency->currency_name }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-mono font-medium text-gray-300">{{ $currency->currency_code }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xl font-medium text-gray-300">{{ $currency->symbol }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-400 font-mono">{{ number_format($currency->exchange_rate, 4) }}</td>
                        <td class="px-4 py-3">
                            @if($currency->is_default)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400">Default</span>
                            @else
                                <span class="text-gray-600">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($currency->status)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400">Active</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-500/10 text-gray-400">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.currency-settings.toggle', $currency) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium rounded-lg {{ $currency->status ? 'bg-amber-500/10 text-amber-400 hover:bg-amber-500/20' : 'bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20' }} transition">
                                        {{ $currency->status ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <a href="{{ route('admin.currency-settings.edit', $currency) }}" class="px-3 py-1.5 text-xs font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">Edit</a>
                                <button type="button" onclick="openModal('deleteCurrency-{{ $currency->id }}')" class="px-3 py-1.5 text-xs font-medium rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition">Delete</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-4 py-10 text-center text-gray-500">No currencies found. Add your first currency!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Delete Modals --}}
@foreach($currencies as $currency)
    <div id="deleteCurrency-{{ $currency->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4" onclick="if(event.target===this)closeModal('deleteCurrency-{{ $currency->id }}')">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
        <div class="relative bg-gray-900 border border-gray-800 rounded-xl p-6 w-full max-w-md">
            <h3 class="text-lg font-bold text-white mb-2">Delete Currency?</h3>
            <p class="text-sm text-gray-400 mb-6">Are you sure you want to delete <strong class="text-gray-300">{{ $currency->currency_name }} ({{ $currency->currency_code }})</strong>?</p>
            <form action="{{ route('admin.currency-settings.destroy', $currency) }}" method="POST">
                @csrf @method('DELETE')
                <div class="flex items-center gap-3 justify-end">
                    <button type="button" onclick="closeModal('deleteCurrency-{{ $currency->id }}')" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition">Delete</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<script>
function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>
@endsection
