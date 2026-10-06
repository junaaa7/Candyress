<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Toko Akun Premium</title>
    <meta name="theme-color" content="#FFE1EA">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍬</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative flex min-h-screen items-center justify-center bg-gradient-to-b from-brand-100/60 to-brand-50 px-4 py-8 font-sans text-brand-900">
    <!-- Gambar SVG maskot & hiasan -->
    @include('components.cute-defs')

    <!-- Hiasan latar (fixed, agar tidak memengaruhi scroll halaman) -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-cute-dots opacity-20"></div>
        <div class="absolute -left-24 -top-24 h-96 w-96 rounded-full bg-accent-100 opacity-70 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-peach opacity-80 blur-3xl"></div>
        <svg class="absolute left-[10%] top-[16%] hidden h-[3.25rem] w-[3.25rem] -rotate-12 md:block" viewBox="0 0 32 32"><use href="#cute-heart"/></svg>
        <svg class="absolute right-[11%] top-[22%] hidden h-[3.25rem] w-[3.25rem] rotate-[10deg] md:block" viewBox="0 0 32 32"><use href="#cute-sparkle"/></svg>
        <svg class="absolute bottom-[16%] left-[14%] hidden h-[3.4rem] w-[5.5rem] rotate-6 md:block" viewBox="0 0 64 40"><use href="#cute-cloud"/></svg>
        <svg class="absolute bottom-[18%] right-[16%] hidden h-[2.8rem] w-[4.25rem] -rotate-[8deg] md:block" viewBox="0 0 48 32"><use href="#cute-bow"/></svg>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <svg class="mx-auto mb-3 block h-auto w-[7.5rem] animate-float motion-reduce:animate-none" viewBox="0 0 200 140" role="img" aria-label="Maskot permen Candyress"><use href="#cute-mascot"/></svg>
        <a href="/" class="mb-5 block text-center font-display text-3xl font-bold text-brand-600"><span aria-hidden="true">🍬</span> Candyress.</a>

        <div class="cute-card p-8 shadow-[0_8px_0_theme(colors.brand.100)]">
            <div class="mb-8 text-center">
                <h1 class="text-[1.75rem] font-bold leading-tight">Selamat Datang Kembali 💕</h1>
            </div>

            <!-- Alert Box untuk Error / Akun Nonaktif -->
            @if ($errors->any())
                <div class="mb-4 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm flex items-start gap-2.5 shadow-sm">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="flex-1">
                        @foreach ($errors->all() as $error)
                            <p class="font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm flex items-center gap-2.5 shadow-sm">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-600 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('status'))
                <div class="mb-6 rounded-xl bg-brand-50 border border-brand-200 p-4 text-sm text-brand-600 font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Email atau Username -->
                <div class="mb-5">
                    <label class="cute-label" for="login">Email atau Username</label>
                    <input type="text" id="login" name="login" class="cute-input" placeholder="" required autofocus>
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label class="cute-label" for="password">Kata Sandi</label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" id="password" name="password" class="cute-input w-full pr-11" placeholder="" required>
                        <button type="button" 
                                @click="show = !show" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-brand-300 hover:text-brand-600 focus:outline-none transition-colors"
                                tabindex="-1">
                            <!-- Mata Terbuka (Tampilkan Password) -->
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Mata Dicoret (Sembunyikan Password) -->
                            <svg x-show="show" x-cloak style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="mb-6 mt-1 flex items-center justify-between gap-3">
                    <label class="flex cursor-pointer items-center gap-2">
                        <input type="checkbox" name="remember" class="h-[1.15rem] w-[1.15rem] cursor-pointer rounded border-2 border-brand-200 text-brand-300 focus:ring-brand-300">
                        <span class="text-sm text-mauve">Ingat Saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="cute-link text-sm">Lupa sandi?</a>
                    @endif
                </div>

                <!-- Syarat & Ketentuan -->
                <div class="mb-7 flex items-start gap-3">
                    <input type="checkbox" id="terms" name="terms" required class="mt-1.5 h-4 w-4 rounded border-brand-300 text-brand-500 focus:ring-brand-500">
                    <label for="terms" class="text-sm text-mauve leading-relaxed">
                        Saya menyetujui <a href="{{ route('terms.conditions') }}" target="_blank" class="cute-link font-bold underline">Syarat dan Ketentuan</a> yang berlaku di Candyress.
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="cute-btn cute-btn-primary w-full py-3.5 text-lg">
                    Masuk Sekarang
                </button>
            </form>

            <p class="mt-7 text-center text-[0.95rem] text-mauve">
                Belum punya akun? <a href="{{ route('register') }}" class="cute-link">Daftar di sini</a>
            </p>
        </div>
    </div>
</body>
</html>
