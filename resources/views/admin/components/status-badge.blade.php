@props(['status' => 'active', 'type' => 'status'])
@php
    $map = fn($s, $colors) => $colors[$s] ?? 'badge-gray';
    if ($type === 'order') {
        $class = $map($status, [
            'pending' => 'badge-amber', 'confirmed' => 'badge-blue', 'processing' => 'badge-indigo',
            'shipped' => 'badge-purple', 'delivered' => 'badge-emerald', 'cancelled' => 'badge-red', 'returned' => 'badge-gray',
        ]);
    } elseif ($type === 'payment') {
        $class = $map($status, [
            'pending' => 'badge-amber', 'paid' => 'badge-emerald', 'failed' => 'badge-red', 'refunded' => 'badge-purple',
        ]);
    } else {
        $class = $map($status, [
            'active' => 'badge-emerald', 'inactive' => 'badge-gray', 1 => 'badge-emerald', 0 => 'badge-gray', true => 'badge-emerald', false => 'badge-gray',
        ]);
    }
    $label = is_bool($status) || is_numeric($status) ? ($status ? 'Active' : 'Inactive') : ucfirst($status);
@endphp
<span class="{{ $class }}">{{ $label }}</span>
