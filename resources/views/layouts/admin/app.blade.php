<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#FFE1EA">
    <title>@yield('title', 'Admin') - Candyress</title>

    <!-- Favicon emoji permen -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍬</text></svg>">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-brand-50 text-brand-900">
    <!-- Gambar SVG maskot & ikon -->
    @include('components.cute-defs')

    <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 border-r-2 border-dashed border-brand-100 bg-white text-brand-900 transition-transform duration-300 md:translate-x-0 md:static md:inset-0">
            <div class="flex h-16 items-center justify-center gap-2 border-b-2 border-dashed border-brand-100 bg-brand-50">
                <svg class="h-7 w-10 flex-none" viewBox="0 0 200 140" aria-hidden="true"><use href="#cute-mascot"/></svg>
                <span class="font-display text-xl font-bold text-brand-600">Candyress Admin</span>
            </div>
            <nav class="p-4 space-y-2 text-sm font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-100 font-bold text-brand-600' : 'text-mauve hover:bg-brand-50 hover:text-brand-600' }}">
                    <span>📊</span> Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('admin.products.*') ? 'bg-brand-100 font-bold text-brand-600' : 'text-mauve hover:bg-brand-50 hover:text-brand-600' }}">
                    <span>📦</span> Produk Digital
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('admin.orders.*') ? 'bg-brand-100 font-bold text-brand-600' : 'text-mauve hover:bg-brand-50 hover:text-brand-600' }}">
                    <span>🛒</span> Pesanan
                </a>
                <a href="/" target="_blank" rel="noopener" class="mt-8 flex items-center gap-3 rounded-2xl border-2 border-dashed border-brand-300 px-4 py-3 text-mauve transition hover:bg-brand-50 hover:text-brand-600">
                    <span>🌐</span> Lihat Website
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Topbar -->
            <header class="flex h-16 items-center justify-between border-b-2 border-dashed border-brand-100 bg-white/80 px-4 backdrop-blur sm:px-6">
                <button @click="sidebarOpen = !sidebarOpen" class="cute-nav-link p-2 md:hidden" aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="ml-auto flex items-center gap-4">
                    <span class="text-sm font-bold text-brand-600">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="cute-act cute-act-del">Logout</button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
