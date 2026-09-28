<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin Panel - Candyress</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts (Pastikan npm run dev berjalan) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex">
            
            <!-- Sidebar Kiri -->
            <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
                <div class="h-16 flex items-center justify-center border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">Candyress Admin</h2>
                </div>
                <div class="flex-1 px-4 py-6 overflow-y-auto">
                    <ul class="space-y-2 font-medium text-sm text-gray-700">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg bg-gray-100 text-blue-600">
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Manajemen Produk</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.premium-accounts.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.premium-accounts.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Stok Akun Premium</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-50 hover:text-blue-600">
                                <span>Pesanan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Konten Utama Kanan -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Header Atas -->
                <header class="h-16 bg-white shadow-sm border-b border-gray-200 flex items-center justify-between px-6">
                    <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                        {{ $header ?? 'Dashboard Overview' }}
                    </h2>
                    
                    <!-- Menu Logout -->
                    <div class="flex items-center">
                        <span class="text-sm text-gray-500 mr-4">Halo, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                                Logout
                            </button>
                        </form>
                    </div>
                </header>

                <!-- Area Injeksi Konten (Slot) -->
                <main class="flex-1 overflow-y-auto">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>