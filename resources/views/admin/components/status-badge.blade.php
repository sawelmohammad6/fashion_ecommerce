@props(['status' => 'active', 'type' => 'status'])
@php
    $orderMap = [
        'pending' => 'bg-amber-500/10 text-amber-400',
        'confirmed' => 'bg-blue-500/10 text-blue-400',
        'processing' => 'bg-indigo-500/10 text-indigo-400',
        'shipped' => 'bg-purple-500/10 text-purple-400',
        'delivered' => 'bg-emerald-500/10 text-emerald-400',
        'cancelled' => 'bg-red-500/10 text-red-400',
        'returned' => 'bg-gray-500/10 text-gray-400',
    ];
    $paymentMap = [
        'pending' => 'bg-amber-500/10 text-amber-400',
        'paid' => 'bg-emerald-500/10 text-emerald-400',
        'failed' => 'bg-red-500/10 text-red-400',
        'refunded' => 'bg-purple-500/10 text-purple-400',
    ];
    $statusMap = [
        'active' => 'bg-emerald-500/10 text-emerald-400',
        'inactive' => 'bg-gray-500/10 text-gray-400',
        1 => 'bg-emerald-500/10 text-emerald-400',
        0 => 'bg-gray-500/10 text-gray-400',
        true => 'bg-emerald-500/10 text-emerald-400',
        false => 'bg-gray-500/10 text-gray-400',
    ];

    $class = match ($type) {
        'order' => $orderMap[$status] ?? 'bg-gray-500/10 text-gray-400',
        'payment' => $paymentMap[$status] ?? 'bg-gray-500/10 text-gray-400',
        default => $statusMap[$status] ?? 'bg-gray-500/10 text-gray-400',
    };

    $label = is_bool($status) || is_numeric($status) ? ($status ? 'Active' : 'Inactive') : ucfirst($status);
@endphp
<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $class }}">{{ $label }}</span>
