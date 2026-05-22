<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        {{-- Avatar + Name Row --}}
        <div class="flex items-center gap-4 mb-6 p-4 bg-gradient-to-r from-violet-50 to-fuchsia-50 rounded-2xl border border-violet-100">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-violet-200 shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-700 capitalize mt-0.5">
                    {{ Auth::user()->role }}
                </span>
            </div>
        </div>

        {{-- Name --}}
        <div class="space-y-1.5">
            <label for="name" class="block text-sm font-semibold text-gray-700">Full Name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="w-full pl-10 pr-4 py-2.5 bg-white border-2 border-violet-100 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-violet-400 focus:ring-4 focus:ring-violet-100 transition-all duration-200"
                    placeholder="Your full name"
                />
            </div>
            <x-input-error class="mt-1" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div class="space-y-1.5">
            <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="username"
                    class="w-full pl-10 pr-4 py-2.5 bg-white border-2 border-violet-100 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-violet-400 focus:ring-4 focus:ring-violet-100 transition-all duration-200"
                    placeholder="your@email.com"
                />
            </div>
            <x-input-error class="mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-amber-50 border border-amber-200 rounded-xl">
                    <p class="text-xs text-amber-700">
                        Your email is unverified.
                        <button form="send-verification" class="font-semibold underline hover:text-amber-900 transition-colors">
                            Click here to re-send the verification email.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-xs font-medium text-green-600">
                            ✓ A new verification link has been sent.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Save Button --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-violet-600 to-fuchsia-600 hover:from-violet-700 hover:to-fuchsia-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-violet-200 hover:shadow-violet-300 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="flex items-center gap-1.5 text-sm font-medium text-emerald-600"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Saved successfully!
                </p>
            @endif
        </div>
    </form>
</section>
