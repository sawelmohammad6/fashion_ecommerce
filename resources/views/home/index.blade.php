@extends('layouts.app')

@section('title', config('app.name') . ' - Fashion & Lifestyle')
@section('meta_description', 'Discover the latest trends in fashion. Shop our collection of clothing, accessories, and more.')

@section('content')
    <x-hero />

    <x-category-buttons :categories="$categories" />

    @if(isset($featuredProducts) && $featuredProducts->count() > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 scroll-fade-in">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Featured Products</h2>
                    <p class="text-gray-500 mt-1">Handpicked just for you</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium transition">View All &rarr;</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif
@endsection
