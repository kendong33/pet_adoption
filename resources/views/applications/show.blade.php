<x-app-layout>
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header with Status -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-800 mb-2">
                        Application for <span class="text-violet-600">{{ $application->pet->name }}</span>
                    </h1>
                    <p class="text-sm text-gray-400">Submitted on {{ $application->application_date->format('F j, Y') }}</p>
                </div>
                <div class="text-center">
                    <span class="inline-block px-5 py-2.5 bg-{{ $application->getStatusColor() }}-50 text-{{ $application->getStatusColor() }}-700 border-2 border-{{ $application->getStatusColor() }}-200 rounded-full font-bold text-base">
                        {{ $application->getStatusIcon() }} {{ $application->application_status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Pet Info (Sidebar) -->
            <div class="md:col-span-1">
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-6 border-2 border-violet-100 shadow-xl sticky top-8">
                    <!-- Pet Image -->
                    <div class="mb-6 rounded-2xl overflow-hidden border-2 border-violet-100 shadow-inner">
                        @if ($application->pet->image)
                            <img src="{{ asset('storage/' . $application->pet->image) }}" alt="{{ $application->pet->name }}" class="w-full h-64 object-cover">
                        @else
                            <div class="w-full h-64 bg-violet-100/50 flex items-center justify-center">
                            </div>
                        @endif
                    </div>

                    <!-- Pet Details -->
                    <div class="space-y-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $application->pet->name }}</h2>
                            <div class="flex gap-2 flex-wrap">
                                <span class="px-3 py-1 bg-violet-50 text-violet-700 border border-violet-200 rounded-full text-xs font-semibold">
                                    {{ $application->pet->category->category_name ?? 'Uncategorized' }}
                                </span>
                                <span class="px-3 py-1 bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-200 rounded-full text-xs font-semibold">
                                    {{ $application->pet->gender }}
                                </span>
                            </div>
                        </div>

                        <div class="border-t border-violet-100 pt-4 space-y-3">
                            <div class="bg-violet-50/50 rounded-2xl p-3.5 border border-violet-100">
                                <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Breed</p>
                                <p class="font-semibold text-gray-800">{{ $application->pet->breed }}</p>
                            </div>
                            <div class="bg-violet-50/50 rounded-2xl p-3.5 border border-violet-100">
                                <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Age</p>
                                <p class="font-semibold text-gray-800">{{ $application->pet->age }} year{{ $application->pet->age !== 1 ? 's' : '' }}</p>
                            </div>
                            @if ($application->pet->health_status)
                                <div class="bg-violet-50/50 rounded-2xl p-3.5 border border-violet-100">
                                    <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Health Status</p>
                                    <p class="font-semibold text-gray-800">{{ $application->pet->health_status }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Details -->
            <div class="md:col-span-2 space-y-6">
                <!-- Adopter Information -->
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">
                        Adopter Information
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-violet-50/50 rounded-2xl p-4 border border-violet-100">
                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Full Name</p>
                            <p class="text-gray-800 text-lg font-semibold">{{ $application->adopter_name }}</p>
                        </div>

                        <div class="bg-violet-50/50 rounded-2xl p-4 border border-violet-100">
                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Phone Number</p>
                            <p class="text-gray-800 text-lg font-semibold">{{ $application->contact_number }}</p>
                        </div>

                        <div class="bg-violet-50/50 rounded-2xl p-4 border border-violet-100">
                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Application Date</p>
                            <p class="text-gray-800 text-lg font-semibold">{{ $application->application_date->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-violet-100">
                        <div class="bg-violet-50/50 rounded-2xl p-4 border border-violet-100">
                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-2">Home Address</p>
                            <p class="text-gray-800">{{ $application->address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Home Background -->
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">
                        Home Background
                    </h3>
                    <div class="bg-violet-50/50 rounded-2xl p-5 border border-violet-100 text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $application->home_background }}</div>
                </div>

                @if (auth()->user()->isAdmin())
                    <!-- Admin Section -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">
                            Admin Actions
                        </h3>

                        <!-- Status Section -->
                        <div id="status-section" class="mb-8">
                            @if ($application->application_status === 'Approved')
                                <div class="flex items-center gap-4 p-5 bg-emerald-50 rounded-2xl border-2 border-emerald-200">
                                    <div class="flex-1">
                                        <p class="text-emerald-500 text-xs font-bold uppercase tracking-wider mb-2">Application Status</p>
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-100 text-emerald-700 border-2 border-emerald-300 rounded-full font-bold text-sm">
                                                Approved
                                            </span>
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 bg-emerald-100 border border-emerald-200 px-3 py-1.5 rounded-full">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                Status Locked
                                            </span>
                                        </div>
                                    </div>
                                    <div class="shrink-0 text-right">
                                        <p class="text-xs text-emerald-500 font-semibold">This decision is final.</p>
                                        <p class="text-xs text-emerald-400 mt-0.5">Pet marked as Adopted.</p>
                                    </div>
                                </div>
                            @else
                                <!-- View Mode -->
                                <div id="status-view-mode">
                                    <div class="flex items-center justify-between gap-4 p-5 bg-violet-50/50 rounded-2xl border border-violet-100">
                                        <div>
                                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-2">Current Status</p>
                                            <div class="inline-block px-5 py-2.5 bg-{{ $application->getStatusColor() }}-50 text-{{ $application->getStatusColor() }}-700 border border-{{ $application->getStatusColor() }}-200 rounded-full font-bold text-sm">
                                                {{ $application->getStatusIcon() }} {{ $application->application_status }}
                                            </div>
                                        </div>
                                        <button type="button" onclick="toggleStatusEditMode()" class="px-4 py-2 bg-violet-600 text-white font-bold rounded-xl hover:bg-violet-700 transition">
                                            Change Status
                                        </button>
                                    </div>
                                </div>

                                <!-- Edit Mode -->
                                <div id="status-edit-mode" style="display: none;">
                                    <form method="POST" action="{{ route('applications.update', $application) }}" id="status-form" onsubmit="return handleStatusSubmit(event)">
                                        @csrf
                                        @method('PUT')

                                        <!-- Hidden admin notes field to preserve current notes -->
                                        <input type="hidden" name="admin_notes" value="{{ $application->admin_notes }}">

                                        <div class="space-y-4 p-5 bg-violet-50/50 rounded-2xl border border-violet-100">
                                            <div>
                                                <label for="status" class="block text-xs font-bold text-violet-400 uppercase tracking-wider mb-3">
                                                    Update Application Status
                                                </label>
                                                <div class="grid grid-cols-2 gap-3" id="status-buttons-container">
                                                    @foreach (['Pending', 'Interview Scheduled', 'Approved', 'Declined'] as $status)
                                                        <label class="relative cursor-pointer">
                                                            <input type="radio" name="status" value="{{ $status }}" {{ $application->application_status === $status ? 'checked' : '' }} required class="sr-only peer status-radio" onchange="updateStatusHighlight()">
                                                            <div class="status-button px-4 py-3 rounded-xl border-2 border-violet-200 bg-white text-gray-700 font-semibold text-center transition hover:border-violet-400 {{ $application->application_status === $status ? 'border-violet-600 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-white shadow-lg scale-105' : '' }}">
                                                                {{ $status }}
                                                                @if ($status === 'Approved')
                                                                    <span class="block text-xs font-normal opacity-75 mt-0.5">Irreversible</span>
                                                                @endif
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                                @error('status')
                                                    <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="flex gap-3 justify-end pt-2 border-t border-violet-200">
                                                <button type="button" onclick="cancelStatusEditMode()" class="px-4 py-2 bg-white text-gray-700 font-bold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-white font-bold rounded-xl border border-violet-700 hover:shadow-lg transition">
                                                    Update Status
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <!-- Admin Notes Section -->
                        <div id="admin-notes-section">
                            <!-- View Mode -->
                            <div id="notes-view-mode">
                                @if ($application->admin_notes)
                                    <div class="mt-6 p-5 bg-violet-50/50 rounded-2xl border border-violet-100">
                                        <div class="flex justify-between items-start mb-2">
                                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider">Admin Notes</p>
                                            <button type="button" onclick="toggleEditMode()" class="inline-flex items-center gap-1.5 text-violet-600 hover:text-violet-800 font-bold text-xs hover:underline">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                Edit
                                            </button>
                                        </div>
                                        <p class="text-gray-700">{{ $application->admin_notes }}</p>
                                    </div>
                                @else
                                    <button type="button" onclick="toggleEditMode()" class="inline-flex items-center gap-1.5 text-violet-600 hover:text-violet-800 font-bold text-sm hover:underline mt-6">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Add admin notes
                                    </button>
                                @endif
                            </div>

                            <!-- Edit Mode -->
                            <div id="notes-edit-mode" style="display: none;" class="mt-6">
                                <form method="POST" action="{{ route('applications.update', $application) }}" id="admin-notes-form">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- Hidden status field to preserve current status -->
                                    <input type="hidden" name="status" value="{{ $application->application_status }}">
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="admin_notes" class="block text-sm font-semibold text-gray-500 mb-2">
                                                Admin Notes
                                            </label>
                                            <textarea name="admin_notes" id="admin_notes" rows="4" class="w-full px-4 py-3 rounded-xl border-2 border-violet-100 bg-violet-50/30 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 resize-none" placeholder="Add or edit admin notes...">{{ old('admin_notes', $application->admin_notes) }}</textarea>
                                            @error('admin_notes')
                                                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="flex gap-3 justify-end">
                                            <button type="button" onclick="cancelEditMode()" class="px-4 py-2 bg-white text-gray-700 font-bold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition">
                                                Cancel
                                            </button>
                                            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-white font-bold rounded-xl border border-violet-700 hover:shadow-lg transition">
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Back Button -->
                <div class="flex gap-4">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('applications.index') }}" class="flex-1 px-6 py-3.5 bg-white text-gray-700 border-2 border-gray-300 font-bold rounded-2xl hover:bg-gray-50 transition text-center shadow-sm">
                            Back to Applications
                        </a>
                    @else
                        <a href="{{ route('applications.my-applications') }}" class="flex-1 px-6 py-3.5 bg-white text-gray-700 border-2 border-gray-300 font-bold rounded-2xl hover:bg-gray-50 transition text-center shadow-sm">
                            Back to My Applications
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleStatusSubmit(event) {
        const selected = document.querySelector('input[name="status"]:checked');
        if (selected && selected.value === 'Approved') {
            event.preventDefault();
            openApprovalModal();
            return false;
        }
        return true; // allow normal submit for other statuses
    }

    function openApprovalModal() {
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
    }

    function confirmApproval() {
        // Submit the form directly, bypassing the onsubmit guard
        document.getElementById('status-form').removeAttribute('onsubmit');
        document.getElementById('status-form').submit();
    }

    let originalNotes = document.getElementById('admin_notes') ? document.getElementById('admin_notes').value : '';
    let originalStatus = document.querySelector('input[name="status"]') ? document.querySelector('input[name="status"]:checked').value : '';

    // Initialize status highlight on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateStatusHighlight();
    });

    function toggleEditMode() {
        document.getElementById('notes-view-mode').style.display = 'none';
        document.getElementById('notes-edit-mode').style.display = 'block';
        document.getElementById('admin_notes').focus();
    }

    function cancelEditMode() {
        // Restore original content
        document.getElementById('admin_notes').value = originalNotes;
        document.getElementById('notes-edit-mode').style.display = 'none';
        document.getElementById('notes-view-mode').style.display = 'block';
    }

    function toggleStatusEditMode() {
        document.getElementById('status-view-mode').style.display = 'none';
        document.getElementById('status-edit-mode').style.display = 'block';
        updateStatusHighlight();
    }

    function cancelStatusEditMode() {
        // Restore original status selection
        document.querySelector(`input[name="status"][value="${originalStatus}"]`).checked = true;
        document.getElementById('status-edit-mode').style.display = 'none';
        document.getElementById('status-view-mode').style.display = 'block';
        updateStatusHighlight();
    }

    function updateStatusHighlight() {
        // Remove highlight from all buttons
        document.querySelectorAll('.status-button').forEach(button => {
            button.classList.remove('border-violet-600', 'bg-gradient-to-r', 'from-violet-600', 'to-fuchsia-500', 'text-white', 'shadow-lg', 'scale-105');
            button.classList.add('border-violet-200', 'bg-white', 'text-gray-700');
        });

        // Add highlight to the checked button
        const checkedRadio = document.querySelector('input[name="status"]:checked');
        if (checkedRadio) {
            const button = checkedRadio.nextElementSibling;
            button.classList.remove('border-violet-200', 'bg-white', 'text-gray-700');
            button.classList.add('border-violet-600', 'bg-gradient-to-r', 'from-violet-600', 'to-fuchsia-500', 'text-white', 'shadow-lg', 'scale-105');
        }
    }
</script>
{{-- ═══════════════════════════════════════════════════════════
     APPROVAL CONFIRMATION MODAL
═══════════════════════════════════════════════════════════ --}}
<div id="approvalModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="approvalModalTitle">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeApprovalModal()"></div>

    {{-- Modal box --}}
    <div data-modal-box
         class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-gray-100 p-8
                transform transition-all duration-200 ease-out scale-95 opacity-0">

        {{-- Icon --}}
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-200">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Title --}}
        <h2 id="approvalModalTitle" class="text-2xl font-extrabold text-gray-800 text-center mb-2">
            Approve this Application?
        </h2>
        <p class="text-center text-gray-500 text-sm mb-6">
            You are about to approve the adoption application for
            <span class="font-bold text-violet-600">{{ $application->pet->name ?? 'this pet' }}</span>
            by <span class="font-bold text-gray-700">{{ $application->adopter_name }}</span>.
        </p>

        {{-- Warning banner --}}
        <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-6">
            <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-amber-700">This action is irreversible.</p>
                <p class="text-xs text-amber-600 mt-0.5">Once approved, the status will be permanently locked and the pet will be marked as <strong>Adopted</strong>.</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3">
            <button type="button"
                    onclick="closeApprovalModal()"
                    class="flex-1 px-5 py-3 bg-white text-gray-700 font-bold rounded-2xl border-2 border-gray-200 hover:bg-gray-50 transition-all">
                Cancel
            </button>
            <button type="button"
                    onclick="confirmApproval()"
                    class="flex-1 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl shadow-lg shadow-emerald-300 hover:shadow-emerald-400 hover:-translate-y-0.5 transition-all">
                Confirm Approval
            </button>
        </div>
    </div>
</div>

</x-app-layout>
