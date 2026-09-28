<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Toko Akun Premium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans text-gray-900">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md border border-gray-100 my-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold">Buat Akun Baru</h1>
            <p class="text-gray-500 mt-2 text-sm">Bergabunglah untuk mendapatkan akses akun premium termurah</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <!-- Nama -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2" for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="John Doe" required autofocus>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2" for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="nama@email.com" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2" for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="••••••••" required>
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2" for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="••••••••" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2.5 px-4 rounded-lg hover:bg-indigo-700 transition duration-300">
                Daftar Sekarang
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah memiliki akun? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold">Masuk di sini</a>
        </p>
    </div>
</body>
</html>