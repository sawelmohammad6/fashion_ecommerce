@extends('layouts.app')

@section('title', 'Search - ' . config('app.name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">Search Products</h1>

    <form method="GET" action="{{ route('search') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="lg:col-span-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name, description, fabric, color..."
                       class="w-full rounded-lg border border-gray-200 px-4 py-3 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
            <div>
                <select name="category" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="fabric" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <option value="">All Fabrics</option>
                    @foreach($fabrics as $f)
                        <option value="{{ $f }}" {{ request('fabric') === $f ? 'selected' : '' }}>{{ $f }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="color" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <option value="">All Colors</option>
                    @foreach($colors as $c)
                        <option value="{{ $c }}" {{ request('color') === $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="sort" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                </select>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 mt-4">
            <div>
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min $" class="w-24 rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
            <div>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max $" class="w-24 rounded-lg border border-gray-200 px-3 py-2 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Search</button>
            @if(request()->anyFilled(['q','category','fabric','color','min_price','max_price','sort']))
                <a href="{{ route('search') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 transition">Clear</a>
            @endif
        </div>
    </form>

    @if(request()->anyFilled(['q','category','fabric','color','min_price','max_price']))
        <p class="text-sm text-gray-500 mb-4">{{ $products->total() }} result(s) found</p>
    @endif

    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="text-5xl mb-4">🔍</div>
            <p class="text-gray-500 text-lg">No products found matching your criteria.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition text-sm">Browse All Products</a>
        </div>
    @endif
</div>
@endsection