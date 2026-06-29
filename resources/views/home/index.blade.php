@extends('layouts.app')

@section('title', config('app.name') . ' - Fashion & Lifestyle')
@section('meta_description', 'Discover the latest trends in fashion. Shop our collection of clothing, accessories, and more.')

@section('content')
    <x-hero :categories="$categories" :banner="$banner" />

    @if($latestProducts->count() > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 scroll-fade-in">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <span class="inline-block w-6 h-px bg-cyan-300"></span>
                        <span class="text-xs uppercase tracking-[0.2em] text-cyan-500 font-medium">Fresh</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">New Arrivals</h2>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm text-cyan-500 hover:text-cyan-600 font-medium transition inline-flex items-center gap-1">
                    View All
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($latestProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    @if($featuredProducts->count() > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 scroll-fade-in">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <span class="inline-block w-6 h-px bg-cyan-300"></span>
                        <span class="text-xs uppercase tracking-[0.2em] text-cyan-500 font-medium">Handpicked</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Featured Products</h2>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm text-cyan-500 hover:text-cyan-600 font-medium transition inline-flex items-center gap-1">
                    View All
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif
@endsection
