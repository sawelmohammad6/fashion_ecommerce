<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('favicon') ? asset('storage/' . \App\Models\Setting::get('favicon')) : asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">
        <div id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-200 ease-in-out">
            <x-admin::sidebar />
        </div>

        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <div class="flex-1 flex flex-col min-w-0">
            <x-admin::topbar :title="isset($title) ? $title : 'Dashboard'" />

            @if(session('success'))
                <div class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-4 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <footer class="border-t border-gray-200 px-6 py-4 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </footer>
        </div>
    </div>

    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isOpen = !sidebar.classList.contains('-translate-x-full') || sidebar.classList.contains('translate-x-0');
        if (isOpen) {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        } else {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }
    }

    document.getElementById('sidebarToggle')?.addEventListener('click', toggleSidebar);

    document.addEventListener('click', function(e) {
        if (e.target.closest('[data-toggle-dropdown]')) {
            const dropdown = e.target.closest('[data-toggle-dropdown]').nextElementSibling;
            if (dropdown) dropdown.classList.toggle('hidden');
        }
    });
    </script>

    @stack('scripts')
</body>
</html>