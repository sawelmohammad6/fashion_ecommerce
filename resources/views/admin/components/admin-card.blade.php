@props(['title', 'value', 'icon', 'color' => 'indigo', 'subtitle' => null])

@php
    $colors = [
        'indigo' => 'bg-indigo-50 text-indigo-600',
        'blue' => 'bg-blue-50 text-blue-600',
        'green' => 'bg-green-50 text-green-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'red' => 'bg-red-50 text-red-600',
        'purple' => 'bg-purple-50 text-purple-600',
        'teal' => 'bg-teal-50 text-teal-600',
        'pink' => 'bg-pink-50 text-pink-600',
    ];
    $iconBg = $colors[$color] ?? $colors['indigo'];
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $value }}</p>
            @if($subtitle)
                <p class="text-xs text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="w-12 h-12 rounded-lg {{ $iconBg }} flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}" />
            </svg>
        </div>
    </div>
</div>