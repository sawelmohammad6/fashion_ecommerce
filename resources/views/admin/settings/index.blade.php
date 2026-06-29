@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<x-admin::breadcrumb :items="[['label' => 'Settings']]" />

<div class="max-w-2xl">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Store Settings</h2>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Website Name</label>
            <input type="text" name="website_name" value="{{ old('website_name', \App\Models\Setting::get('website_name', config('app.name'))) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="website_email" value="{{ old('website_email', \App\Models\Setting::get('website_email')) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="website_phone" value="{{ old('website_phone', \App\Models\Setting::get('website_phone')) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <textarea name="website_address" rows="2" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">{{ old('website_address', \App\Models\Setting::get('website_address')) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Footer Text</label>
            <input type="text" name="footer_text" value="{{ old('footer_text', \App\Models\Setting::get('footer_text')) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
        </div>

        <div class="border-t border-gray-100 pt-4">
            <h3 class="font-medium text-gray-900 mb-3">Social Links</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                    <input type="url" name="facebook_url" value="{{ old('facebook_url', \App\Models\Setting::get('facebook_url')) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Twitter URL</label>
                    <input type="url" name="twitter_url" value="{{ old('twitter_url', \App\Models\Setting::get('twitter_url')) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                    <input type="url" name="instagram_url" value="{{ old('instagram_url', \App\Models\Setting::get('instagram_url')) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                @if(\App\Models\Setting::get('logo'))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . \App\Models\Setting::get('logo')) }}" alt="Logo" class="h-12">
                    </div>
                @endif
                <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
                @if(\App\Models\Setting::get('favicon'))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . \App\Models\Setting::get('favicon')) }}" alt="Favicon" class="h-8">
                    </div>
                @endif
                <input type="file" name="favicon" accept="image/*,.ico" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">Save Settings</button>
        </div>
    </form>
</div>
@endsection