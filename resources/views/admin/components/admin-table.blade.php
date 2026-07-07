@props(['headers' => [], 'actions' => true, 'empty' => 'No records found.'])
<div class="bg-gray-900/50 border border-gray-800 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-800">
                    @foreach($headers as $header)
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $header }}</th>
                    @endforeach
                    @if($actions)
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50">
                @if(trim($slot) !== '')
                    {{ $slot }}
                @else
                    <tr>
                        <td colspan="{{ count($headers) + ($actions ? 1 : 0) }}" class="px-4 py-10 text-center text-gray-500">{{ $empty }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
