<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password Field -->
        <div class="mt-4" x-data="{ show: false }">
            <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">
                Password
            </label>
            <div class="relative">
                <input :type="show ? 'text' : 'password'"
                       name="password"
                       id="password"
                       required
                       autocomplete="new-password"
                       class="w-full px-4 py-2.5 pr-11 text-sm rounded-xl border border-pink-100 bg-pink-50/20 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition placeholder-gray-400">
                
                <button type="button"
                        @click="show = !show"
                        tabindex="-1"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-pink-500 focus:outline-none transition">
                    <!-- Ikon Mata Terbuka (saat disembunyikan / text tipe password) -->
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Ikon Mata Dicoret (saat terlihat / text tipe text) -->
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password Field -->
        <div class="mt-4" x-data="{ show: false }">
            <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">
                Confirm Password
            </label>
            <div class="relative">
                <input :type="show ? 'text' : 'password'"
                       name="password_confirmation"
                       id="password_confirmation"
                       required
                       autocomplete="new-password"
                       class="w-full px-4 py-2.5 pr-11 text-sm rounded-xl border border-pink-100 bg-pink-50/20 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition placeholder-gray-400">
                
                <button type="button"
                        @click="show = !show"
                        tabindex="-1"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-pink-500 focus:outline-none transition">
                    <!-- Ikon Mata Terbuka (saat disembunyikan / text tipe password) -->
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Ikon Mata Dicoret (saat terlihat / text tipe text) -->
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
