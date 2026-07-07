<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }} Admin</title>
    <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('favicon') ? asset('storage/' . \App\Models\Setting::get('favicon')) : asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-all duration-300 ease-in-out">
            <x-admin::sidebar />
        </div>
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>
        <div class="flex-1 flex flex-col min-w-0">
            <x-admin::topbar :title="$title ?? 'Dashboard'" />
            @if(session('success'))
                <div data-toast class="toast toast-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div data-toast class="toast toast-error">{{ session('error') }}</div>
            @endif
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
            <footer class="border-t border-white/5 px-6 py-4 text-center text-xs text-white/30">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </footer>
        </div>
    </div>
    <script>
    function confirmAction(formId, title, text, confirmText, confirmColor) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: confirmColor || '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: confirmText || 'Yes, proceed',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isOpen = !sidebar.classList.contains('-translate-x-full') || sidebar.classList.contains('translate-x-0');
        isOpen ? (sidebar.classList.add('-translate-x-full'), overlay.classList.add('hidden')) : (sidebar.classList.remove('-translate-x-full'), overlay.classList.remove('hidden'));
    }
    document.getElementById('sidebarToggle')?.addEventListener('click', toggleSidebar);
    </script>
    @stack('scripts')
</body>
</html>
