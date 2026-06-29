@extends('layouts.app')

@section('title', isset($category) ? $category->name . ' - ' . config('app.name') : 'Products - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:text-indigo-700 transition inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">
                {{ isset($category) ? $category->name : 'All Products' }}
            </h1>
        </div>
        <div class="flex items-center gap-2">
            <button class="p-2 text-gray-400 hover:text-gray-600 transition" title="Previous">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="p-2 text-gray-400 hover:text-gray-600 transition" title="Next">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('products.index') }}"
           class="px-4 py-2 rounded-lg text-sm font-medium transition
                  {{ !isset($category) ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
            All
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('products.category', $cat->slug) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition
                      {{ isset($category) && $category->id === $cat->id ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="text-5xl mb-4">📦</div>
            <p class="text-gray-500 text-lg">No products found in this category.</p>
            <a href="{{ route('products.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-700 font-medium">
                View all products
            </a>
        </div>
    @endif
</div>

<x-product-preview />
@endsection