<!DOCTYPE html>
<!-- Tambahkan class scroll-smooth di sini -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Candyress') - Premium Apps & Digital Accounts</title>

    <!-- Meta SEO -->
    <meta name="description" content="Temukan berbagai layanan digital premium untuk kebutuhan hiburan, produktivitas, desain, AI, dan lainnya di Candyress.">
    <meta name="theme-color" content="#FFE1EA">

    <!-- Favicon emoji permen -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍬</text></svg>">

    <!-- Tambahan: Memuat Alpine.js agar interaksi klik metode pembayaran berfungsi -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-brand-50 text-brand-900 selection:bg-brand-300 selection:text-white">

    <!-- Gambar SVG maskot & ikon (dipakai home, navbar, footer) -->
    @include('components.cute-defs')

    <!-- Navbar Component -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="min-h-screen pt-16">
        @yield('content')
    </main>

    <!-- Footer Component -->
    @include('components.footer')

    <!-- Tambahan WAJIB: Render script yang di-push dari halaman anak seperti checkout.blade.php -->
    @stack('scripts')
</body>
</html>