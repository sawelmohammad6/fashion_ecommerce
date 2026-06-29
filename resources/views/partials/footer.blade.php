<footer class="bg-white border-t border-gray-200 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <h3 class="font-bold text-gray-900 mb-4">{{ config('app.name') }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Your destination for quality fashion. Discover the latest trends and express your unique style.</p>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600 transition">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-500 hover:text-indigo-600 transition">Products</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-500 hover:text-indigo-600 transition">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-500 hover:text-indigo-600 transition">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Customer Service</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-indigo-600 transition">Cart</a></li>
                    @auth
                        <li><a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-indigo-600 transition">My Orders</a></li>
                        <li><a href="{{ route('wishlist.index') }}" class="text-gray-500 hover:text-indigo-600 transition">Wishlist</a></li>
                    @endauth
                    <li><a href="{{ route('search') }}" class="text-gray-500 hover:text-indigo-600 transition">Search</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Contact</h3>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li>{{ \App\Models\Setting::get('website_phone', '+1 (555) 123-4567') }}</li>
                    <li>{{ \App\Models\Setting::get('website_email', 'hello@fashion.test') }}</li>
                    <li>{{ \App\Models\Setting::get('website_address', '123 Fashion Street') }}</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-100 mt-8 pt-6 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</footer>