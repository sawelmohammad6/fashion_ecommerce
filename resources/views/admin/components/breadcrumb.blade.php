@props(['items' => []])
<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-400 transition">Dashboard</a>
    @foreach($items as $item)
        <span class="text-gray-600">/</span>
        @if(isset($item['url']))
            <a href="{{ $item['url'] }}" class="hover:text-emerald-400 transition">{{ $item['label'] }}</a>
        @else
            <span class="text-gray-300 font-medium">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
