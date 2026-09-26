<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Candyress') - Premium Apps & Digital Accounts</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Temukan berbagai layanan digital premium untuk kebutuhan hiburan, produktivitas, desain, AI, dan lainnya di Candyress.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-brand-900 selection:bg-brand-500 selection:text-white">
    
    <!-- Navbar Component -->
    @include('components.navbar')

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer Component -->
    @include('components.footer')

</body>
</html>