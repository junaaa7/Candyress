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
                <p class="mt-2.5 text-[0.95rem] text-mauve">Masuk untuk mulai berlangganan Netflix, Canva, &amp; AI</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Email -->
                <div class="mb-5">
                    <label class="cute-label" for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="cute-input" placeholder="nama@email.com" required autofocus>
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label class="cute-label" for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="cute-input" placeholder="••••••••" required>
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