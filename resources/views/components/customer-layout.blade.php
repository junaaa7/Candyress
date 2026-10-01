<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#FFE1EA">
        <title>{{ $title ?? 'Dashboard' }} - Candyress</title>

        <!-- Favicon emoji permen -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍬</text></svg>">

        <!-- Font Nunito & Fredoka dimuat dari app.css -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-brand-50 text-brand-900" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex">

            <!-- Mobile sidebar backdrop -->
            <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-brand-900/40 lg:hidden" @click="sidebarOpen = false" x-transition.opacity></div>

            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col border-r-2 border-dashed border-brand-300/60 bg-gradient-to-b from-brand-100 to-brand-50 text-brand-900 shadow-xl shadow-brand-600/10 transition-transform duration-300 lg:static lg:translate-x-0 lg:shadow-none">
                <!-- User Profile Info -->
                <div class="flex flex-col items-center border-b-2 border-dashed border-brand-300/60 p-6">
                    <div class="mb-3 flex h-16 w-16 items-center justify-center rounded-full border-2 border-white bg-gradient-to-br from-brand-300 to-brand-500 font-display text-2xl font-bold text-white ring-4 ring-brand-100">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="w-full truncate text-center font-display text-lg font-semibold">{{ Auth::user()->name ?? 'User' }}</div>
                    <div class="w-full truncate text-center text-sm text-mauve">{{ Auth::user()->email ?? '' }}</div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('dashboard') ? 'bg-white font-bold text-brand-600 shadow-sticker-sm' : 'hover:bg-white/70 hover:text-brand-600' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <!-- Katalog Produk -->
                    <a href="{{ route('customer.products.index') }}" class="flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('customer.products.*') ? 'bg-white font-bold text-brand-600 shadow-sticker-sm' : 'hover:bg-white/70 hover:text-brand-600' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        Katalog Produk
                    </a>

                    <!-- Saldo & Top-Up -->
                    <a href="{{ route('customer.topup.index') }}" class="flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('customer.topup.*') ? 'bg-white font-bold text-brand-600 shadow-sticker-sm' : 'hover:bg-white/70 hover:text-brand-600' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                        </svg>
                        Saldo & Top-Up
                    </a>

                    <!-- Pesanan Saya -->
                    <a href="{{ route('customer.orders.index') }}" class="flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('customer.orders.*') ? 'bg-white font-bold text-brand-600 shadow-sticker-sm' : 'hover:bg-white/70 hover:text-brand-600' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Pesanan Saya
                    </a>

                    <!-- Upload Pembayaran -->
                    <a href="{{ route('customer.payments.index') }}" class="flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('customer.payments.*') ? 'bg-white font-bold text-brand-600 shadow-sticker-sm' : 'hover:bg-white/70 hover:text-brand-600' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Upload Pembayaran
                    </a>

                    <!-- Ulasan Saya -->
                    <a href="{{ route('customer.reviews.index') }}" class="flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('customer.reviews.*') ? 'bg-white font-bold text-brand-600 shadow-sticker-sm' : 'hover:bg-white/70 hover:text-brand-600' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Ulasan Saya
                    </a>

                    <!-- Profil Saya -->
                    <a href="{{ route('customer.profile') }}" class="flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('customer.profile') ? 'bg-white font-bold text-brand-600 shadow-sticker-sm' : 'hover:bg-white/70 hover:text-brand-600' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil Saya
                    </a>

                    <hr class="my-4 border-0 border-t-2 border-dashed border-brand-300">

                    <!-- Back to Store -->
                    <a href="{{ route('home') }}" class="flex items-center rounded-2xl px-4 py-3 text-sm font-semibold transition-colors hover:bg-white/70 hover:text-brand-600">
                        <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Toko
                    </a>
                </nav>

                <!-- Sidebar Footer / Logout -->
                <div class="border-t-2 border-dashed border-brand-300/60 p-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center rounded-2xl px-4 py-3 text-sm font-semibold text-rose-600 transition-colors hover:bg-white hover:text-rose-700">
                            <svg class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0 bg-brand-50">
                <!-- Header -->
                <header class="sticky top-0 z-10 flex h-16 items-center justify-between border-b-2 border-dashed border-brand-100 bg-white/80 px-4 backdrop-blur lg:px-6">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="cute-nav-link mr-3 p-2 lg:hidden" aria-label="Buka menu">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h2 class="font-display text-lg font-semibold">{{ $header ?? 'Dashboard' }}</h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') ?? '/' }}" class="cute-nav-link relative p-2">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </a>
                        <div class="hidden h-6 w-0 border-l-2 border-dotted border-brand-300 sm:block"></div>
                        <span class="hidden text-sm text-mauve sm:block">Halo, <span class="font-bold text-brand-600">{{ Auth::user()->name ?? 'User' }}</span></span>

                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="cute-act cute-act-del">Logout</button>
                        </form>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>