@props(['title', 'value', 'icon', 'color' => 'emerald', 'subtitle' => null])
@php
    $colors = [
        'emerald' => 'from-emerald-400/20 to-emerald-600/10 text-emerald-400',
        'blue' => 'from-blue-400/20 to-blue-600/10 text-blue-400',
        'amber' => 'from-amber-400/20 to-amber-600/10 text-amber-400',
        'red' => 'from-red-400/20 to-red-600/10 text-red-400',
        'purple' => 'from-purple-400/20 to-purple-600/10 text-purple-400',
        'teal' => 'from-teal-400/20 to-teal-600/10 text-teal-400',
        'pink' => 'from-pink-400/20 to-pink-600/10 text-pink-400',
        'indigo' => 'from-indigo-400/20 to-indigo-600/10 text-indigo-400',
    ];
    $iconBg = $colors[$color] ?? $colors['emerald'];
@endphp
<div class="bg-gray-900/50 border border-gray-800 rounded-xl p-5 transition-all duration-300 hover:translate-y-[-2px] group">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $title }}</p>
            <p class="text-2xl font-bold text-white mt-1.5">{{ $value }}</p>
            @if($subtitle)
                <p class="text-xs text-gray-500 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $iconBg }} flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}" />
            </svg>
        </div>
    </div>
</div>
