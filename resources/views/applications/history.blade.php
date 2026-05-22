<x-app-layout>
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">
                Application History
            </h1>
            <p class="text-sm text-gray-400">Archive of all approved and declined applications</p>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 border-2 border-violet-100/80 shadow-sm mb-8">
            <form method="GET" action="{{ route('applications.history') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Status</label>
                        <select name="status" onchange="this.form.submit()" class="w-full rounded-xl border-2 border-violet-100 bg-violet-50/30 text-sm text-gray-700 focus:ring-violet-300 focus:border-violet-300 px-4 py-2.5">
                            <option value="">All Status</option>
                            <option value="Approved" {{ $application_status === 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Declined" {{ $application_status === 'Declined' ? 'selected' : '' }}>Declined</option>
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">From Date</label>
                        <input type="date" name="start_date" onchange="this.form.submit()" value="{{ $startDate }}" class="w-full rounded-xl border-2 border-violet-100 bg-violet-50/30 text-sm text-gray-700 focus:ring-violet-300 focus:border-violet-300 px-4 py-2.5">
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">To Date</label>
                        <input type="date" name="end_date" onchange="this.form.submit()" value="{{ $endDate }}" class="w-full rounded-xl border-2 border-violet-100 bg-violet-50/30 text-sm text-gray-700 focus:ring-violet-300 focus:border-violet-300 px-4 py-2.5">
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-end gap-2">
                        <a href="{{ route('applications.history') }}" class="w-full text-center bg-white text-gray-500 text-sm font-semibold px-5 py-2.5 rounded-xl border-2 border-violet-100 hover:bg-violet-50 transition">
                            Reset Filters
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Applications Grid -->
        @if ($applications->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($applications as $application)
                    <a href="{{ route('applications.show', $application) }}" class="group">
                        <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 border-2 border-violet-100 hover:border-violet-300 transition duration-300 h-full flex flex-col hover:shadow-md">
                            <!-- Header -->
                            <div class="mb-4">
                                <div class="flex items-start justify-between mb-3">
                                    <!-- Status Badge -->
                                    <span class="px-3 py-1 bg-{{ $application->getStatusColor() }}-50 text-{{ $application->getStatusColor() }}-700 border border-{{ $application->getStatusColor() }}-200 rounded-full font-bold text-xs">
                                        {{ $application->application_status }}
                                    </span>

                                    <!-- Outcome Icon -->
                                    <span class="text-2xl">
                                    </span>
                                </div>

                                <h3 class="text-xl font-extrabold text-gray-800 group-hover:text-violet-600 transition mb-1">
                                    {{ $application->pet->name }}
                                </h3>
                                <p class="text-gray-400 font-semibold text-sm">
                                    by {{ Str::limit($application->adopter_name, 20) }}
                                </p>
                            </div>

                            <!-- Details -->
                            <div class="flex-1 space-y-2 mb-4 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <span>{{ $application->pet->category->category_name ?? 'Uncategorized' }} • {{ $application->pet->breed }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span>Applied: {{ $application->application_date->format('M d, Y') }}</span>
                                </div>
                            </div>

                            <!-- Admin Notes Preview -->
                            @if ($application->admin_notes)
                                <div class="mb-4 p-3 bg-violet-50/50 rounded-lg border border-violet-100">
                                    <p class="text-xs text-violet-400 font-bold mb-1 uppercase tracking-wider">Admin Notes</p>
                                    <p class="text-gray-600 text-xs line-clamp-2">{{ $application->admin_notes }}</p>
                                </div>
                            @endif

                            <!-- Footer -->
                            <div class="text-xs text-gray-400 mt-auto pt-4 border-t border-violet-50">
                                Updated {{ $application->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($applications->hasPages())
                <div class="mt-8">
                    {{ $applications->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-16 border-2 border-violet-100 text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">No Application History</h2>
                <p class="text-gray-400">No applications found for the selected filters.</p>
            </div>
        @endif

        <!-- Back Link -->
        <div class="mt-12 text-center">
            <a href="{{ route('applications.index') }}" class="inline-flex items-center gap-2 bg-white text-violet-600 text-sm font-bold px-6 py-3 rounded-2xl border border-violet-100 shadow-sm hover:shadow-md hover:bg-violet-50 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Active Applications
            </a>
        </div>
    </div>
</div>
</x-app-layout>
