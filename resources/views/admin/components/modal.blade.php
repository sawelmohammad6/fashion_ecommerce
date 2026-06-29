@props(['id', 'title' => 'Confirm Action', 'action' => null, 'method' => 'DELETE'])
<div id="{{ $id }}" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeModal('{{ $id }}')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="glass-card max-w-md w-full p-6 animate-in">
            <h3 class="text-lg font-bold text-white mb-2">{{ $title }}</h3>
            <p class="text-sm text-white/50 mb-6">{{ $slot }}</p>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('{{ $id }}')" class="btn-secondary text-sm">Cancel</button>
                @if($action)
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        @method($method)
                        <button type="submit" class="btn-danger text-sm">Confirm</button>
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
