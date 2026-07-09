@extends('layouts.admin')
@section('title', 'Settings')
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Settings']]" />
<div class="max-w-3xl">
    <h2 class="text-xl font-bold text-white mb-6">Store Settings</h2>
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="glass-card p-6 space-y-5">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-white/60 mb-1">Website Name</label>
                <input type="text" name="website_name" value="{{ old('website_name', $settings['website_name'] ?? config('app.name')) }}" class="input-glass"></div>
            <div><label class="block text-sm font-medium text-white/60 mb-1">Website Email</label>
                <input type="email" name="website_email" value="{{ old('website_email', $settings['website_email'] ?? '') }}" class="input-glass"></div>
        </div>
        <div><label class="block text-sm font-medium text-white/60 mb-1">Footer Text</label>
            <textarea name="footer_text" rows="2" class="input-glass">{{ old('footer_text', $settings['footer_text'] ?? '') }}</textarea></div>
        <div><label class="block text-sm font-medium text-white/60 mb-1">Address</label>
            <textarea name="address" rows="2" class="input-glass">{{ old('address', $settings['address'] ?? '') }}</textarea></div>
        <div><label class="block text-sm font-medium text-white/60 mb-1">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" class="input-glass"></div>
        <div><label class="block text-sm font-medium text-white/60 mb-1">Homepage Hero Title</label>
            <input type="text" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}" class="input-glass"></div>
        <div><label class="block text-sm font-medium text-white/60 mb-1">Homepage Hero Subtitle</label>
            <textarea name="hero_subtitle" rows="2" class="input-glass">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-white/60 mb-1">Facebook URL</label>
                <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" class="input-glass"></div>
            <div><label class="block text-sm font-medium text-white/60 mb-1">Twitter URL</label>
                <input type="url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" class="input-glass"></div>
            <div><label class="block text-sm font-medium text-white/60 mb-1">Instagram URL</label>
                <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" class="input-glass"></div>
            <div><label class="block text-sm font-medium text-white/60 mb-1">YouTube URL</label>
                <input type="url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" class="input-glass"></div>
        </div>
        <div><label class="block text-sm font-medium text-white/60 mb-1">Website Logo</label>
            @if(!empty($settings['logo']))<div class="mb-2"><img src="{{ asset('storage/' . $settings['logo']) }}" class="h-12 rounded-lg"></div>@endif
            <input type="file" name="logo" accept="image/*" class="w-full text-sm text-white/50 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-emerald-500/10 file:text-emerald-400"></div>
        <div><label class="block text-sm font-medium text-white/60 mb-1">Favicon</label>
            @if(!empty($settings['favicon']))<div class="mb-2"><img src="{{ asset('storage/' . $settings['favicon']) }}" class="h-10 rounded-lg"></div>@endif
            <input type="file" name="favicon" accept="image/*" class="w-full text-sm text-white/50 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-emerald-500/10 file:text-emerald-400"></div>
        <div class="flex items-center gap-3 pt-2"><button type="submit" class="btn-primary">Save Settings</button></div>
    </form>
</div>
@endsection
