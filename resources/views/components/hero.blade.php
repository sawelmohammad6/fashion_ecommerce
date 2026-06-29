@props(['categories' => [], 'banner' => null])

<section class="relative overflow-hidden bg-white">
    @if($banner && $banner->image)
        {{-- Banner with category buttons overlay --}}
        <div class="relative w-full" style="min-height: 75vh; max-height: 80vh;">
            <img src="{{ asset('storage/' . $banner->image) }}"
                 alt="{{ $banner->title }}"
                 class="w-full h-full absolute inset-0 object-cover select-none">

            {{-- Gradient overlay for readability --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/20 to-transparent"></div>

            {{-- Category buttons -- bottom center overlay --}}
            <div class="absolute bottom-0 left-0 right-0 pb-8 sm:pb-10 lg:pb-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-wrap justify-center gap-3 animate-in" style="animation-delay: 0.2s; animation-fill-mode: both;">
                        @if(count($categories) > 0)
                            @foreach($categories as $category)
                                <a href="{{ route('products.category', $category->slug) }}"
                                   class="px-5 py-2.5 bg-white/90 backdrop-blur-sm text-gray-800 text-sm font-medium rounded-full border border-white/30 shadow-lg hover:bg-white hover:shadow-xl hover:scale-105 transition-all duration-300">
                                    {{ $category->name }}
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
                                   class="px-5 py-2.5 bg-white/90 backdrop-blur-sm text-gray-800 text-sm font-medium rounded-full border border-white/30 shadow-lg hover:bg-white hover:shadow-xl hover:scale-105 transition-all duration-300">
                                    {{ $cat['name'] }}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Fallback: original hero design when no banner is set --}}
        <div class="max-w-7xl mx-auto">
            <div class="relative flex flex-col lg:flex-row min-h-[600px] lg:min-h-[700px]">
                <div class="lg:w-1/2 px-6 sm:px-10 lg:px-14 py-16 lg:py-24 relative z-10 flex flex-col justify-center">
                    <div class="absolute left-0 top-0 bottom-0 hidden lg:flex items-center select-none pointer-events-none">
                        <span class="text-[8rem] xl:text-[10rem] font-bold tracking-[0.25em] text-gray-900/5 leading-none" style="writing-mode: vertical-lr; text-orientation: mixed;">T-SHIRT</span>
                    </div>
                    <div class="flex items-center gap-3 mb-5 animate-in" style="animation-delay: 0.1s; animation-fill-mode: both;">
                        <span class="inline-block w-8 h-px bg-cyan-400"></span>
                        <span class="text-xs uppercase tracking-[0.25em] text-cyan-500 font-medium">Join Us</span>
                    </div>
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl xl:text-8xl font-bold text-gray-900 leading-[1.05] mb-5 animate-in" style="animation-delay: 0.2s; animation-fill-mode: both;">
                        BE<br>
                        <span class="font-serif italic font-medium text-gray-700">SMART</span>
                    </h1>
                    <p class="text-base sm:text-lg text-gray-400 max-w-md mb-8 leading-relaxed animate-in" style="animation-delay: 0.3s; animation-fill-mode: both;">
                        Discover premium fashion that speaks your style. Thoughtfully crafted for those who dare to be different.
                    </p>
                    <div class="flex items-center gap-3 mb-8 animate-in" style="animation-delay: 0.35s; animation-fill-mode: both;">
                        <div class="inline-flex items-center gap-2.5 bg-cyan-50 px-4 py-2 rounded-full border border-cyan-100 shadow-sm">
                            <svg class="w-4 h-4 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-xs sm:text-sm font-semibold text-cyan-800">Premium Quality</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 animate-in" style="animation-delay: 0.4s; animation-fill-mode: both;">
                        @if(count($categories) > 0)
                            @foreach($categories as $category)
                                <a href="{{ route('products.category', $category->slug) }}"
                                   class="group relative px-5 py-2.5 bg-white text-gray-600 text-sm font-medium rounded-full border border-gray-200 shadow-sm hover:shadow-md hover:border-cyan-300 hover:text-cyan-600 hover:scale-105 transition-all duration-300">{{ $category->name }}</a>
                            @endforeach
                        @else
                            @foreach($defaults ?? [] as $cat)
                                <a href="{{ route('products.category', $cat['slug']) }}"
                                   class="group relative px-5 py-2.5 bg-white text-gray-600 text-sm font-medium rounded-full border border-gray-200 shadow-sm hover:shadow-md hover:border-cyan-300 hover:text-cyan-600 hover:scale-105 transition-all duration-300">{{ $cat['name'] }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="lg:w-1/2 relative min-h-[400px] lg:min-h-[700px] bg-gradient-to-br from-cyan-50 via-white to-gray-50 flex items-center justify-center overflow-hidden">
                    <svg class="absolute inset-0 w-full h-full" viewBox="0 0 600 750" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
                        <path d="M80 250 C 180 80, 420 80, 520 250 C 600 390, 480 540, 350 650" stroke="#06b6d4" stroke-width="1.5" stroke-linecap="round" fill="none" opacity="0.25"/>
                        <path d="M40 350 C 160 160, 440 160, 560 350 C 640 510, 510 660, 380 720" stroke="#06b6d4" stroke-width="1" stroke-linecap="round" fill="none" opacity="0.15"/>
                        <circle cx="300" cy="380" r="200" stroke="#06b6d4" stroke-width="0.8" fill="none" opacity="0.12"/>
                        <circle cx="300" cy="380" r="140" stroke="#06b6d4" stroke-width="0.8" fill="none" opacity="0.18"/>
                        <circle cx="300" cy="380" r="70" stroke="#06b6d4" stroke-width="0.6" fill="none" opacity="0.1"/>
                    </svg>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[14rem] sm:text-[18rem] font-bold text-cyan-200/20 select-none pointer-events-none tracking-tight">F</div>
                    <div class="relative z-10 text-center space-y-6 animate-in" style="animation-delay: 0.2s; animation-fill-mode: both;">
                        <div class="bg-white/90 backdrop-blur-sm rounded-2xl px-10 py-6 shadow-lg border border-gray-100/80 inline-block">
                            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 mb-1.5">Collection</p>
                            <p class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">2026</p>
                        </div>
                        <div class="pt-1">
                            <span class="inline-flex items-center gap-2 bg-cyan-400 rounded-full px-6 py-2.5 text-sm font-bold text-white uppercase tracking-wider shadow-md shadow-cyan-200/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                                New Arrivals
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
