@props(['headers' => [], 'actions' => true, 'empty' => 'No records found.'])
<div class="glass-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table-glass">
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                    @if($actions)
                        <th class="text-right">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @if(trim($slot) !== '')
                    {{ $slot }}
                @else
                    <tr>
                        <td colspan="{{ count($headers) + ($actions ? 1 : 0) }}" class="px-4 py-10 text-center text-white/30">{{ $empty }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
