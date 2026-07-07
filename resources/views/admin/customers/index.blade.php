@extends('admin.layouts.app')
@section('title', 'Customers')
@section('content')

<x-admin::breadcrumb :items="[['label' => 'Customers']]" />

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-white">Customers</h2>
        <p class="text-sm text-white/40 mt-0.5">{{ $customers->total() }} registered customers</p>
    </div>
</div>

{{-- Search + Per Page --}}
<div class="flex flex-col sm:flex-row gap-3 mb-6">
    <form method="GET" class="flex-1 flex gap-3">
        @if(request('per_page') && request('per_page') != 10)
            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
        @endif
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by name, email, phone, or ID..."
               class="input-glass flex-1 min-w-0">
        <button type="submit" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('admin.customers.index', request()->only('per_page')) }}" class="btn-secondary">Clear</a>
        @endif
    </form>
    <form method="GET" class="flex items-center gap-2 self-end">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        <label class="text-sm text-white/40 whitespace-nowrap">Show</label>
        <select name="per_page" onchange="this.form.submit()" class="input-glass !w-20 !py-2">
            @foreach([10, 25, 50, 100] as $value)
                <option value="{{ $value }}" {{ (int) request('per_page', 10) === $value ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
        <span class="text-sm text-white/40">per page</span>
    </form>
</div>

{{-- Table --}}
<div class="glass-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table-glass">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Registered</th>
                    <th>Status</th>
                    <th class="text-center">Orders</th>
                    <th class="text-right">Total Spent</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($customers as $customer)
                    <tr class="hover:bg-white/[0.02] transition">
                        {{-- Customer --}}
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-xs font-bold text-white shrink-0">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-white/80 truncate">{{ $customer->name }}</p>
                                    <p class="text-xs text-white/30 truncate">
                                        #{{ $customer->id }}{{ $customer->username ? ' @' . $customer->username : '' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- Contact --}}
                        <td>
                            <p class="text-sm text-white/70 truncate max-w-[200px]" title="{{ $customer->email }}">{{ $customer->email }}</p>
                            <p class="text-xs text-white/30">{{ $customer->phone ?? '—' }}</p>
                        </td>

                        {{-- Registered --}}
                        <td class="text-sm text-white/50 whitespace-nowrap">{{ $customer->created_at->format('M d, Y') }}</td>

                        {{-- Status --}}
                        <td>
                            @php
                                $statuses = [
                                    'active'  => ['class' => 'bg-emerald-500/10 text-emerald-400', 'dot' => 'bg-emerald-400'],
                                    'pending' => ['class' => 'bg-amber-500/10 text-amber-400',  'dot' => 'bg-amber-400'],
                                    'blocked' => ['class' => 'bg-red-500/10 text-red-400',       'dot' => 'bg-red-400'],
                                ];
                                $s = $statuses[$customer->status] ?? ['class' => 'bg-gray-500/10 text-gray-400', 'dot' => 'bg-gray-400'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $s['class'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }}"></span>
                                {{ ucfirst($customer->status) }}
                            </span>
                        </td>

                        {{-- Orders --}}
                        <td class="text-center text-sm text-white/80 font-medium">{{ $customer->orders_count }}</td>

                        {{-- Total Spent --}}
                        <td class="text-right text-sm text-white/80 font-medium whitespace-nowrap">{{ formatPrice($customer->spent ?? 0) }}</td>

                        {{-- Actions --}}
                        <td class="text-right">
                            <div class="inline-flex items-center gap-1">
                                <a href="{{ route('admin.customers.show', $customer) }}"
                                   class="px-2.5 py-1.5 text-xs font-medium rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 transition">
                                    View
                                </a>
                                <button type="button" disabled
                                        class="px-2.5 py-1.5 text-xs font-medium rounded-lg bg-blue-500/10 text-blue-400/60 cursor-not-allowed">
                                    Edit
                                </button>
                                <button type="button" disabled
                                        class="px-2.5 py-1.5 text-xs font-medium rounded-lg bg-amber-500/10 text-amber-400/60 cursor-not-allowed">
                                    Block
                                </button>
                                <button type="button" disabled
                                        class="px-2.5 py-1.5 text-xs font-medium rounded-lg bg-red-500/10 text-red-400/60 cursor-not-allowed">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <svg class="w-12 h-12 mx-auto text-white/10 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="text-white/30">
                                @if(request('search'))
                                    No customers match "{{ request('search') }}".
                                @else
                                    No customers registered yet.
                                @endif
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
    <p class="text-sm text-white/30">
        Showing <span class="text-white/50">{{ $customers->firstItem() ?? 0 }}</span>
        – <span class="text-white/50">{{ $customers->lastItem() ?? 0 }}</span>
        of <span class="text-white/50">{{ $customers->total() }}</span> customers
    </p>
    {{ $customers->onEachSide(2)->links() }}
</div>

@endsection
