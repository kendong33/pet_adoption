<section>
    {{-- Warning Banner --}}
    <div class="flex gap-3 p-4 bg-red-50 border border-red-100 rounded-2xl mb-5">
        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <p class="text-sm text-red-600">
            Once your account is deleted, <span class="font-semibold">all data will be permanently removed</span> and cannot be recovered. Please download any information you wish to keep before proceeding.
        </p>
    </div>

    {{-- Trigger Button --}}
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center gap-2 px-6 py-2.5 bg-white border-2 border-red-200 text-red-600 hover:bg-red-50 hover:border-red-300 text-sm font-semibold rounded-xl transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        Delete Account
    </button>

    {{-- Confirmation Modal --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            {{-- Modal Header --}}
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900">Delete your account?</h2>
                    <p class="text-xs text-gray-500">This action cannot be undone</p>
                </div>
            </div>

            <p class="text-sm text-gray-600 mb-5">
                All of your data will be permanently removed. Please enter your password to confirm you wish to permanently delete your account.
            </p>

            {{-- Password Confirmation --}}
            <div class="space-y-1.5 mb-5">
                <label for="delete_password" class="block text-sm font-semibold text-gray-700">Your Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input
                        id="delete_password"
                        name="password"
                        type="password"
                        placeholder="Enter your password to confirm"
                        class="w-full pl-10 pr-4 py-2.5 bg-white border-2 border-red-100 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-red-300 focus:ring-4 focus:ring-red-100 transition-all duration-200"
                    />
                </div>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition-all duration-200"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl shadow-lg shadow-red-200 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Permanently Delete
                </button>
            </div>
        </form>
    </x-modal>
</section>
