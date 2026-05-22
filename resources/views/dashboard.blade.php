<x-app-layout>
    @if(auth()->user()->isAdmin())
        {{-- ADMIN DASHBOARD --}}
        
        {{-- Greeting --}}
        <div class="mb-8">
            <p class="text-sm text-violet-600 font-semibold">{{ now()->format('l, F j') }}</p>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mt-1">Hello, {{ Auth::user()->name }}</h1>
            <p class="text-gray-400 mt-1 text-base">Manage your shelter pets today</p>
        </div>

        {{-- Quick Actions --}}
        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('pets.create') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-black text-sm font-semibold px-5 py-2.5 rounded-2xl border border-violet-700 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add New Pet
            </a>
            <a href="{{ route('applications.index') }}"
               class="inline-flex items-center gap-2 bg-white text-cyan-600 text-sm font-semibold px-5 py-2.5 rounded-2xl border-2 border-cyan-100 shadow-sm hover:shadow-md hover:bg-cyan-50 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                View Applications
            </a>
            <a href="{{ route('pets.index') }}"
               class="inline-flex items-center gap-2 bg-white text-gray-600 text-sm font-semibold px-5 py-2.5 rounded-2xl border-2 border-violet-100 shadow-sm hover:shadow-md hover:border-violet-200 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                View All Pets
            </a>
            <a href="{{ route('categories.index') }}"
               class="inline-flex items-center gap-2 bg-white text-gray-600 text-sm font-semibold px-5 py-2.5 rounded-2xl border-2 border-violet-100 shadow-sm hover:shadow-md hover:border-violet-200 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                Manage Categories
            </a>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
            {{-- Total Pets --}}
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 border-2 border-violet-100 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center shadow-lg border border-violet-750">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-gray-800">{{ $totalPets }}</p>
                <p class="text-sm text-gray-400 mt-1">Total Pets</p>
            </div>

            {{-- Available --}}
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 border-2 border-emerald-100 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-500 flex items-center justify-center shadow-lg border border-emerald-600">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-gray-800">{{ $available }}</p>
                <p class="text-sm text-gray-400 mt-1">Available</p>
            </div>

            {{-- Adopted --}}
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 border-2 border-cyan-100 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-cyan-400 to-cyan-500 flex items-center justify-center shadow-lg border border-cyan-600">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-gray-800">{{ $adopted }}</p>
                <p class="text-sm text-gray-400 mt-1">Adopted</p>
            </div>

            {{-- Archived --}}
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 border-2 border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center shadow-lg border border-gray-600">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-gray-800">{{ $archived }}</p>
                <p class="text-sm text-gray-400 mt-1">Archived</p>
            </div>
        </div>

        {{-- Recent Pets --}}
        <div class="bg-white/70 backdrop-blur-sm rounded-3xl border-2 border-violet-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b-2 border-violet-100 flex items-center justify-between bg-violet-50/20">
                <h2 class="text-lg font-bold text-gray-800">Recent Pets</h2>
                <a href="{{ route('pets.index') }}" class="text-sm font-semibold text-violet-500 hover:text-violet-700 transition">View all →</a>
            </div>
            @if($recentPets->isEmpty())
                <div class="px-6 py-16 text-center text-gray-400">
                    <p class="font-medium">No pets yet. Add your first pet!</p>
                </div>
            @else
                <div class="divide-y-2 divide-violet-100 p-2">
                    @foreach($recentPets as $pet)
                    <a href="{{ route('pets.show', $pet) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-violet-50 transition-colors border-2 border-transparent hover:border-violet-200 rounded-2xl m-1">
                        @if($pet->image)
                            <img src="{{ Storage::url($pet->image) }}" alt="{{ $pet->name }}" class="w-11 h-11 rounded-2xl object-cover ring-2 ring-violet-200"/>
                        @else
                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-violet-100 to-fuchsia-100 flex items-center justify-center text-lg border border-violet-200"></div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $pet->name }}</p>
                            <p class="text-xs text-gray-400">{{ $pet->breed }} · {{ $pet->category->category_name ?? 'Uncategorized' }}</p>
                        </div>
                        @php
                            $c = match($pet->status) {
                                'Available' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                'Adopted'   => 'bg-cyan-50 text-cyan-700 border border-cyan-200',
                                'Archived'  => 'bg-gray-50 text-gray-500 border border-gray-250',
                                default     => 'bg-gray-50 text-gray-500 border border-gray-250',
                            };
                        @endphp
                        <span class="shrink-0 text-xs font-semibold px-2.5 py-1 rounded-full {{ $c }}">{{ $pet->status }}</span>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>

    @else
        {{-- ADOPTER DASHBOARD --}}
        
        {{-- Greeting --}}
        <div class="mb-8">
            <p class="text-sm text-violet-600 font-semibold">{{ now()->format('l, F j') }}</p>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mt-1">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-400 mt-1 text-base">Find your perfect companion to adopt</p>
        </div>

        {{-- Quick Actions --}}
        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('pets.index') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-black text-sm font-semibold px-5 py-2.5 rounded-2xl border border-violet-700 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Browse Pets
            </a>
            <a href="{{ route('applications.my-applications') }}"
               class="inline-flex items-center gap-2 bg-white text-cyan-600 text-sm font-semibold px-5 py-2.5 rounded-2xl border-2 border-cyan-100 shadow-sm hover:shadow-md hover:bg-cyan-50 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                My Applications
            </a>
        </div>

        {{-- Application Status Overview --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
            {{-- Pending Applications --}}
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 border-2 border-yellow-200 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-yellow-50 text-yellow-600 border border-yellow-200 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-yellow-600">{{ $pendingCount ?? 0 }}</p>
                <p class="text-sm text-gray-400 mt-1">Pending Applications</p>
            </div>

            {{-- Approved Applications --}}
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 border-2 border-green-200 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-green-50 text-green-600 border border-green-200 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-green-600">{{ $approvedCount ?? 0 }}</p>
                <p class="text-sm text-gray-400 mt-1">Approved Applications</p>
            </div>

            {{-- All Pets Available --}}
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 border-2 border-violet-200 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-2xl bg-violet-50 text-violet-600 border border-violet-200 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                </div>
                <p class="text-3xl font-extrabold text-violet-600">{{ $availablePets ?? 0 }}</p>
                <p class="text-sm text-gray-400 mt-1">Pets Available</p>
            </div>
        </div>

        {{-- Featured Pets --}}
        <div class="bg-white/70 backdrop-blur-sm rounded-3xl border-2 border-violet-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b-2 border-violet-100 flex items-center justify-between bg-violet-50/20">
                <h2 class="text-lg font-bold text-gray-800">Featured Pets</h2>
                <a href="{{ route('pets.index') }}" class="text-sm font-semibold text-violet-500 hover:text-violet-750 transition">Explore all →</a>
            </div>
            @if($recentPets->isEmpty())
                <div class="px-6 py-16 text-center text-gray-400">
                    <p class="font-medium">No pets available right now. Check back soon!</p>
                </div>
            @else
                <div class="divide-y-2 divide-violet-100 p-2">
                    @foreach($recentPets as $pet)
                    <a href="{{ route('pets.show', $pet) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-violet-50 transition-colors border-2 border-transparent hover:border-violet-200 rounded-2xl m-1 group">
                        @if($pet->image)
                            <img src="{{ Storage::url($pet->image) }}" alt="{{ $pet->name }}" class="w-14 h-14 rounded-2xl object-cover ring-2 ring-violet-200 group-hover:ring-violet-300 transition-all"/>
                        @else
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-100 to-fuchsia-100 flex items-center justify-center text-2xl border border-violet-200"></div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $pet->name }}</p>
                            <p class="text-xs text-gray-400">{{ $pet->breed }} · {{ $pet->category->category_name ?? 'Uncategorized' }}</p>
                        </div>
                        @php
                            $c = match($pet->status) {
                                'Available' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                'Adopted'   => 'bg-cyan-50 text-cyan-700 border border-cyan-200',
                                'Archived'  => 'bg-gray-50 text-gray-500 border border-gray-250',
                                default     => 'bg-gray-50 text-gray-500 border border-gray-250',
                            };
                        @endphp
                        <span class="shrink-0 text-xs font-semibold px-3 py-1 rounded-full {{ $c }}">{{ $pet->status }}</span>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>

    @endif
</x-app-layout>
