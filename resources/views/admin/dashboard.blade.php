@extends('layouts.admin')
@section('title', 'Dashboard')
@push('styles')
<style>
.chart-placeholder { height: 260px; }
</style>
@endpush
@section('content')
{{-- Welcome --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Welcome back, {{ auth()->user()->name }}</h1>
        <p class="text-sm text-gray-400 mt-1">Here's what's happening with your store today.</p>
    </div>
    <span class="hidden sm:inline text-sm text-gray-500">{{ now()->format('l, F d, Y') }}</span>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    {{-- Revenue --}}
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5 hover:border-gray-700 transition">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Revenue</p>
            <div class="w-9 h-9 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white">$48,295</p>
        <p class="text-xs text-emerald-400 mt-1.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
            12.5% from last month
        </p>
    </div>

    {{-- Orders --}}
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5 hover:border-gray-700 transition">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Orders</p>
            <div class="w-9 h-9 rounded-lg bg-blue-500/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white">1,245</p>
        <p class="text-xs text-emerald-400 mt-1.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
            8.2% from last month
        </p>
    </div>

    {{-- Customers --}}
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5 hover:border-gray-700 transition">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Customers</p>
            <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white">3,487</p>
        <p class="text-xs text-emerald-400 mt-1.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
            3.1% from last month
        </p>
    </div>

    {{-- Conversion Rate --}}
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5 hover:border-gray-700 transition">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Conversion</p>
            <div class="w-9 h-9 rounded-lg bg-amber-500/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-white">3.24%</p>
        <p class="text-xs text-red-400 mt-1.5 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
            0.8% from last month
        </p>
    </div>
</div>

{{-- Charts Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-300">Revenue Overview</h2>
            <span class="text-xs text-gray-500">Last 12 months</span>
        </div>
        <div class="chart-placeholder flex items-center justify-center text-gray-600">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-300">Sales Analytics</h2>
            <span class="text-xs text-gray-500">Last 7 days</span>
        </div>
        <div class="chart-placeholder flex items-center justify-center text-gray-600">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>

{{-- Recent Orders Table --}}
<div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm font-semibold text-gray-300">Recent Orders</h2>
        <a href="#" class="text-xs font-medium text-emerald-400 hover:text-emerald-300 transition">View All</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left">
                    <th class="px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Date</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $orders = [
                        ['id' => '#1254', 'customer' => 'John Doe', 'status' => 'Delivered', 'amount' => '$240.00', 'date' => 'Jan 15, 2026', 'color' => 'emerald'],
                        ['id' => '#1253', 'customer' => 'Sarah Smith', 'status' => 'Processing', 'amount' => '$120.00', 'date' => 'Jan 14, 2026', 'color' => 'blue'],
                        ['id' => '#1252', 'customer' => 'Mike Johnson', 'status' => 'Pending', 'amount' => '$85.00', 'date' => 'Jan 14, 2026', 'color' => 'amber'],
                        ['id' => '#1251', 'customer' => 'Emily Wilson', 'status' => 'Shipped', 'amount' => '$310.00', 'date' => 'Jan 13, 2026', 'color' => 'purple'],
                        ['id' => '#1250', 'customer' => 'Alex Brown', 'status' => 'Delivered', 'amount' => '$175.50', 'date' => 'Jan 13, 2026', 'color' => 'emerald'],
                    ];
                    $statusColors = [
                        'emerald' => 'bg-emerald-500/10 text-emerald-400',
                        'blue' => 'bg-blue-500/10 text-blue-400',
                        'amber' => 'bg-amber-500/10 text-amber-400',
                        'purple' => 'bg-purple-500/10 text-purple-400',
                    ];
                @endphp
                @foreach($orders as $order)
                <tr class="border-t border-gray-800/50 hover:bg-white/[0.02] transition">
                    <td class="px-3 py-3 font-medium text-gray-300">{{ $order['id'] }}</td>
                    <td class="px-3 py-3 text-gray-400">{{ $order['customer'] }}</td>
                    <td class="px-3 py-3">
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$order['color']] }}">{{ $order['status'] }}</span>
                    </td>
                    <td class="px-3 py-3 text-gray-300">{{ $order['amount'] }}</td>
                    <td class="px-3 py-3 text-gray-500 hidden lg:table-cell">{{ $order['date'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart !== 'undefined') {
        const textColor = 'rgba(255,255,255,0.4)';
        const gridColor = 'rgba(255,255,255,0.05)';

        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: [18500, 22300, 19800, 26100, 24200, 28900, 31200, 27800, 33400, 36200, 39800, 48295],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#10b981',
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: textColor, font: { size: 10 } }, grid: { color: gridColor } },
                    y: { ticks: { color: textColor, font: { size: 10 }, callback: v => '$' + v }, grid: { color: gridColor } }
                }
            }
        });

        new Chart(document.getElementById('salesChart'), {
            type: 'bar',
            data: {
                labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                datasets: [{
                    label: 'Sales',
                    data: [3200, 2800, 4100, 3600, 5200, 4800, 6100],
                    backgroundColor: 'rgba(16,185,129,0.3)',
                    borderColor: '#10b981',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: textColor, font: { size: 10 } }, grid: { color: gridColor } },
                    y: { ticks: { color: textColor, font: { size: 10 }, callback: v => '$' + v }, grid: { color: gridColor } }
                }
            }
        });
    }
});
</script>
@endpush
