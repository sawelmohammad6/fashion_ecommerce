@extends('layouts.app')

@section('title', 'Forbidden - ' . config('app.name'))

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
    <div class="text-8xl font-bold text-red-500 mb-4">403</div>
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">Access Denied</h1>
    <p class="text-gray-500 mb-8 max-w-md mx-auto">You do not have permission to access this page.</p>
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('home') }}" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition text-sm">Go Home</a>
        <a href="{{ route('login') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition text-sm">Login</a>
    </div>
</div>
@endsection