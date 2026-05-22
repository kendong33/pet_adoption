<x-app-layout>
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">🐾 Pet Management</h1>
            <p class="text-gray-400 mt-1">{{ auth()->user()->isAdmin() ? 'Create, edit and manage all shelter pets' : 'Browse available pets for adoption' }}</p>
        </div>
        @if(auth()->user()->isAdmin())
        <div class="flex flex-wrap gap-2">
            @if(request('status') === 'Adopted' || request('status') === 'Archived')
                <a href="{{ route('pets.index') }}"
                   class="inline-flex items-center gap-2 bg-white text-violet-700 text-sm font-semibold px-5 py-2.5 rounded-2xl shadow-sm border border-violet-200 hover:bg-violet-50 transition-all duration-300 shrink-0">
                    <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    Back to Available Pets
                </a>
            @endif

            @if(request('status') !== 'Adopted')
                <a href="{{ route('pets.index', ['status' => 'Adopted']) }}"
                   class="inline-flex items-center gap-2 bg-white text-gray-700 text-sm font-semibold px-5 py-2.5 rounded-2xl shadow-sm border border-gray-200 hover:bg-gray-50 transition-all duration-300 shrink-0">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    View Adopted Pets
                </a>
            @endif

            @if(request('status') !== 'Archived')
                <a href="{{ route('pets.index', ['status' => 'Archived']) }}"
                   class="inline-flex items-center gap-2 bg-white text-gray-700 text-sm font-semibold px-5 py-2.5 rounded-2xl shadow-sm border border-gray-200 hover:bg-gray-50 transition-all duration-300 shrink-0">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    View Archives
                </a>
            @endif

            <a href="{{ route('pets.create') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-black text-sm font-semibold px-5 py-2.5 rounded-2xl shadow-lg border border-violet-700 hover:shadow-xl hover:shadow-violet-300 transition-all duration-300 hover:-translate-y-0.5 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add New Pet
            </a>
        </div>
        @endif
    </div>

    {{-- Search & Filters --}}
    <div class="bg-white/70 backdrop-blur-sm rounded-3xl border-2 border-violet-100 shadow-sm p-5 mb-8">
        <form method="GET" action="{{ route('pets.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, breed or category…"
                       class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/50 text-sm text-gray-700 placeholder-gray-400 focus:ring-violet-300 focus:border-violet-300 px-4 py-2.5"/>
            </div>
            <div class="min-w-[140px]">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Category</label>
                <select name="category_id" class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/50 text-sm text-gray-700 focus:ring-violet-300 focus:border-violet-300 px-4 py-2.5">
                    <option value="">All</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[120px]">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Gender</label>
                <select name="gender" class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/50 text-sm text-gray-700 focus:ring-violet-300 focus:border-violet-300 px-4 py-2.5">
                    <option value="">All</option>
                    <option value="Male"   {{ request('gender') === 'Male'   ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            @if(auth()->user()->isAdmin())
            <div class="min-w-[130px]">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Status</label>
                <select name="status" class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/50 text-sm text-gray-700 focus:ring-violet-300 focus:border-violet-300 px-4 py-2.5">
                    @php $currentStatus = request()->has('status') ? request('status') : 'Available'; @endphp
                    <option value="">All</option>
                    <option value="Available" {{ $currentStatus === 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Adopted"   {{ $currentStatus === 'Adopted'   ? 'selected' : '' }}>Adopted</option>
                    <option value="Archived"  {{ $currentStatus === 'Archived'  ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            @endif
            <div class="flex gap-2">
                <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold px-5 py-2.5 rounded-2xl transition-all shadow-sm hover:shadow-md border border-violet-700 cursor-pointer">Filter</button>
                <a href="{{ route('pets.index') }}" class="bg-white text-gray-500 text-sm font-semibold px-5 py-2.5 rounded-2xl border-2 border-violet-100 hover:bg-violet-50 transition">Reset</a>
            </div>
        </form>
    </div>

    {{-- Pet Cards Grid --}}
    @if($pets->isEmpty())
        <div class="bg-white/70 backdrop-blur-sm rounded-3xl border-2 border-violet-100 shadow-sm flex flex-col items-center justify-center py-24 text-gray-400">
            <p class="text-6xl mb-4">🐾</p>
            <p class="text-lg font-bold text-gray-500">No pets found</p>
            <p class="text-sm mt-1">Try adjusting your search or filters.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
            @foreach($pets as $pet)
            <div class="pet-card bg-white/70 backdrop-blur-sm rounded-3xl border-2 border-violet-100 shadow-sm overflow-hidden group">
                {{-- Image --}}
                <div class="relative h-52 overflow-hidden bg-gradient-to-br from-violet-100 to-fuchsia-50 border-b-2 border-violet-100">
                    @if($pet->image)
                        <img src="{{ Storage::url($pet->image) }}" alt="{{ $pet->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                    @else
                        <div class="w-full h-full flex items-center justify-center text-7xl opacity-40">🐾</div>
                    @endif
                    {{-- Status badge overlay --}}
                    @php
                        $badge = match($pet->status) {
                            'Available' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'Adopted'   => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                            'Archived'  => 'bg-gray-50 text-gray-700 border-gray-200',
                            default     => 'bg-gray-50 text-gray-700 border-gray-200',
                        };
                    @endphp
                    <span class="absolute top-3 right-3 text-xs font-bold px-3 py-1 rounded-full border shadow-sm {{ $badge }}">{{ $pet->status }}</span>
                </div>

                {{-- Info --}}
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $pet->name }}</h3>
                    <p class="text-sm text-gray-400 mb-3">{{ $pet->breed }} · {{ $pet->category->category_name ?? 'Uncategorized' }}</p>

                    <div class="flex flex-wrap gap-2 text-xs mb-4">
                        <span class="bg-violet-50 text-violet-600 border border-violet-100 font-semibold px-2.5 py-1 rounded-full">{{ $pet->age }} yr{{ $pet->age !== 1 ? 's' : '' }}</span>
                        <span class="bg-fuchsia-50 text-fuchsia-600 border border-fuchsia-100 font-semibold px-2.5 py-1 rounded-full">{{ $pet->gender }}</span>
                        @if($pet->health_status)
                        <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 font-semibold px-2.5 py-1 rounded-full">{{ $pet->health_status }}</span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-3 border-t border-violet-100">
                        <a href="{{ route('pets.show', $pet) }}"
                           class="flex-1 text-center text-sm font-semibold text-violet-600 bg-violet-50 hover:bg-violet-100 py-2 rounded-xl border border-violet-200 transition">
                            View
                        </a>
                        @if(auth()->user()->isAdmin())
                        @if($pet->status === 'Adopted')
                            <div class="flex-1 text-center text-sm font-semibold text-gray-400 bg-gray-50 py-2 rounded-xl border border-gray-100 cursor-not-allowed" title="Adopted pets cannot be edited">
                                Edit
                            </div>
                        @else
                            <a href="{{ route('pets.edit', $pet) }}"
                               class="flex-1 text-center text-sm font-semibold text-amber-600 bg-amber-50 hover:bg-amber-100 py-2 rounded-xl border border-amber-200 transition">
                                Edit
                            </a>
                        @endif
                        @if($pet->status === 'Archived')
                        <form method="POST" action="{{ route('pets.unarchive', $pet) }}" class="flex-1">
                            @csrf @method('PATCH')
                            <button onclick="return confirm('Unarchive {{ $pet->name }}?')"
                                    class="w-full text-sm font-semibold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 py-2 rounded-xl border border-emerald-200 transition cursor-pointer">
                                Unarchive
                            </button>
                        </form>
                        @elseif($pet->status !== 'Adopted')
                        <form method="POST" action="{{ route('pets.archive', $pet) }}" class="flex-1">
                            @csrf @method('PATCH')
                            <button onclick="return confirm('Archive {{ $pet->name }}?')"
                                    class="w-full text-sm font-semibold text-gray-500 bg-gray-50 hover:bg-gray-100 py-2 rounded-xl border border-gray-200 transition cursor-pointer">
                                Archive
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('pets.destroy', $pet) }}">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Permanently delete {{ $pet->name }}?')"
                                    class="text-sm font-semibold text-red-500 hover:text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded-xl border border-red-200 transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="flex justify-center">
            {{ $pets->links() }}
        </div>
    @endif
</x-app-layout>
