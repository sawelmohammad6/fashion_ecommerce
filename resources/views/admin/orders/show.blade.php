@extends('layouts.admin')
@section('title', 'Order #' . $order->id)
@push('styles')
<style>
.timeline-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; position: relative; z-index: 1; }
.timeline-line { width: 2px; flex-shrink: 0; margin: 0 auto; }
</style>
@endpush
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Orders', 'url' => route('admin.orders.index')], ['label' => 'Order #' . $order->id]]" />

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Order #{{ $order->id }}</h1>
        <p class="text-sm text-gray-400 mt-1">Invoice: {{ $order->invoice_no ?? 'N/A' }} &middot; Placed {{ $order->ordered_at?->format('M d, Y h:i A') ?? $order->created_at->format('M d, Y h:i A') }}</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Invoice
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        {{-- Customer Information --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
            <h2 class="text-base font-semibold text-white mb-4">Customer Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Name</span>
                    <p class="text-gray-300 font-medium">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Phone</span>
                    <p class="text-gray-300">{{ $order->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Email</span>
                    <p class="text-gray-300">{{ $order->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Address</span>
                    <p class="text-gray-300">{{ $order->address ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-gray-500">City</span>
                    <p class="text-gray-300">{{ $order->city ?? $order->district ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Country</span>
                    <p class="text-gray-300">{{ $order->country ?? $order->division ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Zip Code</span>
                    <p class="text-gray-300">{{ $order->postal_code ?? $order->zip ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- Product Table --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
            <h2 class="text-base font-semibold text-white mb-4">Order Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b border-gray-800">
                            <th class="px-3 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-3 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">SKU</th>
                            <th class="px-3 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-3 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-3 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr class="border-t border-gray-800/50 hover:bg-white/[0.02] transition">
                            <td class="px-3 py-3">
                                <div class="flex items-center gap-3">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-sm text-gray-500">P</div>
                                    @endif
                                    <span class="text-gray-300 font-medium">{{ $item->product->name ?? 'Deleted Product' }}</span>
                                </div>
                            </td>
                            <td class="px-3 py-3 text-gray-400 text-xs font-mono">{{ $item->product->slug ?? 'N/A' }}</td>
                            <td class="px-3 py-3 text-gray-300">{{ formatPrice($item->price) }}</td>
                            <td class="px-3 py-3 text-gray-400">{{ $item->quantity }}</td>
                            <td class="px-3 py-3 text-emerald-400 font-semibold text-right">{{ formatPrice($item->price * $item->quantity) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Payment Information --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
            <h2 class="text-base font-semibold text-white mb-4">Payment Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Payment Method</span>
                    <p class="text-gray-300 font-medium capitalize">{{ str_replace('_', ' ', $order->payment_method ?? 'N/A') }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Payment Status</span>
                    <p>
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                            @switch($order->payment_status)
                                @case('paid') bg-emerald-500/10 text-emerald-400 @break
                                @case('unpaid') bg-amber-500/10 text-amber-400 @break
                                @case('pending') bg-blue-500/10 text-blue-400 @break
                                @case('refunded') bg-purple-500/10 text-purple-400 @break
                                @default bg-gray-500/10 text-gray-400
                            @endswitch
                        ">{{ $order->payment_status ? ucfirst($order->payment_status) : 'N/A' }}</p>
                    </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        {{-- Order Summary --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
            <h2 class="text-base font-semibold text-white mb-4">Order Summary</h2>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Subtotal</dt>
                    <dd class="text-gray-300">{{ formatPrice($order->subtotal) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Discount</dt>
                    <dd class="text-amber-400">{{ $order->discount > 0 ? '-'.formatPrice($order->discount) : formatPrice(0) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Shipping</dt>
                    <dd class="text-gray-300">{{ formatPrice($order->shipping_charge) }}</dd>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-800">
                    <dt class="text-white font-semibold">Grand Total</dt>
                    <dd class="text-emerald-400 font-bold text-lg">{{ formatPrice($order->grand_total) }}</dd>
                </div>
            </dl>
        </div>

        {{-- Status Update --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
            <h2 class="text-base font-semibold text-white mb-4">Update Status</h2>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Order Status</label>
                    <select name="status" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Payment Status</label>
                    <select name="payment_status" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        @foreach($paymentStatuses as $ps)
                            <option value="{{ $ps }}" {{ $order->payment_status === $ps ? 'selected' : '' }}>{{ ucfirst($ps) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">Update Order</button>
            </form>
        </div>

        {{-- Order Timeline --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
            <h2 class="text-base font-semibold text-white mb-4">Order Timeline</h2>
            <div class="space-y-0">
                @php
                    $timeline = $order->status_timeline ?? [];
                    $allStatuses = ['pending', 'confirmed', 'processing', 'packed', 'shipped', 'delivered'];
                    $currentIdx = array_search($order->status, $allStatuses);
                    $isTerminal = in_array($order->status, ['cancelled', 'returned', 'refunded']);
                @endphp

                @if($isTerminal)
                    @php
                        $termColors = ['dot' => '#ef4444', 'text' => '#ef4444'];
                        if ($order->status === 'returned') { $termColors = ['dot' => '#ec4899', 'text' => '#ec4899']; }
                        if ($order->status === 'refunded') { $termColors = ['dot' => '#f97316', 'text' => '#f97316']; }
                    @endphp
                    <div class="flex items-start gap-3 pb-4">
                        <div class="timeline-dot" style="background: {{ $termColors['dot'] }}; margin-top: 4px;"></div>
                        <div>
                            <p class="text-sm font-medium capitalize" style="color: {{ $termColors['text'] }}">{{ $order->status }}</p>
                            <p class="text-xs text-gray-500">{{ isset($timeline[$order->status]) ? \Carbon\Carbon::parse($timeline[$order->status])->format('M d, Y h:i A') : $order->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                @endif

                @foreach($allStatuses as $idx => $status)
                    @php
                        $hasDate = isset($timeline[$status]);
                        $ts = $hasDate ? $timeline[$status] : null;
                        $isPast = $hasDate || (!$isTerminal && $idx <= $currentIdx);
                        $isCurrent = !$isTerminal && $idx === $currentIdx;
                        $dotBg = $isCurrent ? '#34d399' : ($isPast ? '#10b981' : '#374151');
                        $isLast = $idx >= count($allStatuses) - 1;
                        $lineBg = !$isLast ? ($isPast && ($idx < $currentIdx || $hasDate) ? 'rgba(16,185,129,0.3)' : '#1f2937') : '';
                    @endphp
                    <div class="flex items-start gap-3 relative pb-6 last:pb-0">
                        <div class="flex flex-col items-center">
                            <div class="timeline-dot" style="background: {{ $dotBg }}; {{ $isCurrent ? 'box-shadow: 0 0 0 3px rgba(52,211,153,0.3);' : '' }}"></div>
                            @if(!$isLast)
                                <div class="timeline-line flex-1 w-0.5" style="height: 24px; {{ $lineBg ? 'background: ' . $lineBg . ';' : '' }}"></div>
                            @endif
                        </div>
                        <div class="pb-2">
                            <p class="text-sm font-medium capitalize" style="color: {{ $isPast ? '#d1d5db' : '#4b5563' }}">{{ $status }}</p>
                            @if($ts)
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($ts)->format('M d, Y h:i A') }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Notes --}}
        @if($order->notes)
        <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
            <h2 class="text-base font-semibold text-white mb-2">Order Notes</h2>
            <p class="text-sm text-gray-400">{{ $order->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
