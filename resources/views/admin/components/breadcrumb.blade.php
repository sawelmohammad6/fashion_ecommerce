@props(['items' => []])

<nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a>
    @foreach($items as $item)
        <span>/</span>
        @if(isset($item['url']))
            <a href="{{ $item['url'] }}" class="hover:text-indigo-600 transition">{{ $item['label'] }}</a>
        @else
            <span class="text-gray-900 font-medium">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>