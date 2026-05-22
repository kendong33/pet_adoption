<x-app-layout>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('pets.index') }}"
               class="p-2 rounded-2xl bg-white text-gray-500 hover:text-violet-600 hover:bg-violet-50 border-2 border-violet-100 shadow-sm transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800">Pet Details</h1>
                <p class="text-sm text-gray-400 mt-1">Viewing information for <span class="font-semibold text-violet-500">{{ $pet->name }}</span></p>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="flex items-center gap-3">
            <a href="{{ route('pets.edit', $pet) }}"
               class="inline-flex items-center gap-2 bg-white text-violet-600 text-sm font-bold px-5 py-2.5 rounded-2xl border-2 border-violet-100 shadow-sm hover:shadow-md hover:bg-violet-50 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('pets.destroy', $pet) }}" class="inline">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Permanently delete {{ $pet->name }}?')"
                        class="inline-flex items-center gap-2 bg-red-50 text-red-600 text-sm font-bold px-5 py-2.5 rounded-2xl border-2 border-red-200 shadow-sm hover:bg-red-100 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete
                </button>
            </form>
        </div>
        @endif
    </div>

    {{-- Main Content --}}
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl border-2 border-violet-100 shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-5 divide-y-2 lg:divide-y-0 lg:divide-x-2 divide-violet-100">
            
            {{-- Left: Image & Quick Actions --}}
            <div class="lg:col-span-2 p-8 flex flex-col items-center justify-center bg-gradient-to-b from-white to-violet-50/30">
                <div class="relative w-full max-w-[280px] aspect-square rounded-[2rem] overflow-hidden shadow-2xl border-4 border-violet-100 mb-6 bg-white">
                    @if($pet->image)
                        <img src="{{ Storage::url($pet->image) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover"/>
                    @else
                        <div class="w-full h-full bg-violet-100/50 flex items-center justify-center text-7xl opacity-50">🐾</div>
                    @endif
                    
                    @php
                        $badge = match($pet->status) {
                            'Available' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                            'Adopted'   => 'bg-cyan-50 text-cyan-700 border border-cyan-200',
                            'Archived'  => 'bg-gray-50 text-gray-700 border border-gray-200',
                            default     => 'bg-gray-50 text-gray-700 border border-gray-200',
                        };
                    @endphp
                    <span class="absolute top-4 right-4 text-xs font-black uppercase tracking-wider px-4 py-1.5 rounded-full shadow-lg backdrop-blur-md {{ $badge }}">
                        {{ $pet->status }}
                    </span>
                </div>
                
                <h2 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $pet->name }}</h2>
                <p class="text-gray-500 font-medium">{{ $pet->breed }}</p>

                @if(auth()->user()->isAdmin() && $pet->status !== 'Archived')
                <div class="mt-8 w-full">
                    <form method="POST" action="{{ route('pets.archive', $pet) }}">
                        @csrf @method('PATCH')
                        <button type="submit" onclick="return confirm('Archive {{ $pet->name }}?')"
                                class="w-full inline-flex items-center justify-center gap-2 bg-white text-gray-600 text-sm font-bold px-5 py-3 rounded-2xl border-2 border-gray-200 hover:bg-gray-50 hover:text-gray-900 transition-all cursor-pointer">
                            Archive this Pet
                        </button>
                    </form>
                </div>
                @elseif(!auth()->user()->isAdmin() && $pet->status === 'Available')
                <div class="mt-8 w-full">
                    <a href="{{ route('applications.create', ['pet_id' => $pet->id]) }}"
                       class="w-full inline-flex items-center justify-center gap-3 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-black text-lg font-black px-6 py-4 rounded-2xl shadow-xl hover:shadow-violet-300 hover:-translate-y-1 transition-all duration-300 border border-violet-700 group cursor-pointer">
                        <svg class="w-6 h-6 transition-transform group-hover:scale-125" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        Adopt {{ $pet->name }} Now!
                    </a>
                    <p class="text-center text-xs text-gray-400 mt-3 font-medium">Clicking will start your pending application process</p>
                </div>
                @endif

                @if(auth()->user()->isAdmin() && $pet->status === 'Adopted')
                @php
                    $approvedApp = $pet->applications()->where('application_status', 'Approved')->first();
                @endphp
                @if($approvedApp)
                <div class="mt-8 w-full bg-emerald-50 rounded-2xl p-5 border border-emerald-200">
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-2">Adopted By</p>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-emerald-200 rounded-full flex items-center justify-center text-emerald-700 font-bold">
                            {{ strtoupper(substr($approvedApp->adopter_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $approvedApp->adopter_name }}</p>
                            <p class="text-xs text-gray-500">{{ $approvedApp->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('applications.show', $approvedApp) }}" class="w-full inline-flex items-center justify-center gap-2 bg-white text-emerald-700 text-sm font-bold px-4 py-2.5 rounded-xl border border-emerald-200 hover:bg-emerald-100 transition-all">
                        View Application Details
                    </a>
                </div>
                @endif
                @endif
            </div>

            {{-- Right: Details --}}
            <div class="lg:col-span-3 p-8 sm:p-10">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center border border-violet-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    Pet Information
                </h3>

                <div class="grid grid-cols-2 gap-x-6 gap-y-8 mb-10">
                    <div class="bg-violet-50/50 rounded-2xl p-4 border border-violet-200">
                        <p class="text-xs font-bold text-violet-400 uppercase tracking-wider mb-1">Category</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $pet->category->category_name ?? 'Uncategorized' }}</p>
                    </div>
                    <div class="bg-violet-50/50 rounded-2xl p-4 border border-violet-200">
                        <p class="text-xs font-bold text-violet-400 uppercase tracking-wider mb-1">Gender</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $pet->gender }}</p>
                    </div>
                    <div class="bg-violet-50/50 rounded-2xl p-4 border border-violet-200">
                        <p class="text-xs font-bold text-violet-400 uppercase tracking-wider mb-1">Age</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $pet->age }} year{{ $pet->age !== 1 ? 's' : '' }}</p>
                    </div>
                    <div class="bg-violet-50/50 rounded-2xl p-4 border border-violet-200">
                        <p class="text-xs font-bold text-violet-400 uppercase tracking-wider mb-1">Health Status</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $pet->health_status ?? 'Not specified' }}</p>
                    </div>
                </div>

                @if($pet->description)
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center border border-violet-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        </span>
                        About {{ $pet->name }}
                    </h3>
                    <div class="bg-white rounded-2xl p-5 border border-violet-200 text-gray-600 leading-relaxed text-sm">
                        {{ $pet->description }}
                    </div>
                </div>
                @endif

                <div class="pt-6 border-t-2 border-violet-100 flex items-center gap-6 text-xs font-medium text-gray-400">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Added {{ $pet->created_at->format('M d, Y') }}
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Updated {{ $pet->updated_at->format('M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
