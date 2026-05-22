<x-app-layout>
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-12">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 mb-8">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-800 mb-2">
                        My Applications
                    </h1>
                    <p class="text-sm text-gray-400">Track your adoption applications</p>
                </div>

                <a href="{{ route('pets.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-black text-sm font-semibold px-5 py-2.5 rounded-2xl shadow-md border border-violet-700 hover:shadow-lg transition">
                    Browse More Pets
                </a>
            </div>

            <!-- Filter Bar -->
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-6 border-2 border-violet-100/80 shadow-sm">
                <form method="GET" action="{{ route('applications.my-applications') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Filter by Status</label>
                        <select name="status" onchange="this.form.submit()" class="w-full rounded-xl border-2 border-violet-100 bg-violet-50/50 text-sm text-gray-700 focus:ring-violet-300 focus:border-violet-300 px-4 py-2.5">
                            <option value="">All Applications</option>
                            <option value="Pending" {{ $application_status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Interview Scheduled" {{ $application_status === 'Interview Scheduled' ? 'selected' : '' }}>Interview Scheduled</option>
                            <option value="Approved" {{ $application_status === 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Declined" {{ $application_status === 'Declined' ? 'selected' : '' }}>Declined</option>
                        </select>
                    </div>

                    <div class="w-full sm:w-auto">
                        <a href="{{ route('applications.my-applications') }}" class="block text-center bg-white text-gray-500 text-sm font-semibold px-5 py-2.5 rounded-xl border-2 border-violet-100 hover:bg-violet-50 transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Applications List -->
        @if ($applications->count() > 0)
            <div class="space-y-4">
                @foreach ($applications as $application)
                    <a href="{{ route('applications.show', $application) }}" class="block bg-white/80 backdrop-blur-xl rounded-2xl overflow-hidden border-2 border-violet-100 hover:border-violet-300 transition duration-300 group hover:shadow-md">
                        <div class="p-8">
                            <!-- Header Row -->
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
                                <div class="flex-1">
                                    <!-- Pet Name and Category -->
                                    <h3 class="text-2xl font-extrabold text-gray-800 group-hover:text-violet-600 transition mb-2">
                                        {{ $application->pet->name }}
                                    </h3>
                                    <div class="flex gap-2 flex-wrap">
                                        <span class="px-3 py-1 bg-violet-50 text-violet-700 border border-violet-200 rounded-full text-xs font-semibold">
                                            {{ $application->pet->category->category_name ?? 'Uncategorized' }}
                                        </span>
                                        <span class="px-3 py-1 bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-200 rounded-full text-xs font-semibold">
                                            {{ $application->pet->breed }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div>
                                    <span class="inline-block px-4 py-1.5 bg-{{ $application->getStatusColor() }}-50 text-{{ $application->getStatusColor() }}-700 border border-{{ $application->getStatusColor() }}-200 rounded-full font-bold text-sm">
                                        {{ $application->application_status }}
                                    </span>
                                </div>
                            </div>

                            <!-- Application Details Grid -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-6 border-t border-violet-100">
                                <div>
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Applied On</p>
                                    <p class="text-gray-800 font-semibold">{{ $application->application_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Pet Age</p>
                                    <p class="text-gray-800 font-semibold">{{ $application->pet->age }} year{{ $application->pet->age !== 1 ? 's' : '' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Days Pending</p>
                                    <p class="text-gray-800 font-semibold">{{ $application->application_date->diffInDays(now()) }} days</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Last Updated</p>
                                    <p class="text-gray-800 font-semibold">{{ $application->updated_at->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <!-- Admin Notes (if available) -->
                            @if ($application->admin_notes)
                                <div class="mt-6 p-4 bg-violet-50/50 rounded-xl border-2 border-violet-100">
                                    <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-2">Admin Notes</p>
                                    <p class="text-gray-700 text-sm">{{ Str::limit($application->admin_notes, 150) }}</p>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach

                <!-- Pagination -->
                @if ($applications->hasPages())
                    <div class="mt-8">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white/70 backdrop-blur-sm rounded-3xl p-16 border-2 border-violet-100 text-center">
                <p class="text-5xl mb-6">🐾</p>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">No Applications Yet</h2>
                <p class="text-gray-400 mb-8">You haven't submitted any adoption applications yet.</p>
                <a href="{{ route('pets.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-black text-sm font-semibold px-6 py-3.5 rounded-2xl shadow-md border border-violet-700 hover:shadow-lg transition">
                    Browse Available Pets
                </a>
            </div>
        @endif
    </div>
</div>
</x-app-layout>
