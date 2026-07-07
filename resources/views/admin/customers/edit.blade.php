@extends('layouts.admin')
@section('title', 'Edit ' . $customer->name)
@section('content')

<div class="max-w-3xl mx-auto">
    <div class="glass-card p-6 sm:p-8">
        <div class="flex items-center gap-4 mb-8">
            @if($customer->photo)
                <img src="{{ asset('storage/' . $customer->photo) }}" alt=""
                     class="w-12 h-12 rounded-xl object-cover">
            @else
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-lg font-bold text-white">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h2 class="text-lg font-bold text-white">Edit Customer</h2>
                <p class="text-sm text-white/50">Update {{ $customer->name }}'s information</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Section: Basic Info --}}
            <fieldset>
                <legend class="text-xs font-semibold text-white/40 uppercase tracking-wider mb-4">Basic Information</legend>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="name" class="block text-sm font-medium text-white/60">Full Name</label>
                        <input id="name" name="name" value="{{ old('name', $customer->name) }}"
                               class="input-glass @error('name') border-red-500/50 @enderror">
                        @error('name') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label for="username" class="block text-sm font-medium text-white/60">Username</label>
                        <input id="username" name="username" value="{{ old('username', $customer->username) }}"
                               class="input-glass @error('username') border-red-500/50 @enderror">
                        @error('username') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label for="email" class="block text-sm font-medium text-white/60">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $customer->email) }}"
                               class="input-glass @error('email') border-red-500/50 @enderror">
                        @error('email') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label for="phone" class="block text-sm font-medium text-white/60">Phone</label>
                        <input id="phone" name="phone" value="{{ old('phone', $customer->phone) }}"
                               class="input-glass @error('phone') border-red-500/50 @enderror">
                        @error('phone') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </fieldset>

            <hr class="border-white/5">

            {{-- Section: Personal --}}
            <fieldset>
                <legend class="text-xs font-semibold text-white/40 uppercase tracking-wider mb-4">Personal Details</legend>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="gender" class="block text-sm font-medium text-white/60">Gender</label>
                        <select id="gender" name="gender" class="select-glass @error('gender') border-red-500/50 @enderror">
                            <option value="">— Select —</option>
                            <option value="male" {{ old('gender', $customer->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $customer->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $customer->gender) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label for="date_of_birth" class="block text-sm font-medium text-white/60">Date of Birth</label>
                        <input id="date_of_birth" name="date_of_birth" type="date"
                               value="{{ old('date_of_birth', $customer->date_of_birth?->format('Y-m-d')) }}"
                               class="input-glass @error('date_of_birth') border-red-500/50 @enderror">
                        @error('date_of_birth') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </fieldset>

            <hr class="border-white/5">

            {{-- Section: Address --}}
            <fieldset>
                <legend class="text-xs font-semibold text-white/40 uppercase tracking-wider mb-4">Address</legend>
                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label for="address" class="block text-sm font-medium text-white/60">Address</label>
                        <textarea id="address" name="address" rows="2"
                                  class="input-glass @error('address') border-red-500/50 @enderror">{{ old('address', $customer->address) }}</textarea>
                        @error('address') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="space-y-1.5">
                            <label for="city" class="block text-sm font-medium text-white/60">City</label>
                            <input id="city" name="city" value="{{ old('city', $customer->city) }}"
                                   class="input-glass @error('city') border-red-500/50 @enderror">
                            @error('city') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label for="country" class="block text-sm font-medium text-white/60">Country</label>
                            <input id="country" name="country" value="{{ old('country', $customer->country) }}"
                                   class="input-glass @error('country') border-red-500/50 @enderror">
                            @error('country') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label for="postal_code" class="block text-sm font-medium text-white/60">Postal Code</label>
                            <input id="postal_code" name="postal_code" value="{{ old('postal_code', $customer->postal_code) }}"
                                   class="input-glass @error('postal_code') border-red-500/50 @enderror">
                            @error('postal_code') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </fieldset>

            <hr class="border-white/5">

            {{-- Section: Account --}}
            <fieldset>
                <legend class="text-xs font-semibold text-white/40 uppercase tracking-wider mb-4">Account</legend>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="status" class="block text-sm font-medium text-white/60">Status</label>
                        <select id="status" name="status" class="select-glass @error('status') border-red-500/50 @enderror">
                            <option value="active" {{ old('status', $customer->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="pending" {{ old('status', $customer->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="blocked" {{ old('status', $customer->status) === 'blocked' ? 'selected' : '' }}>Blocked</option>
                        </select>
                        @error('status') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </fieldset>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.customers.show', $customer) }}"
                   class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
