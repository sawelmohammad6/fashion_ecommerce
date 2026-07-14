@extends('layouts.admin')
@section('title', 'Activity Logs')
@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Activity Logs</h1>
        <p class="text-sm text-gray-400 mt-1">Track all admin actions across the system</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.activity-logs.export.csv') }}?{{ http_build_query(request()->only(['search', 'module', 'user_id', 'date_filter'])) }}"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export CSV
        </a>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="mb-6">
    <div class="flex flex-wrap gap-3">
        <div class="relative flex-1 min-w-[200px] max-w-sm">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search admin, module, action..." class="w-full bg-gray-800/50 border border-gray-700/50 rounded-lg pl-9 pr-4 py-2.5 text-sm text-gray-300 placeholder-gray-500 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition">
        </div>
        <select name="module" class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition min-w-[150px]">
            <option value="">All Modules</option>
            @foreach($modules as $mod)
                <option value="{{ $mod }}" {{ request('module') === $mod ? 'selected' : '' }}>{{ $mod }}</option>
            @endforeach
        </select>
        <select name="user_id" class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition min-w-[150px]">
            <option value="">All Admins</option>
            @foreach($admins as $admin)
                <option value="{{ $admin->id }}" {{ request('user_id') == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
            @endforeach
        </select>
        <select name="date_filter" class="bg-gray-800/50 border border-gray-700/50 rounded-lg px-4 py-2.5 text-sm text-gray-300 outline-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/20 transition min-w-[140px]">
            <option value="">All Time</option>
            <option value="today" {{ request('date_filter') === 'today' ? 'selected' : '' }}>Today</option>
            <option value="yesterday" {{ request('date_filter') === 'yesterday' ? 'selected' : '' }}>Yesterday</option>
            <option value="week" {{ request('date_filter') === 'week' ? 'selected' : '' }}>This Week</option>
            <option value="month" {{ request('date_filter') === 'month' ? 'selected' : '' }}>This Month</option>
        </select>
        <button type="submit" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Filter</button>
        @if(request('search') || request('module') || request('user_id') || request('date_filter'))
            <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Clear</a>
        @endif
    </div>
</form>

{{-- Table --}}
<div class="bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800 bg-gray-900/30">
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Module</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-4 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/30">
                @forelse($logs as $log)
                <tr class="hover:bg-white/[0.03] transition-colors">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <p class="text-sm text-gray-200">{{ $log->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $log->created_at->format('h:i A') }}</p>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            @if($log->user)
                                <div class="w-7 h-7 rounded-full bg-emerald-500/10 flex items-center justify-center text-xs font-medium text-emerald-400">
                                    {{ substr($log->user->name, 0, 2) }}
                                </div>
                                <span class="text-sm font-medium text-gray-200">{{ $log->user->name }}</span>
                            @else
                                <div class="w-7 h-7 rounded-full bg-gray-500/10 flex items-center justify-center text-xs font-medium text-gray-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-400">System</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-500/10 text-gray-300">{{ $log->module }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $actionColors = [
                                'Created' => 'bg-emerald-500/10 text-emerald-400',
                                'Uploaded' => 'bg-emerald-500/10 text-emerald-400',
                                'Updated' => 'bg-blue-500/10 text-blue-400',
                                'Stock In' => 'bg-emerald-500/10 text-emerald-400',
                                'Stock Out' => 'bg-red-500/10 text-red-400',
                                'Adjustment' => 'bg-amber-500/10 text-amber-400',
                                'Deleted' => 'bg-red-500/10 text-red-400',
                                'Restored' => 'bg-purple-500/10 text-purple-400',
                                'Blocked' => 'bg-red-500/10 text-red-400',
                                'Unblocked' => 'bg-emerald-500/10 text-emerald-400',
                                'Login' => 'bg-emerald-500/10 text-emerald-400',
                                'Logout' => 'bg-gray-500/10 text-gray-400',
                                'Password Changed' => 'bg-amber-500/10 text-amber-400',
                                'Status Changed' => 'bg-blue-500/10 text-blue-400',
                                'Replaced' => 'bg-amber-500/10 text-amber-400',
                                'Changed' => 'bg-blue-500/10 text-blue-400',
                            ];
                            $color = $actionColors[$log->action] ?? 'bg-gray-500/10 text-gray-300';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $color }}">{{ $log->action }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-400 max-w-xs truncate" title="{{ $log->description }}">{{ $log->description ?? '—' }}</td>
                    <td class="px-4 py-3 text-xs text-gray-500 font-mono hidden lg:table-cell">{{ $log->ip_address ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-gray-500">No activity logs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($logs->hasPages())
    <div class="mt-5">{{ $logs->links() }}</div>
@endif
@endsection
