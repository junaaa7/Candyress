<nav x-data="{ mobileOpen: false, profileOpen: false }"
     class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 transition-shadow"
     :class="{ 'shadow-sm': mobileOpen }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- ═══════════ Brand Logo (Left) ═══════════ --}}
            <div class="flex-shrink-0">
                <a href="/" class="text-2xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-accent-500">
                    Candyress.
                </a>
            </div>

            {{-- ═══════════ Desktop Navigation (Center) ═══════════ --}}
            <div class="hidden lg:flex items-center space-x-1">
                <a href="#produk"
                   class="px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-all duration-200">
                    Produk
                </a>
                <a href="#tentang"
                   class="px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-all duration-200">
                    Tentang
                </a>
                <a href="#testimoni"
                   class="px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-all duration-200">
                    Testimoni
                </a>
                <a href="#faq"
                   class="px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-all duration-200">
                    FAQ
                </a>
                <a href="#kontak"
                   class="px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-all duration-200">
                    Kontak
                </a>
            </div>

            {{-- ═══════════ Desktop Right Section ═══════════ --}}
            <div class="hidden lg:flex items-center space-x-3">
                @auth
                    {{-- Dashboard Link --}}
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-all duration-200">
                        {{-- Mini grid icon --}}
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                        Dashboard
                    </a>

                    {{-- Pesanan Link --}}
                    <a href="{{ route('customer.orders.index') }}"
                       class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-all duration-200">
                        {{-- Package icon --}}
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        Pesanan
                    </a>

                    {{-- Divider --}}
                    <div class="h-5 w-px bg-gray-200"></div>

                    {{-- Profile Dropdown --}}
                    <div class="relative" @click.outside="profileOpen = false">
                        <button @click="profileOpen = !profileOpen"
                                class="inline-flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-gray-100/80 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                                type="button">
                            {{-- Avatar --}}
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-brand-500 to-accent-500 text-white text-xs font-bold shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="text-sm font-medium text-slate-700 max-w-[120px] truncate">
                                {{ Auth::user()->name }}
                            </span>
                            {{-- Chevron --}}
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                                 :class="{ 'rotate-180': profileOpen }"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="profileOpen"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                             x-cloak
                             class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl bg-white shadow-lg ring-1 ring-black/5 divide-y divide-gray-100 focus:outline-none">

                            {{-- User Info Header --}}
                            <div class="px-4 py-3">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            {{-- Menu Items --}}
                            <div class="py-1">
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50/60 hover:text-indigo-600 transition-colors">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Profil Saya
                                </a>
                                <a href="{{ route('customer.orders.index') }}"
                                   class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50/60 hover:text-indigo-600 transition-colors">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                    Pesanan Saya
                                </a>
                            </div>

                            {{-- Logout --}}
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex w-full items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                            onclick="return confirm('Yakin ingin keluar?')">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Guest: Masuk --}}
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-all duration-200">
                        Masuk
                    </a>
                    {{-- Guest: Daftar --}}
                    <a href="{{ route('register') }}"
                       class="px-5 py-2.5 text-sm font-semibold text-white rounded-full bg-gradient-to-r from-brand-600 to-accent-500 hover:from-brand-500 hover:to-accent-600 shadow-md shadow-indigo-500/20 hover:shadow-lg hover:shadow-indigo-500/30 transition-all duration-200">
                        Daftar
                    </a>
                @endauth
            </div>

            {{-- ═══════════ Mobile Hamburger Toggle ═══════════ --}}
            <div class="lg:hidden">
                <button @click="mobileOpen = !mobileOpen"
                        class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition-colors"
                        type="button"
                        aria-label="Toggle menu">
                    {{-- Hamburger / X icon --}}
                    <svg x-show="!mobileOpen" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════════ Mobile Menu Panel ═══════════ --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         x-cloak
         class="lg:hidden border-t border-gray-100 bg-white/95 backdrop-blur-lg">
        <div class="px-4 py-4 space-y-1">
            {{-- Navigation Links --}}
            <a href="#produk" @click="mobileOpen = false"
               class="block px-3 py-2.5 text-base font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-colors">
                Produk
            </a>
            <a href="#tentang" @click="mobileOpen = false"
               class="block px-3 py-2.5 text-base font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-colors">
                Tentang
            </a>
            <a href="#testimoni" @click="mobileOpen = false"
               class="block px-3 py-2.5 text-base font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-colors">
                Testimoni
            </a>
            <a href="#faq" @click="mobileOpen = false"
               class="block px-3 py-2.5 text-base font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-colors">
                FAQ
            </a>
            <a href="#kontak" @click="mobileOpen = false"
               class="block px-3 py-2.5 text-base font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-colors">
                Kontak
            </a>
        </div>

        {{-- Auth Section --}}
        <div class="border-t border-gray-100 px-4 py-4">
            @auth
                {{-- User Info --}}
                <div class="flex items-center gap-3 px-3 py-2 mb-2">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-brand-500 to-accent-500 text-white text-sm font-bold shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <a href="{{ route('dashboard') }}" @click="mobileOpen = false"
                   class="flex items-center gap-2 px-3 py-2.5 text-base font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-colors">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('customer.orders.index') }}" @click="mobileOpen = false"
                   class="flex items-center gap-2 px-3 py-2.5 text-base font-medium text-slate-600 rounded-lg hover:text-indigo-600 hover:bg-indigo-50/60 transition-colors">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    Pesanan Saya
                </a>

                <div class="mt-2 pt-2 border-t border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-2 px-3 py-2.5 text-base font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors"
                                onclick="return confirm('Yakin ingin keluar?')">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="flex flex-col gap-2">
                    <a href="{{ route('login') }}" @click="mobileOpen = false"
                       class="block w-full text-center px-4 py-2.5 text-base font-medium text-slate-600 border border-gray-200 rounded-full hover:border-indigo-300 hover:text-indigo-600 transition-all">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" @click="mobileOpen = false"
                       class="block w-full text-center px-4 py-2.5 text-base font-semibold text-white rounded-full bg-gradient-to-r from-brand-600 to-accent-500 hover:from-brand-500 hover:to-accent-600 shadow-md shadow-indigo-500/20 transition-all">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>