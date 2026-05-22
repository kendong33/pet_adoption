<x-app-layout>
<div class="py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">
                Adoption Application
            </h1>
            <p class="text-sm text-gray-400">Submit your application to adopt your new companion</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Pet Preview (Left) -->
            @if ($pet)
                <div class="md:col-span-1">
                    <div class="sticky top-8 bg-white/80 backdrop-blur-xl rounded-3xl p-6 border-2 border-violet-100 shadow-xl overflow-hidden">
                        <!-- Pet Image -->
                        <div class="mb-6 rounded-2xl overflow-hidden border-2 border-violet-100 shadow-inner">
                            @if ($pet->image)
                                <img src="{{ asset('storage/' . $pet->image) }}" alt="{{ $pet->name }}" class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-violet-100/50 flex items-center justify-center">
                                </div>
                            @endif
                        </div>

                        <!-- Pet Details -->
                        <div class="space-y-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $pet->name }}</h2>
                                <div class="flex gap-2 flex-wrap">
                                    <span class="px-3 py-1 bg-violet-50 text-violet-700 border border-violet-200 rounded-full text-xs font-semibold">
                                        {{ $pet->category->category_name ?? 'Uncategorized' }}
                                    </span>
                                    <span class="px-3 py-1 bg-fuchsia-50 text-fuchsia-700 border border-fuchsia-200 rounded-full text-xs font-semibold">
                                        {{ $pet->gender }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-t border-violet-100 pt-4 space-y-3">
                                <div class="bg-violet-50/50 rounded-xl p-3 border border-violet-100">
                                    <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Breed</p>
                                    <p class="font-semibold text-gray-800">{{ $pet->breed }}</p>
                                </div>
                                <div class="bg-violet-50/50 rounded-xl p-3 border border-violet-100">
                                    <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Age</p>
                                    <p class="font-semibold text-gray-800">{{ $pet->age }} year{{ $pet->age !== 1 ? 's' : '' }}</p>
                                </div>
                                @if ($pet->health_status)
                                    <div class="bg-violet-50/50 rounded-xl p-3 border border-violet-100">
                                        <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-1">Health Status</p>
                                        <p class="font-semibold text-gray-800">{{ $pet->health_status }}</p>
                                    </div>
                                @endif
                            </div>

                            @if ($pet->description)
                                <div class="border-t border-violet-100 pt-4">
                                    <p class="text-violet-400 text-xs font-bold uppercase tracking-wider mb-2">Description</p>
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $pet->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Application Form (Right) -->
            <div class="md:col-span-{{ $pet ? '2' : '3' }} space-y-8">
                <form method="POST" action="{{ route('applications.store') }}" class="space-y-8">
                    @csrf

                    <!-- Pet Selection (if not pre-selected) -->
                    @if (!$pet)
                        <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
                                Select Pet
                            </label>
                            <select name="pet_id" required class="w-full px-4 py-3 rounded-xl border-2 border-violet-100 bg-violet-50/30 text-gray-700 focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300" onchange="location.href='{{ route('applications.create') }}?pet_id=' + this.value">
                                <option value="">-- Select a pet --</option>
                                @foreach ($pets as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->category->category_name ?? 'Uncategorized' }}, {{ $p->breed }})</option>
                                @endforeach
                            </select>
                            @error('pet_id')
                                <p class="mt-2 text-red-500 text-sm flex items-center gap-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    @else
                        <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                    @endif

                    <!-- Personal Information Section -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">
                            Personal Information
                        </h3>

                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="adopter_name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                    Full Name
                                </label>
                                <input type="text" name="adopter_name" id="adopter_name" value="{{ old('adopter_name', auth()->user()->name) }}" required class="w-full px-4 py-3 rounded-xl border-2 border-violet-100 bg-violet-50/30 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300" placeholder="Your full name">
                                @error('adopter_name')
                                    <p class="mt-2 text-red-500 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">
                            Contact Information
                        </h3>

                        <div class="space-y-6">
                            <!-- Phone -->
                            <div>
                                <label for="contact_number" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                    Phone Number
                                </label>
                                <input type="tel" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" required class="w-full px-4 py-3 rounded-xl border-2 border-violet-100 bg-violet-50/30 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300" placeholder="+1 (555) 123-4567">
                                @error('contact_number')
                                    <p class="mt-2 text-red-500 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                    Home Address
                                </label>
                                <textarea name="address" id="address" rows="3" required class="w-full px-4 py-3 rounded-xl border-2 border-violet-100 bg-violet-50/30 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 resize-none" placeholder="Your complete home address">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-2 text-red-500 text-sm">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Home Background Section -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">
                            Home Background
                        </h3>

                        <div>
                            <label for="home_background" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                                Tell us about your home
                            </label>
                            <p class="text-gray-400 text-sm mb-4">Describe your living situation, family members, other pets, yard space, etc.</p>
                            <textarea name="home_background" id="home_background" rows="5" required class="w-full px-4 py-3 rounded-xl border-2 border-violet-100 bg-violet-50/30 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300 resize-none" placeholder="We live in a comfortable house with...">{{ old('home_background') }}</textarea>
                            @error('home_background')
                                <p class="mt-2 text-red-500 text-sm">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Application Date -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 border-2 border-violet-100 shadow-xl">
                        <label for="application_date" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                            Application Date        
                        </label>
                        <input type="date" name="application_date" id="application_date" value="{{ old('application_date', today()->format('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-xl border-2 border-violet-100 bg-violet-50/30 text-gray-700 focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-300">
                        @error('application_date')
                            <p class="mt-2 text-red-500 text-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 px-8 py-4 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-black font-bold rounded-2xl border border-violet-700 hover:shadow-lg transition duration-300 text-lg cursor-pointer">
                           Submit Application
                        </button>
                        <a href="{{ $pet ? route('pets.show', $pet) : route('pets.index') }}" class="px-8 py-4 bg-white text-gray-700 font-bold rounded-2xl border-2 border-gray-300 hover:bg-gray-50 transition duration-300 text-lg text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
