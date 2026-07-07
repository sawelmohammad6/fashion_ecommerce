@props(['id', 'title' => 'Confirm Action', 'action' => null, 'method' => 'DELETE'])
<div id="{{ $id }}" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeModal('{{ $id }}')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-800 rounded-xl max-w-md w-full p-6 animate-in">
            <h3 class="text-lg font-bold text-white mb-2">{{ $title }}</h3>
            <p class="text-sm text-gray-400 mb-6">{{ $slot }}</p>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('{{ $id }}')" class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition">Cancel</button>
                @if($action)
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        @method($method)
                        <button type="submit" class="px-4 py-2 text-sm font-medium rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition">Confirm</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>
