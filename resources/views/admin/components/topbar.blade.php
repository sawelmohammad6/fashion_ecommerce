@props(['title' => 'Dashboard'])

<header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <button id="sidebarToggle" class="lg:hidden text-gray-500 hover:text-gray-700 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h1 class="text-xl font-bold text-gray-900">{{ $title }}</h1>
    </div>

    <div class="flex items-center gap-4">
        <a href="{{ route('home') }}" target="_blank" class="text-sm text-gray-500 hover:text-indigo-600 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            Visit Site
        </a>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = ! open" class="flex items-center gap-2 text-sm text-gray-700 hover:text-gray-900 transition">
                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-medium">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
            </button>

            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>
                <hr class="my-1 border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>