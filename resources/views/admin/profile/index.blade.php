@extends('layouts.admin')
@section('title', 'Profile')
@section('content')
<x-admin::breadcrumb :items="[['label' => 'Profile']]" />

<div class="max-w-4xl mx-auto space-y-6">
    {{-- Section 1: Profile Header Card --}}
    @php $user = auth()->user(); @endphp
    <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <div class="relative shrink-0">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" class="w-20 h-20 rounded-xl object-cover border-2 border-emerald-500/20">
                @else
                    <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-2xl font-bold text-white shadow-lg shadow-emerald-500/20">{{ substr($user->name, 0, 1) }}</div>
                @endif
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-gray-950 rounded-full"></div>
            </div>
            <div class="flex-1 text-center sm:text-left">
                <h1 class="text-xl font-bold text-white">{{ $user->name }}</h1>
                <p class="text-sm text-emerald-400 font-medium">Administrator</p>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-5 gap-y-1 mt-3 text-sm text-gray-400">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ $user->email }}
                    </span>
                    @if($user->phone)
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $user->phone }}
                    </span>
                    @endif
                </div>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-5 gap-y-1 mt-2 text-xs text-gray-500">
                    <span>Member since {{ $user->created_at->format('M Y') }}</span>
                    @if($user->last_login_at)
                    <span>Last login {{ $user->last_login_at->diffForHumans() }}</span>
                    @endif
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                        Online
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Section 2: Personal Information --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                <h2 class="text-base font-semibold text-white mb-5">Personal Information</h2>
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Full Name <span class="text-red-400">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500/50 @enderror">
                            @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 @error('username') border-red-500/50 @enderror">
                            @error('username')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Email <span class="text-red-400">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-500/50 @enderror">
                            @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-400 mb-1">Address</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">City</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Country</label>
                            <input type="text" name="country" value="{{ old('country', $user->country) }}" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Postal Code</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-400 mb-1">Bio</label>
                        <textarea name="bio" rows="3" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">Save Changes</button>
                    </div>
                </form>
            </div>

            {{-- Section 4: Change Password --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                <h2 class="text-base font-semibold text-white mb-5">Change Password</h2>
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Current Password <span class="text-red-400">*</span></label>
                            <input type="password" name="current_password" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 @error('current_password') border-red-500/50 @enderror">
                            @error('current_password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">New Password <span class="text-red-400">*</span></label>
                            <input type="password" name="password" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-500/50 @enderror">
                            @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Confirm Password <span class="text-red-400">*</span></label>
                            <input type="password" name="password_confirmation" class="w-full bg-gray-800 border border-gray-700 text-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">Update Password</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            {{-- Section 3: Profile Picture --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                <h2 class="text-base font-semibold text-white mb-5">Profile Picture</h2>
                <div class="flex flex-col items-center">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" class="w-28 h-28 rounded-xl object-cover border-2 border-gray-700">
                    @else
                        <div class="w-28 h-28 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-3xl font-bold text-white shadow-lg shadow-emerald-500/20">{{ substr($user->name, 0, 1) }}</div>
                    @endif
                    <form action="{{ route('admin.profile.avatar') }}" method="POST" enctype="multipart/form-data" class="w-full mt-4">
                        @csrf
                        <label class="block text-sm font-medium text-gray-400 mb-2">Upload Image</label>
                        <input type="file" name="avatar" accept="image/jpg,image/jpeg,image/png,image/webp" class="w-full text-sm text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-emerald-500/10 file:text-emerald-400 hover:file:bg-emerald-500/20 transition">
                        @error('avatar')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        <p class="text-xs text-gray-500 mt-1.5">JPG, JPEG, PNG or WEBP. Max 2MB.</p>
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium px-4 py-2 rounded-lg transition mt-3">Upload</button>
                    </form>
                    @if($user->photo)
                    <form action="{{ route('admin.profile.avatar.remove') }}" method="POST" class="w-full mt-2" onsubmit="return confirm('Remove profile picture?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 text-sm font-medium px-4 py-2 rounded-lg transition">Remove</button>
                    </form>
                    @endif
                </div>
            </div>

            {{-- Section 5: Account Information --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                <h2 class="text-base font-semibold text-white mb-5">Account Information</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">User ID</dt>
                        <dd class="text-gray-300 font-mono">#{{ $user->id }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Role</dt>
                        <dd><span class="bg-emerald-500/10 text-emerald-400 text-xs font-medium px-2.5 py-1 rounded-full">Admin</span></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Email Verified</dt>
                        <dd>
                            @if($user->email_verified_at)
                                <span class="text-emerald-400 text-xs font-medium">Verified</span>
                            @else
                                <span class="text-amber-400 text-xs font-medium">Unverified</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Created</dt>
                        <dd class="text-gray-300">{{ $user->created_at->format('M d, Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Updated</dt>
                        <dd class="text-gray-300">{{ $user->updated_at->format('M d, Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Last Login</dt>
                        <dd class="text-gray-300">{{ $user->last_login_at?->format('M d, Y h:i A') ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Section 6: Recent Activity --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-xl p-6">
                <h2 class="text-base font-semibold text-white mb-5">Recent Activity</h2>
                <div class="space-y-3 text-sm">
                    @if($user->updated_at && $user->updated_at->gt($user->created_at))
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-gray-300">Profile updated</p>
                            <p class="text-xs text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endif
                    @if($user->last_login_at)
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-gray-300">Last login</p>
                            <p class="text-xs text-gray-500">{{ $user->last_login_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-purple-500 mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-gray-300">Account created</p>
                            <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
