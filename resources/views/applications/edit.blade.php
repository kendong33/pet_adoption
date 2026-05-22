<x-app-layout>
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">
                Manage Application
            </h1>
            <p class="text-sm text-gray-400">
                Application for <span class="text-violet-600 font-semibold">{{ $application->pet->name }}</span> by
                <span class="text-fuchsia-600 font-semibold">{{ $application->adopter_name }}</span>
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Pet & Adopter Info (Sidebar) -->
            <div class="md:col-span-1">
                <!-- Pet Card -->
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-6 border-2 border-violet-100 shadow-xl mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Pet Information</h3>

                    <div class="mb-6 rounded-2xl overflow-hidden border-2 border-violet-100 shadow-inner">
                        @if ($application->pet->image)
                            <img src="{{ asset('storage/' . $application->pet->image) }}" alt="{{ $application->pet->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-violet-100/50 flex items-center justify-center">
                            </div>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <div class="bg-violet-50/50 rounded-xl p-3 border border-violet-100">
                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Name</p>
                            <p class="text-gray-800 font-semibold">{{ $application->pet->name }}</p>
                        </div>
                        <div class="bg-violet-50/50 rounded-xl p-3 border border-violet-100">
                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Category</p>
                            <p class="text-gray-800 font-semibold">{{ $application->pet->category->category_name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="bg-violet-50/50 rounded-xl p-3 border border-violet-100">
                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Breed</p>
                            <p class="text-gray-800 font-semibold">{{ $application->pet->breed }}</p>
                        </div>
                    </div>
                </div>

                <!-- Adopter Card -->
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-6 border-2 border-violet-100 shadow-xl">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Adopter Information</h3>

                    <div class="space-y-3">
                        <div class="bg-violet-50/50 rounded-xl p-3 border border-violet-100">
                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Name</p>
                            <p class="text-gray-800 font-semibold">{{ $application->adopter_name }}</p>
                        </div>

                        <div class="bg-violet-50/50 rounded-xl p-3 border border-violet-100">
                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Phone</p>
                            <p class="text-gray-800 font-semibold">{{ $application->contact_number }}</p>
                        </div>
                        <div class="bg-violet-50/50 rounded-xl p-3 border border-violet-100">
                            <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Applied On</p>
                            <p class="text-gray-800 font-semibold">{{ $application->application_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Form (Main) -->
            <div class="md:col-span-2">
                <form method="POST" action="{{ route('applications.update', $application) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Current Status -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">
                            Application Status
                        </h3>

                        <div class="mb-6">
                            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Current Status</p>
                            <div class="inline-block px-5 py-2.5 bg-{{ $application->getStatusColor() }}-50 text-{{ $application->getStatusColor() }}-700 border border-{{ $application->getStatusColor() }}-200 rounded-full font-bold text-sm">
                                {{ $application->application_status }}
                            </div>
                        </div>

                        <div>
                            <label for="status" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                                Update Status
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach (['Pending', 'Interview Scheduled', 'Approved', 'Declined'] as $status)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="status" value="{{ $status }}" {{ $application->application_status === $status ? 'checked' : '' }} required class="sr-only peer">
                                        <div class="px-4 py-3 rounded-xl border-2 border-violet-100 bg-violet-50/30 text-gray-700 font-semibold text-center transition peer-checked:border-violet-600 peer-checked:bg-violet-50 peer-checked:text-violet-700">
                                            {{ $status }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('status')
                                <p class="mt-2 text-red-500 text-sm"> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">
                            Admin Notes
                        </h3>

                        <label for="admin_notes" class="block text-sm font-semibold text-gray-500 mb-3">
                            Add notes or feedback for this application
                        </label>
                        <textarea name="admin_notes" id="admin_notes" rows="6" class="w-full px-4 py-3 rounded-xl border-2 border-violet-100 bg-violet-50/30 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 resize-none" placeholder="Document your decision, concerns, or follow-up items...">{{ old('admin_notes', $application->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <p class="mt-2 text-red-500 text-sm"> {{ $message }}</p>
                        @enderror

                        @if ($application->admin_notes && !$errors->has('admin_notes'))
                            <p class="text-gray-400 text-xs mt-2 font-medium">Last updated: {{ $application->updated_at->format('M d, Y g:i A') }}</p>
                        @endif
                    </div>

                    <!-- Application Details Preview -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">
                            Home Background
                        </h3>
                        <div class="bg-violet-50/50 rounded-2xl p-5 border border-violet-100 text-gray-700 leading-relaxed whitespace-pre-wrap text-sm">{{ $application->home_background }}</div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 px-8 py-4 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-black font-bold rounded-2xl border border-violet-700 hover:shadow-lg transition duration-300 text-lg cursor-pointer">
                            Save Changes
                        </button>
                        <a href="{{ route('applications.show', $application) }}" class="px-8 py-4 bg-white text-gray-700 font-bold rounded-2xl border-2 border-gray-300 hover:bg-gray-50 transition duration-300 text-lg text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
