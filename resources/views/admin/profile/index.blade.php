@extends('admin.layouts.app')
@section('title', 'Profile')
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Profile']]" />
<div class="max-w-3xl">
    <h2 class="text-xl font-bold text-white mb-6">Profile Settings</h2>
    <div class="grid grid-cols-1 gap-6">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="glass-card p-6 space-y-5">
            @csrf
            <div class="flex items-center gap-4 mb-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-xl font-bold text-white">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div><p class="text-white font-medium">{{ auth()->user()->name }}</p><p class="text-sm text-white/40">{{ auth()->user()->email }}</p></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-white/60 mb-1">Name</label><input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="input-glass @error('name') border-red-500/50 @enderror">@error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-white/60 mb-1">Email</label><input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="input-glass @error('email') border-red-500/50 @enderror">@error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror</div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-white/60 mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="input-glass"></div>
                <div><label class="block text-sm font-medium text-white/60 mb-1">Photo</label><input type="file" name="photo" accept="image/*" class="w-full text-sm text-white/50 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-emerald-500/10 file:text-emerald-400"></div>
            </div>
            <div class="flex items-center gap-3 pt-2"><button type="submit" class="btn-primary">Update Profile</button></div>
        </form>
        <form action="{{ route('admin.profile.password') }}" method="POST" class="glass-card p-6 space-y-5">
            @csrf
            <h3 class="text-white font-medium">Change Password</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-white/60 mb-1">Current Password</label><input type="password" name="current_password" class="input-glass @error('current_password') border-red-500/50 @enderror">@error('current_password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-white/60 mb-1">New Password</label><input type="password" name="password" class="input-glass @error('password') border-red-500/50 @enderror">@error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-white/60 mb-1">Confirm Password</label><input type="password" name="password_confirmation" class="input-glass"></div>
            </div>
            <div class="flex items-center gap-3 pt-2"><button type="submit" class="btn-primary">Change Password</button></div>
        </form>
    </div>
</div>
@endsection
