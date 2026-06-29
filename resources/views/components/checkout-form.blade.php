@props(['old' => []])

<form action="{{ route('checkout.store') }}" method="POST" id="checkout-form" class="space-y-6">
    @csrf

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
        <h3 class="font-bold text-lg text-gray-900">Shipping Information</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                       class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('customer_name') border-red-300 @enderror"
                       placeholder="John Doe">
                @error('customer_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('phone') border-red-300 @enderror"
                       placeholder="01XXXXXXXXX">
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                   class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('email') border-red-300 @enderror"
                   placeholder="john@example.com">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Division <span class="text-red-500">*</span></label>
                <input type="text" name="division" value="{{ old('division') }}"
                       class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('division') border-red-300 @enderror"
                       placeholder="Dhaka">
                @error('division') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">District <span class="text-red-500">*</span></label>
                <input type="text" name="district" value="{{ old('district') }}"
                       class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('district') border-red-300 @enderror"
                       placeholder="Dhaka">
                @error('district') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upazila / Thana</label>
                <input type="text" name="upazila" value="{{ old('upazila') }}"
                       class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                       placeholder="Mirpur">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                       class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                       placeholder="1216">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
            <textarea name="address" rows="3"
                      class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none @error('address') border-red-300 @enderror"
                      placeholder="House #, Road #, Area">{{ old('address') }}</textarea>
            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        <h3 class="font-bold text-lg text-gray-900">Payment Method <span class="text-red-500">*</span></h3>

        @error('payment_method') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror

        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-indigo-300 transition cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
            <input type="radio" name="payment_method" value="cash_on_delivery" class="accent-indigo-600" checked>
            <span class="text-sm font-medium text-gray-700">Cash on Delivery</span>
        </label>

        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-indigo-300 transition cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 opacity-60">
            <input type="radio" name="payment_method" value="sslcommerz" class="accent-indigo-600" disabled>
            <span class="text-sm font-medium text-gray-700">SSLCOMMERZ <span class="text-xs text-gray-400">(Coming Soon)</span></span>
        </label>

        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-indigo-300 transition cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 opacity-60">
            <input type="radio" name="payment_method" value="card" class="accent-indigo-600" disabled>
            <span class="text-sm font-medium text-gray-700">Card Payment <span class="text-xs text-gray-400">(Coming Soon)</span></span>
        </label>

        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:border-indigo-300 transition cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50 opacity-60">
            <input type="radio" name="payment_method" value="mobile_banking" class="accent-indigo-600" disabled>
            <span class="text-sm font-medium text-gray-700">Mobile Banking <span class="text-xs text-gray-400">(Coming Soon)</span></span>
        </label>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
        <textarea name="notes" rows="2" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Any special instructions...">{{ old('notes') }}</textarea>
    </div>
</form>