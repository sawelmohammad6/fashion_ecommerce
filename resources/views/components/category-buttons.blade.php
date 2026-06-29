@props(['categories' => []])

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 scroll-fade-in">
    <div class="text-center mb-10">
        <div class="flex items-center justify-center gap-3 mb-3">
            <span class="inline-block w-6 h-px bg-cyan-300"></span>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Shop by Category</h2>
            <span class="inline-block w-6 h-px bg-cyan-300"></span>
        </div>
        <p class="text-gray-400 text-sm sm:text-base">Explore our curated collections</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        @if(count($categories) > 0)
            @foreach($categories as $category)
                <a href="{{ route('products.category', $category->slug) }}"
                   class="group relative bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-cyan-200 hover:scale-[1.03] transition-all duration-300 overflow-hidden">
                    <div class="aspect-[4/3] flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 p-6">
                        <div class="text-5xl sm:text-6xl group-hover:scale-110 transition-transform duration-500">
                            @switch($category->slug)
                                @case('mens-t-shirt') 👕 @break
                                @case('womens-t-shirt') 👚 @break
                                @case('bags') 👜 @break
                                @default ✨
                            @endswitch
                        </div>
                    </div>
                    <div class="p-3 sm:p-4 text-center">
                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base">{{ $category->name }}</h3>
                    </div>
                </a>
            @endforeach
        @else
            @php
                $defaults = [
                    ['name' => "Men's T-Shirt", 'slug' => 'mens-t-shirt'],
                    ['name' => "Women's T-Shirt", 'slug' => 'womens-t-shirt'],
                    ['name' => 'Bags', 'slug' => 'bags'],
                    ['name' => 'Others', 'slug' => 'others'],
                ];
            @endphp
            @foreach($defaults as $cat)
                <a href="{{ route('products.category', $cat['slug']) }}"
                   class="group relative bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-cyan-200 hover:scale-[1.03] transition-all duration-300 overflow-hidden">
                    <div class="aspect-[4/3] flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 p-6">
                        <div class="text-5xl sm:text-6xl group-hover:scale-110 transition-transform duration-500">
                            @switch($cat['slug'])
                                @case('mens-t-shirt') 👕 @break
                                @case('womens-t-shirt') 👚 @break
                                @case('bags') 👜 @break
                                @default ✨
                            @endswitch
                        </div>
                    </div>
                    <div class="p-3 sm:p-4 text-center">
                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base">{{ $cat['name'] }}</h3>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
</section>
