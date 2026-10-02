<nav x-data="{ mobileOpen: false, profileOpen: false }"
     class="fixed top-0 inset-x-0 z-50 border-b-2 border-dashed border-brand-100 bg-brand-50/85 text-brand-900 backdrop-blur-md transition-shadow"
     :class="{ 'shadow-sm': mobileOpen }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- ═══════════ Brand Logo (Left) ═══════════ --}}
            <div class="flex-shrink-0">
                <a href="/" class="inline-flex items-center gap-1.5 font-display text-2xl font-bold tracking-tight text-brand-600">
                    <svg class="h-7 w-10 flex-none" viewBox="0 0 200 140" aria-hidden="true"><use href="#cute-mascot"/></svg>Candyress.
                </a>
            </div>

            {{-- ═══════════ Desktop Navigation (Center) ═══════════ --}}
            @if(request()->routeIs('home') || request()->is('/'))
            <div class="hidden lg:flex items-center space-x-1">
                <a href="/#produk" class="cute-nav-link px-4 py-2 text-sm">Produk</a>
                <a href="/#tentang" class="cute-nav-link px-4 py-2 text-sm">Tentang</a>
                <a href="/#testimoni" class="cute-nav-link px-4 py-2 text-sm">Testimoni</a>
                <a href="/#faq" class="cute-nav-link px-4 py-2 text-sm">FAQ</a>
                <a href="/#kontak" class="cute-nav-link px-4 py-2 text-sm">Kontak</a>
            </div>
            @else
            <div class="hidden lg:flex items-center space-x-1"></div>
            @endif

            {{-- ═══════════ Desktop Right Section ═══════════ --}}
            <div class="hidden lg:flex items-center space-x-3">
                @auth
                    {{-- Dashboard Link --}}
                    <a href="{{ route('dashboard') }}" class="cute-nav-link inline-flex items-center gap-1.5 px-4 py-2 text-sm">
                        {{-- Mini grid icon --}}
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                        Dashboard
                    </a>

                    {{-- Pesanan Link --}}
                    <a href="{{ route('customer.orders.index') }}" class="cute-nav-link inline-flex items-center gap-1.5 px-4 py-2 text-sm">
                        {{-- Package icon --}}
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        Pesanan
                    </a>

                    {{-- Cart Link --}}
                    <a href="{{ route('cart.index') }}" class="cute-nav-link relative inline-flex items-center gap-1.5 px-4 py-2 text-sm">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        Keranjang
                        @php
                            $cartItemCount = 0;
                            if(auth()->check()) {
                                $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
                                $cartItemCount = $cart ? $cart->items()->sum('quantity') : 0;
                            }
                        @endphp
                        @if($cartItemCount > 0)
                            <span class="absolute top-1 right-2 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-brand-600 rounded-full border-2 border-white">{{ $cartItemCount }}</span>
                        @endif
                    </a>

                    {{-- Divider --}}
                    <div class="h-5 w-0 border-l-2 border-dotted border-brand-300"></div>

                    {{-- Profile Dropdown --}}
                    <div class="relative" @click.outside="profileOpen = false">
                        <button @click="profileOpen = !profileOpen"
                                class="cute-nav-link inline-flex items-center gap-2 py-1.5 pl-1.5 pr-3"
                                type="button">
                            {{-- Avatar --}}
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-gradient-to-br from-brand-300 to-brand-500 font-display text-xs font-bold text-white ring-2 ring-brand-100">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="text-sm font-bold max-w-[120px] truncate">
                                {{ Auth::user()->name }}
                            </span>
                            {{-- Chevron --}}
                            <svg class="w-4 h-4 text-brand-300 transition-transform duration-200"
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
                             class="absolute right-0 mt-3 w-56 origin-top-right overflow-hidden rounded-2xl border-2 border-brand-100 bg-white shadow-sticker focus:outline-none">

                            {{-- User Info Header --}}
                            <div class="border-b-2 border-dashed border-brand-100 bg-brand-50 px-4 py-3">
                                <p class="truncate font-display text-sm font-semibold">{{ Auth::user()->name }}</p>
                                <p class="truncate text-xs text-mauve">{{ Auth::user()->email }}</p>
                            </div>

                            {{-- Menu Items --}}
                            <div class="py-1">
                                <a href="{{ route('dashboard') }}" class="cute-menu-item">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Profil Saya
                                </a>
                                <a href="{{ route('customer.orders.index') }}" class="cute-menu-item">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                    Pesanan Saya
                                </a>
                            </div>

                            {{-- Logout --}}
                            <div class="border-t-2 border-dashed border-brand-100 py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="cute-menu-item cute-menu-danger w-full"
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
                    <a href="{{ route('login') }}" class="cute-nav-link px-5 py-2 text-sm">Masuk</a>
                    {{-- Guest: Daftar --}}
                    <a href="{{ route('register') }}" class="cute-btn cute-btn-primary px-6 py-2 text-sm">Daftar ✨</a>
                @endauth
            </div>

            {{-- ═══════════ Mobile Hamburger Toggle ═══════════ --}}
            <div class="lg:hidden">
                <button @click="mobileOpen = !mobileOpen"
                        class="cute-nav-link inline-flex items-center justify-center p-2"
                        type="button"
                        aria-label="Toggle menu"
                        :aria-expanded="mobileOpen">
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
         class="lg:hidden border-t-2 border-dashed border-brand-100 bg-brand-50/95 backdrop-blur-lg">
        @if(request()->routeIs('home') || request()->is('/'))
        <div class="px-4 py-4 space-y-1">
            {{-- Navigation Links --}}
            <a href="/#produk" @click="mobileOpen = false" class="cute-nav-link block px-4 py-2.5 text-base">Produk</a>
            <a href="/#tentang" @click="mobileOpen = false" class="cute-nav-link block px-4 py-2.5 text-base">Tentang</a>
            <a href="/#testimoni" @click="mobileOpen = false" class="cute-nav-link block px-4 py-2.5 text-base">Testimoni</a>
            <a href="/#faq" @click="mobileOpen = false" class="cute-nav-link block px-4 py-2.5 text-base">FAQ</a>
            <a href="/#kontak" @click="mobileOpen = false" class="cute-nav-link block px-4 py-2.5 text-base">Kontak</a>
        </div>
        @endif

        {{-- Auth Section --}}
        <div class="border-t-2 border-dashed border-brand-100 px-4 py-4">
            @auth
                {{-- User Info --}}
                <div class="mb-2 flex items-center gap-3 rounded-2xl bg-brand-100 px-3 py-2">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border-2 border-white bg-gradient-to-br from-brand-300 to-brand-500 font-display text-sm font-bold text-white ring-2 ring-brand-100">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate font-display text-sm font-semibold">{{ Auth::user()->name }}</p>
                        <p class="truncate text-xs text-mauve">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <a href="{{ route('dashboard') }}" @click="mobileOpen = false" class="cute-nav-link flex items-center gap-2 px-4 py-2.5 text-base">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('customer.orders.index') }}" @click="mobileOpen = false" class="cute-nav-link flex items-center gap-2 px-4 py-2.5 text-base">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    Pesanan Saya
                </a>

                <a href="{{ route('cart.index') }}" @click="mobileOpen = false" class="cute-nav-link flex items-center gap-2 px-4 py-2.5 text-base">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    Keranjang
                    @if(auth()->check())
                        @php
                            $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
                            $cartItemCount = $cart ? $cart->items()->sum('quantity') : 0;
                        @endphp
                        @if($cartItemCount > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 ml-2 text-xs font-bold text-white bg-brand-600 rounded-full">{{ $cartItemCount }}</span>
                        @endif
                    @endif
                </a>

                <div class="mt-2 border-t-2 border-dashed border-brand-100 pt-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="cute-nav-link flex w-full items-center gap-2 px-4 py-2.5 text-base text-rose-600 hover:text-rose-700"
                                onclick="return confirm('Yakin ingin keluar?')">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="flex flex-col gap-3">
                    <a href="{{ route('login') }}" @click="mobileOpen = false" class="cute-btn cute-btn-ghost w-full px-4 py-2.5 text-base">Masuk</a>
                    <a href="{{ route('register') }}" @click="mobileOpen = false" class="cute-btn cute-btn-primary w-full px-4 py-2.5 text-base">Daftar ✨</a>
                </div>
            @endauth
        </div>
    </div>
</nav>