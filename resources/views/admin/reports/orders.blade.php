@extends('layouts.admin')
@section('title', 'Orders Report')
@push('styles')
<style>
.chart-placeholder { height: 260px; }
</style>
@endpush
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Reports', 'url' => route('admin.reports.index')], ['label' => 'Orders Report']]" />

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Orders Report</h1>
        <p class="text-sm text-gray-400 mt-1">Analyze order patterns and statuses</p>
    </div>
</div>

<form method="GET" class="flex flex-wrap items-center gap-3 mb-8">
    <select name="status" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
        <option value="">All Statuses</option>
        @foreach(['pending','processing','shipped','delivered','completed','cancelled','returned'] as $s)
            <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <select name="payment_status" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
        <option value="">All Payments</option>
        @foreach(['pending','paid','failed','refunded','completed'] as $ps)
            <option value="{{ $ps }}" {{ $paymentStatus === $ps ? 'selected' : '' }}>{{ ucfirst($ps) }}</option>
        @endforeach
    </select>
    <input type="date" name="date_from" value="{{ $dateFrom }}" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
    <input type="date" name="date_to" value="{{ $dateTo }}" class="bg-gray-800 border border-gray-700 text-gray-300 text-sm rounded-lg px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
    <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Filter</button>
    <a href="{{ route('admin.reports.orders') }}" class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-medium px-4 py-2 rounded-lg transition">Reset</a>
</form>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <h2 class="text-sm font-semibold text-gray-300 mb-4">Orders by Status</h2>
        <div class="chart-placeholder">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
        <h2 class="text-sm font-semibold text-gray-300 mb-4">Orders by Payment Status</h2>
        <div class="chart-placeholder">
            <canvas id="paymentChart"></canvas>
        </div>
    </div>
</div>

<div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5">
    <h2 class="text-sm font-semibold text-gray-300 mb-4">Orders List</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-800">
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Payment</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-t border-gray-800/50 hover:bg-white/[0.02] transition">
                    <td class="px-4 py-3 text-gray-300 font-medium">#{{ $order->id }}</td>
                    <td class="px-4 py-3 text-gray-400">{{ $order->user->name ?? $order->customer_name ?? 'N/A' }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                            @switch($order->status)
                                @case('delivered') @case('completed') bg-emerald-500/10 text-emerald-400 @break
                                @case('processing') bg-blue-500/10 text-blue-400 @break
                                @case('shipped') bg-purple-500/10 text-purple-400 @break
                                @case('cancelled') bg-red-500/10 text-red-400 @break
                                @case('returned') bg-amber-500/10 text-amber-400 @break
                                @default bg-gray-500/10 text-gray-400
                            @endswitch
                        ">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                            @switch($order->payment_status)
                                @case('paid') @case('completed') bg-emerald-500/10 text-emerald-400 @break
                                @case('pending') bg-amber-500/10 text-amber-400 @break
                                @case('failed') bg-red-500/10 text-red-400 @break
                                @case('refunded') bg-purple-500/10 text-purple-400 @break
                                @default bg-gray-500/10 text-gray-400
                            @endswitch
                        ">{{ ucfirst($order->payment_status) }}</span>
                    </td>
                    <td class="px-4 py-3 text-gray-300 font-medium">{{ formatPrice($order->grand_total) }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $order->ordered_at?->format('M d, Y') ?? $order->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') return;
    const textColor = 'rgba(255,255,255,0.4)';

    const statusLabels = @json($ordersByStatus->keys());
    const statusData = @json($ordersByStatus->values());
    const payLabels = @json($ordersByPayment->keys());
    const payData = @json($ordersByPayment->values());

    const colors = ['#10b981','#3b82f6','#f59e0b','#8b5cf6','#ef4444','#06b6d4','#ec4899'];

    if (document.getElementById('statusChart')) {
        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Orders',
                    data: statusData,
                    backgroundColor: colors.slice(0, statusLabels.length).map(c => c + '33'),
                    borderColor: colors.slice(0, statusLabels.length),
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: textColor, font: { size: 10 } }, grid: { color: 'rgba(255,255,255,0.05)' } },
                    y: { ticks: { color: textColor, font: { size: 10 } }, grid: { color: 'rgba(255,255,255,0.05)' } }
                }
            }
        });
    }

    if (document.getElementById('paymentChart')) {
        new Chart(document.getElementById('paymentChart'), {
            type: 'doughnut',
            data: {
                labels: payLabels,
                datasets: [{
                    data: payData,
                    backgroundColor: colors.slice(0, payLabels.length),
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: textColor, font: { size: 10 }, padding: 12, usePointStyle: true, pointStyle: 'circle' }
                    }
                }
            }
        });
    }
});
</script>
@endpush
