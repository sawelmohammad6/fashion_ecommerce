@props(['headers' => [], 'actions' => true, 'empty' => 'No records found.'])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    @foreach($headers as $header)
                        <th class="text-left px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">{{ $header }}</th>
                    @endforeach
                    @if($actions)
                        <th class="text-right px-4 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @if(trim($slot) !== '')
                    {{ $slot }}
                @else
                    <tr>
                        <td colspan="{{ count($headers) + ($actions ? 1 : 0) }}" class="px-4 py-8 text-center text-gray-400">
                            {{ $empty }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>