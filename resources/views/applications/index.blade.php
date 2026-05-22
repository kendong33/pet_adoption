<x-app-layout>
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-800 mb-2">
                        Adoption Applications
                    </h1>
                    <p class="text-sm text-gray-400">Manage and review all adoption applications</p>
                </div>
            </div>

            <!-- Dashboard Widgets -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border-2 border-violet-100 shadow-sm hover:shadow-md hover:border-violet-200 transition">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Total Applications</p>
                    <p class="text-4xl font-extrabold text-gray-800">{{ $stats['total'] }}</p>
                </div>

                <div class="bg-yellow-50/50 backdrop-blur-sm rounded-2xl p-6 border-2 border-yellow-200 hover:shadow-md hover:border-yellow-300 transition">
                    <p class="text-yellow-600 text-xs font-bold uppercase tracking-wider mb-2">Pending</p>
                    <p class="text-4xl font-extrabold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>

                <div class="bg-blue-50/50 backdrop-blur-sm rounded-2xl p-6 border-2 border-blue-200 hover:shadow-md hover:border-blue-300 transition">
                    <p class="text-blue-600 text-xs font-bold uppercase tracking-wider mb-2">Interview Scheduled</p>
                    <p class="text-4xl font-extrabold text-blue-600">{{ $stats['interview_scheduled'] }}</p>
                </div>

                <div class="bg-emerald-50/50 backdrop-blur-sm rounded-2xl p-6 border-2 border-emerald-200 hover:shadow-md hover:border-emerald-300 transition">
                    <p class="text-emerald-600 text-xs font-bold uppercase tracking-wider mb-2">Approved</p>
                    <p class="text-4xl font-extrabold text-emerald-600">{{ $stats['approved'] }}</p>
                </div>

                <div class="bg-red-50/50 backdrop-blur-sm rounded-2xl p-6 border-2 border-red-200 hover:shadow-md hover:border-red-300 transition">
                    <p class="text-red-600 text-xs font-bold uppercase tracking-wider mb-2">Declined</p>
                    <p class="text-4xl font-extrabold text-red-600">{{ $stats['declined'] }}</p>
                </div>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white/70 backdrop-blur-sm rounded-3xl px-6 py-5 border-2 border-violet-100/80 shadow-sm mb-8">
            <form method="GET" action="{{ route('applications.index') }}">
                <div class="flex flex-wrap items-end gap-4">
                    <!-- Search -->
                    <div class="flex-1 min-w-[180px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Search</label>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Adopter name or pet..." class="w-full rounded-xl border-2 border-violet-200 bg-white text-sm text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-violet-400 focus:border-violet-400 px-4 py-2.5 transition shadow-sm">
                    </div>

                    <!-- Status Filter -->
                    <div class="min-w-[220px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Status</label>
                        <select name="status" onchange="this.form.submit()" class="w-full rounded-xl border-2 border-violet-200 bg-white text-sm text-gray-700 focus:ring-2 focus:ring-violet-400 focus:border-violet-400 px-4 py-2.5 transition shadow-sm cursor-pointer">
                            <option value="Active" {{ $application_status === 'Active' ? 'selected' : '' }}>Active (Pending/Interview)</option>
                            <option value="All" {{ $application_status === 'All' ? 'selected' : '' }}>All Statuses</option>
                            <option value="Pending" {{ $application_status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Interview Scheduled" {{ $application_status === 'Interview Scheduled' ? 'selected' : '' }}>Interview Scheduled</option>
                            <option value="Approved" {{ $application_status === 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Declined" {{ $application_status === 'Declined' ? 'selected' : '' }}>Declined</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div class="min-w-[160px]">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Pet Category</label>
                        <select name="category" onchange="this.form.submit()" class="w-full rounded-xl border-2 border-violet-200 bg-white text-sm text-gray-700 focus:ring-2 focus:ring-violet-400 focus:border-violet-400 px-4 py-2.5 transition shadow-sm cursor-pointer">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (string)$category === (string)$cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-xl shadow-md transition">
                            Search
                        </button>
                        <a href="{{ route('applications.index') }}" class="px-5 py-2.5 bg-white text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-xl border-2 border-gray-200 transition">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Applications List -->
        <div class="space-y-4">
            @if ($applications->count() > 0)
                @foreach ($applications as $application)
                    <div onclick="window.location.href='{{ route('applications.show', $application) }}'" class="cursor-pointer block bg-white/80 backdrop-blur-xl rounded-2xl p-6 border-2 border-violet-100 hover:border-violet-300 hover:shadow-lg transition duration-300 group">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <!-- Header Row -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <!-- Pet Icon -->
                                        <div class="w-12 h-12 bg-violet-100 border-2 border-violet-200 rounded-full flex items-center justify-center text-xl shadow-sm group-hover:shadow-md transition">
                                            🐾
                                        </div>

                                        <!-- Name and Email -->
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-violet-600 transition">
                                                {{ $application->adopter_name }}
                                            </h3>
                                            <p class="text-sm text-gray-500">{{ $application->email }}</p>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <span class="px-4 py-1.5 bg-violet-100 text-violet-700 border border-violet-300 rounded-full font-bold text-sm">
                                        {{ $application->application_status }}
                                    </span>
                                </div>

                                <!-- Pet and Date Info -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-sm">
                                    <div class="flex flex-wrap gap-x-6 gap-y-1">
                                        <span>
                                            <span class="text-gray-400">Pet:</span>
                                            <span class="text-gray-700 font-semibold">{{ $application->pet->name }}</span>
                                            <span class="text-violet-600 font-medium">({{ $application->pet->category->category_name ?? 'Uncategorized' }})</span>
                                        </span>
                                        <span>
                                            <span class="text-gray-400">Applied:</span>
                                            <span class="text-gray-700 font-semibold">{{ $application->application_date->format('M d, Y') }}</span>
                                        </span>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="flex gap-2">
                                        @if (!$application->isApproved() && !$application->isDeclined())
                                            <form id="form-approve-{{ $application->id }}" method="POST" action="{{ route('applications.approve', $application) }}" class="inline" onclick="event.stopPropagation();">
                                                @csrf
                                                <button type="button" onclick="event.stopPropagation(); openApprovalModal('form-approve-{{ $application->id }}', '{{ addslashes($application->pet->name) }}', '{{ addslashes($application->adopter_name) }}')" class="px-4 py-1.5 text-xs bg-emerald-100 hover:bg-emerald-200 text-emerald-700 border-2 border-emerald-300 rounded-lg font-bold transition shadow-sm hover:shadow-md transform hover:-translate-y-0.5 cursor-pointer" title="Approve">
                                                    ✓ Approve
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('applications.decline', $application) }}" class="inline" onclick="event.stopPropagation();">
                                                @csrf
                                                <button type="submit" class="px-4 py-1.5 text-xs bg-red-100 hover:bg-red-200 text-red-700 border-2 border-red-300 rounded-lg font-bold transition shadow-sm hover:shadow-md transform hover:-translate-y-0.5 cursor-pointer" title="Decline">
                                                    ✕ Decline
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if ($applications->hasPages())
                    <div class="mt-8">
                        {{ $applications->links() }}
                    </div>
                @endif
            @else
                <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-12 border-2 border-violet-100 text-center">
                    <p class="text-5xl mb-4">🐾</p>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No Applications Found</h3>
                    <p class="text-gray-400">No adoption applications match your search criteria.</p>
                </div>
            @endif
        </div>

        <!-- Action Links -->
        <div class="mt-12 flex gap-4 justify-center">
            <a href="{{ route('applications.history') }}" class="inline-flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-bold px-8 py-3 rounded-2xl border-0 shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                📋 View Application History
            </a>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     APPROVAL CONFIRMATION MODAL
═══════════════════════════════════════════════════════════ --}}
<div id="approvalModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="approvalModalTitle">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeApprovalModal()"></div>

    {{-- Modal box --}}
    <div data-modal-box
         class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border-2 border-violet-200 p-8
                transform transition-all duration-300 ease-out scale-95 opacity-0">

        {{-- Icon --}}
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-200">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Title --}}
        <h2 id="approvalModalTitle" class="text-2xl font-bold text-gray-800 text-center mb-2">
            Approve this Application?
        </h2>
        <p class="text-center text-gray-600 text-sm mb-6">
            You are about to approve the adoption application for
            <span id="modal-pet-name" class="font-bold text-violet-600"></span>
            by <span id="modal-adopter-name" class="font-bold text-gray-800"></span>.
        </p>

        {{-- Warning banner --}}
        <div class="flex items-start gap-3 bg-amber-50 border-2 border-amber-300 rounded-2xl p-4 mb-6">
            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-amber-800">This action is irreversible.</p>
                <p class="text-xs text-amber-700 mt-0.5">Once approved, the status will be permanently locked and the pet will be marked as <strong>Adopted</strong>.</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3">
            <button type="button"
                    onclick="closeApprovalModal()"
                    class="flex-1 px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-2xl border-2 border-gray-300 transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                Cancel
            </button>
            <button type="button"
                    onclick="confirmApproval()"
                    class="flex-1 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl shadow-lg shadow-emerald-300 hover:shadow-emerald-400 transition-all transform hover:-translate-y-0.5 border-0">
                ✓ Confirm Approval
            </button>
        </div>
    </div>
</div>

<script>
    let currentFormId = null;

    function openApprovalModal(formId, petName, adopterName) {
        currentFormId = formId;
        document.getElementById('modal-pet-name').textContent = petName;
        document.getElementById('modal-adopter-name').textContent = adopterName;
        
        const modal = document.getElementById('approvalModal');
        modal.classList.remove('hidden');
        // Animate in
        setTimeout(() => {
            modal.querySelector('[data-modal-box]').classList.remove('scale-95', 'opacity-0');
            modal.querySelector('[data-modal-box]').classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeApprovalModal() {
        const modal = document.getElementById('approvalModal');
        const box = modal.querySelector('[data-modal-box]');
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 200);
        currentFormId = null;
    }

    function confirmApproval() {
        if (currentFormId) {
            document.getElementById(currentFormId).submit();
        }
    }
</script>

</x-app-layout>
