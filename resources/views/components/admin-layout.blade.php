<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#FFE1EA">

        <title>Admin Panel - Candyress</title>

        <!-- Favicon emoji permen -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍬</text></svg>">

        <!-- Scripts (Pastikan npm run dev berjalan). Font Nunito & Fredoka dimuat dari app.css -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-brand-50 text-brand-900" x-data="{ sidebarOpen: false }">
        <!-- Gambar SVG maskot & ikon -->
        @include('components.cute-defs')

        <div class="min-h-screen flex">
            <!-- Mobile sidebar backdrop -->
            <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-brand-900/40 lg:hidden" x-cloak @click="sidebarOpen = false" x-transition.opacity></div>

            <!-- Sidebar Kiri -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r-2 border-dashed border-brand-100 bg-white shadow-xl transition-transform duration-300 lg:static lg:translate-x-0 lg:shadow-none">
                <div class="flex h-16 items-center justify-center gap-2 border-b-2 border-dashed border-brand-100">
                    <svg class="h-7 w-10 flex-none" viewBox="0 0 200 140" aria-hidden="true"><use href="#cute-mascot"/></svg>
                    <h2 class="font-display text-xl font-bold text-brand-600">Candyress Admin</h2>
                </div>

                <!-- Container flex-col & justify-between untuk menekan tombol Logout ke bawah -->
                <div class="flex-1 px-4 py-6 overflow-y-auto flex flex-col justify-between">
                    <ul class="space-y-1 text-sm font-semibold text-brand-900">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center rounded-2xl p-3 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-100 font-bold text-brand-600' : 'hover:bg-brand-50 hover:text-brand-600' }}">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">🏠</span><span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Menu Produk (Dropdown) -->
                        <li x-data="{ open: {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="flex w-full items-center justify-between rounded-2xl p-3 transition-colors hover:bg-brand-50 hover:text-brand-600 {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.categories.*') ? 'bg-brand-100 font-bold text-brand-600' : '' }}" :aria-expanded="open">
                                <span class="flex items-center"><span class="mr-2.5 w-5 text-center" aria-hidden="true">🛍️</span><span>Produk</span></span>
                                <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <!-- Sub-menu -->
                            <ul x-show="open" x-transition class="mt-1 space-y-1">
                                <li>
                                    <a href="{{ route('admin.products.index') }}" class="flex items-center rounded-2xl p-2 pl-4 transition-colors {{ request()->routeIs('admin.products.*') ? 'font-bold text-brand-600' : 'text-mauve hover:text-brand-600' }}">
                                        <span class="mr-2 font-mono text-brand-300">├─</span> Semua Produk
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.categories.index') }}" class="flex items-center rounded-2xl p-2 pl-4 transition-colors {{ request()->routeIs('admin.categories.*') ? 'font-bold text-brand-600' : 'text-mauve hover:text-brand-600' }}">
                                        <span class="mr-2 font-mono text-brand-300">└─</span> Kategori
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('admin.stocks.index') }}" class="flex items-center rounded-2xl p-3 transition-colors {{ request()->routeIs('admin.stocks.*') ? 'bg-brand-100 font-bold text-brand-600' : 'hover:bg-brand-50 hover:text-brand-600' }}">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">🔑</span><span>Akun Premium</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center rounded-2xl p-3 transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-brand-100 font-bold text-brand-600' : 'hover:bg-brand-50 hover:text-brand-600' }}">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">🧾</span><span>Pesanan</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.payments.index') }}" class="flex items-center rounded-2xl p-3 transition-colors {{ request()->routeIs('admin.payments.*') ? 'bg-brand-100 font-bold text-brand-600' : 'hover:bg-brand-50 hover:text-brand-600' }}">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">💳</span><span>Pembayaran</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.customers.index') }}" class="flex items-center rounded-2xl p-3 transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-brand-100 font-bold text-brand-600' : 'hover:bg-brand-50 hover:text-brand-600' }}">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">👥</span><span>Customer</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.topups.index') }}" class="flex items-center rounded-2xl p-3 transition-colors {{ request()->routeIs('admin.topups.*') ? 'bg-brand-100 font-bold text-brand-600' : 'hover:bg-brand-50 hover:text-brand-600' }}">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">💰</span><span>Top Up</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.vouchers.index') }}" class="flex items-center rounded-2xl p-3 transition-colors {{ request()->routeIs('admin.vouchers.*') ? 'bg-brand-100 font-bold text-brand-600' : 'hover:bg-brand-50 hover:text-brand-600' }}">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">🎟️</span><span>Voucher & Promo</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.reviews.index') }}" class="flex items-center rounded-2xl p-3 transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-brand-100 font-bold text-brand-600' : 'hover:bg-brand-50 hover:text-brand-600' }}">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">⭐</span><span>Review</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.reports.index') }}" class="flex items-center rounded-2xl p-3 transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-brand-100 font-bold text-brand-600' : 'hover:bg-brand-50 hover:text-brand-600' }}">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">📊</span><span>Laporan</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center rounded-2xl p-3 transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-brand-100 font-bold text-brand-600' : 'hover:bg-brand-50 hover:text-brand-600' }}">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">⚙️</span><span>Pengaturan</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Sidebar Logout (Dipaksa ke bawah) -->
                    <div class="mt-6 border-t-2 border-dashed border-brand-100 pt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center rounded-2xl p-3 text-sm font-semibold text-rose-600 transition hover:bg-brand-100 hover:text-rose-700">
                                <span class="mr-2.5 w-5 text-center" aria-hidden="true">🚪</span><span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Konten Utama Kanan -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Header Atas -->
                <header class="flex h-16 items-center justify-between border-b-2 border-dashed border-brand-100 bg-white/80 px-4 md:px-6 backdrop-blur">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="mr-3 p-2 text-brand-600 hover:bg-brand-50 rounded-lg lg:hidden" aria-label="Buka menu">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </button>
                        <h2 class="font-display text-lg font-semibold leading-tight">
                            {{ $header ?? 'Dashboard Overview' }}
                        </h2>
                    </div>

                    <!-- Menu Header Logout (Bisa dibiarkan opsional atau dihapus jika sudah ada di sidebar) -->
                    <div class="flex items-center">
                        <span class="mr-4 text-sm text-mauve">Halo, <span class="font-bold text-brand-600">{{ Auth::user()->name ?? 'Admin' }}</span></span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="cute-act cute-act-del">
                                Logout
                            </button>
                        </form>
                    </div>
                </header>

                <!-- Area Injeksi Konten (Slot) -->
                <main class="flex-1 overflow-y-auto p-4 md:p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
