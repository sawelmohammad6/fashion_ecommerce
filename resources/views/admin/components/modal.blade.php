@props(['id', 'title' => 'Confirm Action', 'action' => null, 'method' => 'DELETE'])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeModal('{{ $id }}')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $title }}</h3>
            <p class="text-sm text-gray-500 mb-6">{{ $slot }}</p>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('{{ $id }}')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
                @if($action)
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        @method($method)
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                            Confirm
                        </button>
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