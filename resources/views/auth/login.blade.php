<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Toko Akun Premium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans text-gray-900">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold">Selamat Datang Kembali</h1>
            <p class="text-gray-500 mt-2 text-sm">Masuk untuk mulai berlangganan Netflix, Canva, & AI[cite: 1]</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <!-- Email -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2" for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="nama@email.com" required autofocus>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2" for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="••••••••" required>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Lupa sandi?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2.5 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">
                Masuk Sekarang
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-semibold">Daftar di sini</a>
        </p>
    </div>
</body>
</html>