<div id="productPreview" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20 backdrop-blur-sm transition-all duration-300"
     onmouseleave="closePreview()">
    <div id="previewCard" class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 overflow-hidden transform scale-95 transition-all duration-300">
        <div class="relative">
            <div id="previewImage" class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-7xl">
            </div>
            <button onclick="closePreview()" class="absolute top-3 right-3 bg-white/90 rounded-full p-2 shadow hover:bg-white transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-6 space-y-3">
            <h3 id="previewName" class="text-xl font-bold text-gray-900"></h3>
            <div id="previewDetails" class="grid grid-cols-2 gap-3 text-sm">
                <div><span class="text-gray-400">Fabric:</span> <span id="previewFabric" class="text-gray-700 font-medium"></span></div>
                <div><span class="text-gray-400">Color:</span> <span id="previewColor" class="text-gray-700 font-medium"></span></div>
                <div><span class="text-gray-400">Print:</span> <span id="previewPrint" class="text-gray-700 font-medium"></span></div>
                <div><span class="text-gray-400">Size:</span> <span id="previewSize" class="text-gray-700 font-medium"></span></div>
            </div>
            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                <span id="previewPrice" class="text-2xl font-bold text-indigo-600"></span>
                <button class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                    Order Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let previewTimeout = null;

function showPreview(el) {
    clearTimeout(previewTimeout);
    const preview = document.getElementById('productPreview');
    const card = document.getElementById('previewCard');

    document.getElementById('previewName').textContent = el.dataset.name;
    document.getElementById('previewFabric').textContent = el.dataset.fabric || '-';
    document.getElementById('previewColor').textContent = el.dataset.color || '-';
    document.getElementById('previewPrint').textContent = el.dataset.print || '-';
    document.getElementById('previewSize').textContent = el.dataset.size || '-';
    document.getElementById('previewPrice').textContent = '$' + el.dataset.price;

    const imgDiv = document.getElementById('previewImage');
    const emojiMap = {
        'mens-t-shirt': '👕',
        'womens-t-shirt': '👚',
        'bags': '👜',
    };
    const catSlug = el.dataset.categorySlug || '';
    imgDiv.textContent = emojiMap[catSlug] || '✨';

    preview.classList.remove('hidden');
    preview.classList.add('flex');
    requestAnimationFrame(() => {
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
    });
}

function hidePreview(el) {
    previewTimeout = setTimeout(() => {
        closePreview();
    }, 200);
}

function closePreview() {
    const preview = document.getElementById('productPreview');
    const card = document.getElementById('previewCard');
    card.classList.remove('scale-100');
    card.classList.add('scale-95');
    setTimeout(() => {
        preview.classList.add('hidden');
        preview.classList.remove('flex');
    }, 200);
}
</script>