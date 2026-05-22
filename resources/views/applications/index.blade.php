<x-app-layout>
<style>
    .gradient-text-primary {
        background: linear-gradient(135deg, #ff1b6d 0%, #ff6b35 50%, #f7931e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .gradient-text-secondary {
        background: linear-gradient(135deg, #00d4ff 0%, #0099ff 50%, #6b5bff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .stat-card {
        background: linear-gradient(135deg, rgba(17,24,39,0.8) 0%, rgba(0,0,0,0.6) 100%);
        border: 2px solid rgba(139, 92, 246, 0.3);
        box-shadow: 0 0 20px rgba(139, 92, 246, 0.15);
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        border-color: rgba(139, 92, 246, 0.6);
        box-shadow: 0 0 30px rgba(139, 92, 246, 0.3), inset 0 0 20px rgba(139, 92, 246, 0.05);
        transform: translateY(-2px);
    }
</style>

<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-5xl font-black mb-2">
                        <span class="gradient-text-primary">Adoption</span>
                        <span class="gradient-text-secondary">Applications</span>
                    </h1>
                    <p class="text-sm text-gray-400">Manage and review all adoption applications</p>
                </div>
            </div>

            <!-- Dashboard Widgets -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
                <div class="stat-card rounded-3xl p-6">
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-3">Total Applications</p>
                    <p class="text-4xl font-black bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">{{ $stats['total'] }}</p>
                </div>

                <div class="stat-card rounded-3xl p-6">
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-3">Pending</p>
                    <p class="text-4xl font-black bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">{{ $stats['pending'] }}</p>
                </div>

                <div class="stat-card rounded-3xl p-6">
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-3">Interview Scheduled</p>
                    <p class="text-4xl font-black bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">{{ $stats['interview_scheduled'] }}</p>
                </div>

                <div class="stat-card rounded-3xl p-6">
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-3">Approved</p>
                    <p class="text-4xl font-black bg-gradient-to-r from-emerald-400 to-green-500 bg-clip-text text-transparent">{{ $stats['approved'] }}</p>
                </div>

                <div class="stat-card rounded-3xl p-6">
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-3">Declined</p>
                    <p class="text-4xl font-black bg-gradient-to-r from-rose-400 to-red-500 bg-clip-text text-transparent">{{ $stats['declined'] }}</p>
                </div>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 backdrop-blur-xl rounded-3xl p-6 border-2 border-purple-500/30 shadow-xl shadow-purple-500/10 mb-8">
            <form method="GET" action="{{ route('applications.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Search</label>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Adopter name or pet..." class="w-full rounded-xl border-2 border-purple-500/30 bg-slate-800/40 text-sm text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 px-4 py-2.5 transition backdrop-blur-sm">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status</label>
                        <select name="status" onchange="this.form.submit()" class="w-full rounded-xl border-2 border-purple-500/30 bg-slate-800/40 text-sm text-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 px-4 py-2.5 transition backdrop-blur-sm cursor-pointer">
                            <option value="Active" {{ $application_status === 'Active' ? 'selected' : '' }} class="bg-slate-800">Active (Pending/Interview)</option>
                            <option value="All" {{ $application_status === 'All' ? 'selected' : '' }} class="bg-slate-800">All Statuses</option>
                            <option value="Pending" {{ $application_status === 'Pending' ? 'selected' : '' }} class="bg-slate-800">Pending</option>
                            <option value="Interview Scheduled" {{ $application_status === 'Interview Scheduled' ? 'selected' : '' }} class="bg-slate-800">Interview Scheduled</option>
                            <option value="Approved" {{ $application_status === 'Approved' ? 'selected' : '' }} class="bg-slate-800">Approved</option>
                            <option value="Declined" {{ $application_status === 'Declined' ? 'selected' : '' }} class="bg-slate-800">Declined</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pet Category</label>
                        <select name="category" onchange="this.form.submit()" class="w-full rounded-xl border-2 border-purple-500/30 bg-slate-800/40 text-sm text-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 px-4 py-2.5 transition backdrop-blur-sm cursor-pointer">
                            <option value="" class="bg-slate-800">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (string)$category === (string)$cat->id ? 'selected' : '' }} class="bg-slate-800">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-end gap-2">
                        <a href="{{ route('applications.index') }}" class="w-full text-center bg-gradient-to-r from-purple-600/80 to-pink-600/80 hover:from-purple-500 hover:to-pink-500 text-white text-sm font-bold px-5 py-2.5 rounded-xl border border-purple-400/50 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/50 transform hover:-translate-y-0.5">
                            Reset Filters
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Applications List -->
        <div class="space-y-4">
            @if ($applications->count() > 0)
                @foreach ($applications as $application)
                    <div onclick="window.location.href='{{ route('applications.show', $application) }}'" class="cursor-pointer block bg-gradient-to-br from-slate-800/60 to-slate-900/80 rounded-3xl p-6 border-2 border-purple-500/40 hover:border-purple-400/80 transition-all duration-300 group hover:shadow-xl hover:shadow-purple-500/25 hover:-translate-y-1">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <!-- Header Row -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <!-- Pet Icon -->
                                        <div class="w-14 h-14 bg-gradient-to-br from-purple-600/40 to-pink-600/40 border-2 border-purple-500/60 rounded-full flex items-center justify-center text-2xl shadow-lg shadow-purple-500/20 group-hover:shadow-purple-500/40 transition">
                                            🐾
                                        </div>

                                        <!-- Name and Email -->
                                        <div>
                                            <h3 class="text-lg font-extrabold text-transparent bg-gradient-to-r from-cyan-300 to-blue-400 bg-clip-text group-hover:from-pink-300 group-hover:to-orange-400 transition">
                                                {{ $application->adopter_name }}
                                            </h3>
                                            <p class="text-sm text-gray-400">{{ $application->email }}</p>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <span class="px-4 py-2 bg-gradient-to-r from-purple-600/50 to-pink-600/50 border border-purple-400/60 rounded-full font-bold text-sm text-purple-200 shadow-lg shadow-purple-500/20">
                                        {{ $application->application_status }}
                                    </span>
                                </div>

                                <!-- Pet and Date Info -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-sm">
                                    <div class="flex flex-wrap gap-x-6 gap-y-2">
                                        <span>
                                            <span class="text-gray-500">Pet:</span>
                                            <span class="text-gray-200 font-semibold">{{ $application->pet->name }}</span>
                                            <span class="text-cyan-400 font-medium">({{ $application->pet->category->category_name ?? 'Uncategorized' }})</span>
                                        </span>
                                        <span>
                                            <span class="text-gray-500">Applied:</span>
                                            <span class="text-gray-200 font-semibold">{{ $application->application_date->format('M d, Y') }}</span>
                                        </span>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="flex gap-2">
                                        @if (!$application->isApproved() && !$application->isDeclined())
                                            <form id="form-approve-{{ $application->id }}" method="POST" action="{{ route('applications.approve', $application) }}" class="inline" onclick="event.stopPropagation();">
                                                @csrf
                                                <button type="button" onclick="event.stopPropagation(); openApprovalModal('form-approve-{{ $application->id }}', '{{ addslashes($application->pet->name) }}', '{{ addslashes($application->adopter_name) }}')" class="px-4 py-2 text-xs bg-gradient-to-r from-emerald-600/80 to-green-600/80 hover:from-emerald-500 hover:to-green-500 text-white border border-emerald-400/60 rounded-lg font-bold transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/40 transform hover:-translate-y-0.5 cursor-pointer" title="Approve">
                                                    ✓ Approve
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('applications.decline', $application) }}" class="inline" onclick="event.stopPropagation();">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 text-xs bg-gradient-to-r from-rose-600/80 to-red-600/80 hover:from-rose-500 hover:to-red-500 text-white border border-rose-400/60 rounded-lg font-bold transition-all duration-300 hover:shadow-lg hover:shadow-rose-500/40 transform hover:-translate-y-0.5 cursor-pointer" title="Decline">
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
                <div class="bg-gradient-to-br from-slate-800/60 to-slate-900/80 rounded-3xl p-12 border-2 border-purple-500/40 text-center">
                    <p class="text-6xl mb-4">🐾</p>
                    <h3 class="text-2xl font-bold text-transparent bg-gradient-to-r from-pink-400 to-orange-400 bg-clip-text mb-2">No Applications Found</h3>
                    <p class="text-gray-400">No adoption applications match your search criteria.</p>
                </div>
            @endif
        </div>

        <!-- Action Links -->
        <div class="mt-12 flex gap-4 justify-center">
            <a href="{{ route('applications.history') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600/80 to-pink-600/80 hover:from-purple-500 hover:to-pink-500 text-white text-sm font-bold px-8 py-3 rounded-2xl border border-purple-400/60 shadow-lg shadow-purple-500/20 hover:shadow-purple-500/40 transition-all duration-300 transform hover:-translate-y-1">
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
    <div class="absolute inset-0 bg-black/70 backdrop-blur-md" onclick="closeApprovalModal()"></div>

    {{-- Modal box --}}
    <div data-modal-box
         class="relative w-full max-w-md bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-2xl border-2 border-purple-500/50 p-8
                transform transition-all duration-300 ease-out scale-95 opacity-0">

        {{-- Icon --}}
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/50">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Title --}}
        <h2 id="approvalModalTitle" class="text-2xl font-extrabold text-center mb-2 bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">
            Approve this Application?
        </h2>
        <p class="text-center text-gray-400 text-sm mb-6">
            You are about to approve the adoption application for
            <span id="modal-pet-name" class="font-bold text-cyan-400"></span>
            by <span id="modal-adopter-name" class="font-bold text-pink-400"></span>.
        </p>

        {{-- Warning banner --}}
        <div class="flex items-start gap-3 bg-amber-900/30 border-2 border-amber-500/50 rounded-2xl p-4 mb-6">
            <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-amber-300">This action is irreversible.</p>
                <p class="text-xs text-amber-200 mt-0.5">Once approved, the status will be permanently locked and the pet will be marked as <strong>Adopted</strong>.</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3">
            <button type="button"
                    onclick="closeApprovalModal()"
                    class="flex-1 px-5 py-3 bg-slate-700/50 hover:bg-slate-700 text-gray-200 font-bold rounded-2xl border-2 border-slate-600 transition-all duration-300 transform hover:-translate-y-0.5">
                Cancel
            </button>
            <button type="button"
                    onclick="confirmApproval()"
                    class="flex-1 px-5 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold rounded-2xl shadow-lg shadow-emerald-500/40 hover:shadow-emerald-500/60 transition-all duration-300 transform hover:-translate-y-0.5 border border-emerald-400/60">
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
