<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PetAdopt') }} — Pet Adoption Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, ::before, ::after { font-family: 'Inter', system-ui, sans-serif; }
        body { background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 30%, #f0f9ff 70%, #f5f3ff 100%); }
    </style>
</head>
<body class="antialiased" x-data="{ sidebarOpen: false }">
<div class="min-h-screen flex">

    {{-- ─── SIDEBAR ─────────────────────────────────────────────── --}}
    {{-- Overlay --}}
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen=false"
         class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm md:hidden"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-64 flex flex-col bg-white/80 backdrop-blur-xl border-r-2 border-violet-100 shadow-xl shadow-violet-100/20 transition-transform duration-300 md:translate-x-0 md:shadow-none">

        {{-- Profile --}}
        <div class="px-5 pt-6 pb-4 border-b-2 border-violet-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center text-black font-bold text-sm shadow-lg shadow-violet-200 border border-violet-600">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-violet-500 font-medium capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
               class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : 'text-gray-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                Dashboard
            </a>
            <a href="{{ route('pets.index') }}"
               class="sidebar-link {{ request()->routeIs('pets.*') ? 'active' : 'text-gray-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-4.35-6-10A6 6 0 0118 11c0 5.65-6 10-6 10z"/><circle cx="12" cy="11" r="2"/></svg>
                Pet Management
            </a>
            <a href="{{ auth()->user()->isAdmin() ? route('applications.index') : route('applications.my-applications') }}"
               class="sidebar-link {{ request()->routeIs('applications.*') ? 'active' : 'text-gray-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                {{ auth()->user()->isAdmin() ? 'Manage Applications' : 'My Applications' }}
            </a>
            <a href="{{ route('profile.edit') }}"
               class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : 'text-gray-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                Settings
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('categories.index') }}"
               class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : 'text-gray-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                Categories
            </a>
            @endif
        </nav>

        {{-- Logout --}}
        <div class="px-3 pb-5 border-t-2 border-violet-100 pt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link text-gray-400 hover:text-red-500 hover:bg-red-50 w-full cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"/></svg>
                    Log out
                </button>
            </form>
        </div>
    </aside>

    {{-- ─── MAIN ────────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-h-screen md:ml-64">

        {{-- Mobile top bar --}}
        <div class="sticky top-0 z-30 flex items-center gap-3 px-4 py-3 bg-white/60 backdrop-blur-lg border-b-2 border-violet-100 md:hidden">
            <button @click="sidebarOpen=true" class="p-2 rounded-xl hover:bg-violet-50 text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <span class="text-sm font-semibold text-gray-700">🐾 PetAdopt</span>
        </div>

        {{-- Content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            {{-- Flash --}}
            @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-emerald-50 border-2 border-emerald-200 text-emerald-700 px-5 py-3.5 rounded-2xl shadow-sm animate-pulse-once">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
