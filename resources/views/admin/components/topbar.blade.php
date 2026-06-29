@props(['title' => 'Dashboard'])
<header class="sticky top-0 z-30 glass px-4 sm:px-6 py-3 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <button id="sidebarToggle" class="lg:hidden text-white/50 hover:text-white transition p-1.5 rounded-lg hover:bg-white/5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div x-data="{ open: false, query: '', results: [] }" class="relative hidden sm:block">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input x-model="query" @click="open = true" @input.debounce.300ms="if(query.length > 1) { fetch('{{ route('admin.search') }}?q=' + encodeURIComponent(query)).then(r => r.json()).then(data => { results = data; open = results.length > 0; }); } else { results = []; open = false; }" @click.outside="open = false" type="text" placeholder="Search..." class="w-48 lg:w-64 input-glass pl-9">
            <div x-show="open && results.length > 0" @click.outside="open = false" class="absolute right-0 mt-2 w-72 glass rounded-xl py-2 z-50">
                <template x-for="r in results" :key="r.url">
                    <a :href="r.url" x-text="r.name" class="block px-4 py-2 text-sm text-white/70 hover:bg-white/5 hover:text-white transition"></a>
                </template>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-1">
        <a href="{{ route('home') }}" target="_blank" class="p-2 text-white/40 hover:text-emerald-400 transition rounded-lg hover:bg-white/5" title="Visit Site">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>
        <div x-data="{ open: false }" class="relative">
            <button @click="open = ! open" class="p-2 text-white/40 hover:text-amber-400 transition rounded-lg hover:bg-white/5 relative" title="Notifications">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-amber-400 rounded-full animate-pulse-glow"></span>
            </button>
            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-72 glass rounded-xl py-2 z-50">
                <p class="px-4 py-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Notifications</p>
                <p class="px-4 py-3 text-sm text-white/30 text-center">No new notifications</p>
            </div>
        </div>
        <div x-data="{ open: false }" class="relative">
            <button @click="open = ! open" class="p-2 text-white/40 hover:text-blue-400 transition rounded-lg hover:bg-white/5 relative" title="Messages">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </button>
            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-72 glass rounded-xl py-2 z-50">
                <p class="px-4 py-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Messages</p>
                <p class="px-4 py-3 text-sm text-white/30 text-center">No new messages</p>
            </div>
        </div>
        <div x-data="{ open: false }" class="relative">
            <button @click="open = ! open" class="flex items-center gap-2 text-sm text-white/70 hover:text-white transition pl-2 pr-1 py-1 rounded-xl hover:bg-white/5">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="hidden sm:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                <svg class="w-3.5 h-3.5 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-48 glass rounded-xl py-2 z-50">
                <a href="{{ route('admin.profile') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:bg-white/5 hover:text-white transition">Profile</a>
                <a href="{{ route('admin.settings.index') }}" class="block px-4 py-2.5 text-sm text-white/70 hover:bg-white/5 hover:text-white transition">Settings</a>
                <hr class="my-1 border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm text-white/70 hover:bg-white/5 hover:text-red-400 transition">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>
