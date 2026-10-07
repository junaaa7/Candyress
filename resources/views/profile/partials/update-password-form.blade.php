<section>
    <header>
        <h2 class="font-display text-lg font-semibold">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm leading-relaxed text-mauve">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mt-4" x-data="{ show: false }">
            <label for="update_password_current_password" class="block text-xs font-semibold text-gray-700 mb-1">
                Current Password
            </label>
            <div class="relative">
                <input :type="show ? 'text' : 'password'"
                       id="update_password_current_password"
                       name="current_password"
                       autocomplete="current-password"
                       class="w-full px-4 py-2.5 pr-11 text-sm rounded-xl border border-pink-100 bg-pink-50/20 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition placeholder-gray-400">
                
                <button type="button"
                        @click="show = !show"
                        tabindex="-1"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-pink-500 focus:outline-none transition">
                    <!-- Ikon Mata Tertutup -->
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Ikon Mata Terbuka / Dicoret -->
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="mt-4" x-data="{ show: false }">
            <label for="update_password_password" class="block text-xs font-semibold text-gray-700 mb-1">
                New Password
            </label>
            <div class="relative">
                <input :type="show ? 'text' : 'password'"
                       id="update_password_password"
                       name="password"
                       autocomplete="new-password"
                       class="w-full px-4 py-2.5 pr-11 text-sm rounded-xl border border-pink-100 bg-pink-50/20 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition placeholder-gray-400">
                
                <button type="button"
                        @click="show = !show"
                        tabindex="-1"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-pink-500 focus:outline-none transition">
                    <!-- Ikon Mata Tertutup -->
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Ikon Mata Terbuka / Dicoret -->
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="mt-4" x-data="{ show: false }">
            <label for="update_password_password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">
                Confirm Password
            </label>
            <div class="relative">
                <input :type="show ? 'text' : 'password'"
                       id="update_password_password_confirmation"
                       name="password_confirmation"
                       autocomplete="new-password"
                       class="w-full px-4 py-2.5 pr-11 text-sm rounded-xl border border-pink-100 bg-pink-50/20 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition placeholder-gray-400">
                
                <button type="button"
                        @click="show = !show"
                        tabindex="-1"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-pink-500 focus:outline-none transition">
                    <!-- Ikon Mata Tertutup -->
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Ikon Mata Terbuka / Dicoret -->
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="rounded-full border-2 border-emerald-200 bg-mint px-3.5 py-1 text-sm font-bold text-emerald-700"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
