@php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp

<nav x-data="{ open: false }" class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800 tracking-tight">
                    {{ config('app.name') }}
                </a>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('about') }}" class="text-sm text-gray-600 hover:text-gray-900 transition">About Us</a>
                    <a href="{{ route('contact') }}" class="text-sm text-gray-600 hover:text-gray-900 transition">Contact</a>
                    @auth
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm text-gray-600 hover:text-gray-900 transition">
                                    {{ Auth::user()->name }}
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('orders.index')">
                                    My Orders
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('dashboard')">
                                    Dashboard
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')">
                                    Profile
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        Log Out
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 transition">Account</a>
                    @endauth
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-gray-700 transition" title="Contact">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </button>
                <button class="text-gray-500 hover:text-gray-700 transition" title="Mail">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </button>
                <a href="{{ route('search') }}" class="text-gray-500 hover:text-gray-700 transition" title="Search">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </a>
                @auth
                    <a href="{{ route('wishlist.index') }}" class="text-gray-500 hover:text-red-500 transition relative" title="Wishlist">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </a>
                @else
                    <button class="text-gray-500 hover:text-gray-700 transition" title="Wishlist" onclick="alert('Please login to use wishlist.')">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                @endauth
                <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-gray-700 transition relative" title="Cart">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>

                <button @click="open = ! open" class="md:hidden text-gray-500 hover:text-gray-700 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-gray-100">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('about') }}" class="block text-sm text-gray-600 hover:text-gray-900 py-1">About Us</a>
            <a href="{{ route('contact') }}" class="block text-sm text-gray-600 hover:text-gray-900 py-1">Contact</a>
            <a href="{{ route('search') }}" class="block text-sm text-gray-600 hover:text-gray-900 py-1">Search</a>
            @auth
                <div class="pt-2 border-t border-gray-100">
                    <div class="font-medium text-sm text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <a href="{{ route('wishlist.index') }}" class="block text-sm text-gray-600 hover:text-gray-900 py-1">Wishlist</a>
                <a href="{{ route('orders.index') }}" class="block text-sm text-gray-600 hover:text-gray-900 py-1">My Orders</a>
                <a href="{{ route('profile.edit') }}" class="block text-sm text-gray-600 hover:text-gray-900 py-1">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block text-sm text-gray-600 hover:text-gray-900 py-1">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-sm text-gray-600 hover:text-gray-900 py-1">Account</a>
                <a href="{{ route('register') }}" class="block text-sm text-gray-600 hover:text-gray-900 py-1">Register</a>
            @endauth
        </div>
    </div>
</nav>