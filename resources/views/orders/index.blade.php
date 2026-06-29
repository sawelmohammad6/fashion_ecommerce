@extends('layouts.app')

@section('title', 'My Orders - ' . config('app.name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:text-indigo-700 transition inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Home
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">My Orders</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm mb-6">{{ session('success') }}</div>
    @endif

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <x-order-card :order="$order" />
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="text-5xl mb-4">📋</div>
            <p class="text-gray-500 text-lg mb-4">You haven't placed any orders yet.</p>
            <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition text-sm">Start Shopping</a>
        </div>
    @endif
</div>
@endsection