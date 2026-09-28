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
                
                <!-- Container flex-col & justify-between untuk menekan tombol Logout ke bawah -->
                <div class="flex-1 px-4 py-6 overflow-y-auto flex flex-col justify-between">
                    <ul class="space-y-1 font-medium text-sm text-gray-700">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Menu Produk (Dropdown) -->
                        <li x-data="{ open: {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="w-full flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 hover:text-blue-600 {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') ? 'bg-gray-100 text-blue-600' : '' }}">
                                <span>Produk</span>
                                <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <!-- Sub-menu -->
                            <ul x-show="open" x-transition class="mt-1 space-y-1">
                                <li>
                                    <a href="{{ route('admin.products.index') }}" class="flex items-center p-2 pl-4 rounded-lg {{ request()->routeIs('admin.products.*') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }}">
                                        <span class="mr-2 text-gray-400 font-mono">├─</span> Semua Produk
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.categories.index') }}" class="flex items-center p-2 pl-4 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-blue-600' }}">
                                        <span class="mr-2 text-gray-400 font-mono">└─</span> Kategori
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('admin.premium-accounts.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.premium-accounts.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Akun Premium</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Pesanan</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.payments.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.payments.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Pembayaran</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.customers.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.customers.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Customer</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.vouchers.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.vouchers.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Voucher & Promo</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.reviews.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.reviews.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Review</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.reports.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Laporan</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center p-3 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-gray-100 text-blue-600' : 'hover:bg-gray-50 hover:text-blue-600' }}">
                                <span>Pengaturan</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Sidebar Logout (Dipaksa ke bawah) -->
                    <div class="border-t border-gray-200 mt-6 pt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center p-3 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-800 transition">
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Konten Utama Kanan -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Header Atas -->
                <header class="h-16 bg-white shadow-sm border-b border-gray-200 flex items-center justify-between px-6">
                    <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                        {{ $header ?? 'Dashboard Overview' }}
                    </h2>
                    
                    <!-- Menu Header Logout (Bisa dibiarkan opsional atau dihapus jika sudah ada di sidebar) -->
                    <div class="flex items-center">
                        <span class="text-sm text-gray-500 mr-4">Halo, {{ Auth::user()->name ?? 'Admin' }}</span>
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