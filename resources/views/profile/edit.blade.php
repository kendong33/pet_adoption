<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center gap-4 mb-2">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center shadow-lg shadow-violet-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Account Settings</h1>
                <p class="text-sm text-violet-500 font-medium">Manage your profile, password & account</p>
            </div>
        </div>

        {{-- Profile Information Card --}}
        <div class="bg-white/70 backdrop-blur-xl border border-violet-100 rounded-3xl shadow-lg shadow-violet-100/30 overflow-hidden">
            <div class="px-6 py-4 border-b border-violet-100 flex items-center gap-3 bg-gradient-to-r from-violet-50/80 to-fuchsia-50/50">
                <div class="w-8 h-8 rounded-xl bg-violet-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-800">Profile Information</h2>
                    <p class="text-xs text-gray-500">Update your name and email address</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password Card --}}
        <div class="bg-white/70 backdrop-blur-xl border border-violet-100 rounded-3xl shadow-lg shadow-violet-100/30 overflow-hidden">
            <div class="px-6 py-4 border-b border-violet-100 flex items-center gap-3 bg-gradient-to-r from-violet-50/80 to-fuchsia-50/50">
                <div class="w-8 h-8 rounded-xl bg-violet-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-800">Update Password</h2>
                    <p class="text-xs text-gray-500">Use a long, random password to stay secure</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account Card --}}
        <div class="bg-white/70 backdrop-blur-xl border border-red-100 rounded-3xl shadow-lg shadow-red-100/20 overflow-hidden">
            <div class="px-6 py-4 border-b border-red-100 flex items-center gap-3 bg-gradient-to-r from-red-50/80 to-rose-50/50">
                <div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-red-700">Danger Zone</h2>
                    <p class="text-xs text-red-400">Irreversible and destructive actions</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-app-layout>
