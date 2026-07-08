@extends('layouts.admin')
@section('title', 'Customers Report')
@push('styles')
<style>
.chart-placeholder { height: 260px; }
</style>
@endpush
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Reports', 'url' => route('admin.reports.index')], ['label' => 'Customers Report']]" />

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Customers Report</h1>
        <p class="text-sm text-gray-400 mt-1">Customer growth and top spenders</p>
    </div>
    <form method="GET" class="flex items-center gap-2">
        <select name="period" onchange="this.form.submit()" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
            <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Last 30 Days</option>
            <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
            <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Yearly</option>
        </select>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Customers</p>
        <p class="text-2xl font-bold text-white">{{ $totalCustomers }}</p>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Blocked</p>
        <p class="text-2xl font-bold text-red-400">{{ $blockedCustomers }}</p>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Verified</p>
        <p class="text-2xl font-bold text-emerald-400">{{ $verifiedCustomers }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <h2 class="text-sm font-semibold text-gray-300 mb-4">Customer Registrations</h2>
        <div class="chart-placeholder">
            <canvas id="regChart"></canvas>
        </div>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <h2 class="text-sm font-semibold text-gray-300 mb-4">Top Customers by Spending</h2>
        @if($topCustomers->count() > 0)
            <div class="space-y-3">
                @foreach($topCustomers as $customer)
                    <div class="flex items-center justify-between bg-white/5 rounded-xl px-4 py-2.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center text-xs font-bold text-emerald-400 uppercase">{{ substr($customer->name, 0, 2) }}</div>
                            <div>
                                <p class="text-sm font-medium text-gray-300">{{ $customer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $customer->order_count }} orders</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-emerald-400">{{ formatPrice($customer->total_spent) }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 text-center py-4">No customer data yet.</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') return;
    const textColor = 'rgba(255,255,255,0.4)';
    const gridColor = 'rgba(255,255,255,0.05)';
    const labels = @json($registrations->pluck('label'));
    const data = @json($registrations->pluck('count'));

    if (document.getElementById('regChart')) {
        new Chart(document.getElementById('regChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Registrations',
                    data: data,
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139,92,246,0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#8b5cf6',
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: textColor, font: { size: 10 } }, grid: { color: gridColor } },
                    y: { ticks: { color: textColor, font: { size: 10 } }, grid: { color: gridColor } }
                }
            }
        });
    }
});
</script>
@endpush
