@props(['status' => 'active', 'type' => 'status'])

@php
    if ($type === 'order') {
        $colors = [
            'pending' => 'bg-amber-100 text-amber-700',
            'confirmed' => 'bg-blue-100 text-blue-700',
            'processing' => 'bg-indigo-100 text-indigo-700',
            'shipped' => 'bg-purple-100 text-purple-700',
            'delivered' => 'bg-green-100 text-green-700',
            'cancelled' => 'bg-red-100 text-red-700',
            'returned' => 'bg-gray-100 text-gray-700',
        ];
    } elseif ($type === 'payment') {
        $colors = [
            'pending' => 'bg-amber-100 text-amber-700',
            'paid' => 'bg-green-100 text-green-700',
            'failed' => 'bg-red-100 text-red-700',
            'refunded' => 'bg-purple-100 text-purple-700',
        ];
    } else {
        $colors = [
            'active' => 'bg-green-100 text-green-700',
            'inactive' => 'bg-gray-100 text-gray-600',
            1 => 'bg-green-100 text-green-700',
            0 => 'bg-gray-100 text-gray-600',
            true => 'bg-green-100 text-green-700',
            false => 'bg-gray-100 text-gray-600',
        ];
    }

    $label = is_bool($status) || is_numeric($status) ? ($status ? 'Active' : 'Inactive') : ucfirst($status);
    $color = $colors[$status] ?? 'bg-gray-100 text-gray-600';
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $color }}">
    {{ $label }}
</span>