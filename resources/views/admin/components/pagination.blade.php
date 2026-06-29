@props(['paginator'])
@if ($paginator->hasPages())
    <div class="mt-6">{{ $paginator->onEachSide(2)->links() }}</div>
@endif
