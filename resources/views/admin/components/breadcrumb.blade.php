@props(['items' => []])
<nav class="flex items-center gap-2 text-sm text-white/30 mb-6">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-400 transition">Dashboard</a>
    @foreach($items as $item)
        <span class="text-white/20">/</span>
        @if(isset($item['url']))
            <a href="{{ $item['url'] }}" class="hover:text-emerald-400 transition">{{ $item['label'] }}</a>
        @else
            <span class="text-white/80 font-medium">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
