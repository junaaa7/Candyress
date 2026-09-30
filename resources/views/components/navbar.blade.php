<style>

    .cute-nav {
        --c-blush: #FFF5F8;
        --c-petal: #FFE1EA;
        --c-rose: #FF9EBB;
        --c-berry: #D6477F;
        --c-cocoa: #5B3A4A;
        --c-lilac: #EBDDFB;
        font-family: 'Nunito', system-ui, sans-serif;
        color: var(--c-cocoa);
        background: rgba(255, 245, 248, 0.85);
        border-bottom: 2px dashed var(--c-petal);
    }
        .cute-logo-mascot { width: 2.5rem; height: 1.75rem; flex: none; }
    .cute-nav .cute-display { font-family: 'Fredoka', 'Nunito', sans-serif; }

    /* Links (desktop + mobile) */
    .cute-nav-link {
        color: var(--c-cocoa); border-radius: 999px; font-weight: 700;
        transition: background-color .2s ease, color .2s ease, transform .15s ease;
    }
    .cute-nav-link:hover { background: var(--c-petal); color: var(--c-berry); }

    /* Dropdown items */
    .cute-menu-item { color: var(--c-cocoa); transition: background-color .15s ease, color .15s ease; }
    .cute-menu-item:hover { background: var(--c-petal); color: var(--c-berry); }
    .cute-menu-danger { color: #E0457B; }
    .cute-menu-danger:hover { background: #FFE1EA; color: #C2255F; }

    /* Buttons */
    .cute-nav-btn {
        display: inline-flex; align-items: center; justify-content: center;
        font-family: 'Fredoka', sans-serif; font-weight: 600; border-radius: 999px;
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .cute-nav-btn:hover { transform: translateY(2px); }
    .cute-nav-btn-primary { background: var(--c-rose); color: #fff; box-shadow: 0 4px 0 var(--c-berry); }
    .cute-nav-btn-primary:hover { box-shadow: 0 2px 0 var(--c-berry); }
    .cute-nav-btn-ghost { background: #fff; color: var(--c-berry); border: 2px solid var(--c-rose); box-shadow: 0 4px 0 var(--c-petal); }
    .cute-nav-btn-ghost:hover { box-shadow: 0 2px 0 var(--c-petal); }

    .cute-avatar {
        background: linear-gradient(135deg, var(--c-rose), #E86FA0); color: #fff;
        font-family: 'Fredoka', sans-serif; border: 2px solid #fff; box-shadow: 0 0 0 2px var(--c-petal);
    }

    .cute-dropdown {
        background: #fff; border: 2px solid var(--c-petal); border-radius: 1.25rem;
        box-shadow: 0 6px 0 var(--c-petal);
    }

    .cute-nav :focus-visible { outline: 2px solid var(--c-rose); outline-offset: 2px; }
    [x-cloak] { display: none !important; }
</style>

<nav x-data="{ mobileOpen: false, profileOpen: false }"
     class="cute-nav fixed top-0 inset-x-0 z-50 backdrop-blur-md transition-shadow"
     :class="{ 'shadow-sm': mobileOpen }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- ═══════════ Brand Logo (Left) ═══════════ --}}
            <div class="flex-shrink-0">
                <a href="/" class="cute-display inline-flex items-center text-2xl font-bold tracking-tight" style="color: var(--c-berry); gap: .4rem;">
                    <svg class="cute-logo-mascot" viewBox="0 0 200 140" aria-hidden="true"><use href="#cute-mascot"/></svg>Candyress.
                </a>
            </div>

            {{-- ═══════════ Desktop Navigation (Center) ═══════════ --}}
            <div class="hidden lg:flex items-center space-x-1">
                <a href="#produk" class="cute-nav-link px-4 py-2 text-sm">Produk</a>
                <a href="#tentang" class="cute-nav-link px-4 py-2 text-sm">Tentang</a>
                <a href="#testimoni" class="cute-nav-link px-4 py-2 text-sm">Testimoni</a>
                <a href="#faq" class="cute-nav-link px-4 py-2 text-sm">FAQ</a>
                <a href="#kontak" class="cute-nav-link px-4 py-2 text-sm">Kontak</a>
            </div>

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

                    {{-- Divider --}}
                    <div class="h-5 w-0 border-l-2 border-dotted" style="border-color: var(--c-rose);"></div>

                    {{-- Profile Dropdown --}}
                    <div class="relative" @click.outside="profileOpen = false">
                        <button @click="profileOpen = !profileOpen"
                                class="cute-nav-link inline-flex items-center gap-2 pl-1.5 pr-3 py-1.5"
                                type="button">
                            {{-- Avatar --}}
                            <span class="cute-avatar inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="text-sm font-bold max-w-[120px] truncate">
                                {{ Auth::user()->name }}
                            </span>
                            {{-- Chevron --}}
                            <svg class="w-4 h-4 transition-transform duration-200" style="color: var(--c-rose);"
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
                             class="cute-dropdown absolute right-0 mt-3 w-56 origin-top-right overflow-hidden focus:outline-none">

                            {{-- User Info Header --}}
                            <div class="px-4 py-3" style="background: var(--c-blush); border-bottom: 2px dashed var(--c-petal);">
                                <p class="cute-display text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs truncate" style="color: #9C7A8A;">{{ Auth::user()->email }}</p>
                            </div>

                            {{-- Menu Items --}}
                            <div class="py-1">
                                <a href="{{ route('dashboard') }}" class="cute-menu-item flex items-center gap-2 px-4 py-2.5 text-sm font-semibold">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Profil Saya
                                </a>
                                <a href="{{ route('customer.orders.index') }}" class="cute-menu-item flex items-center gap-2 px-4 py-2.5 text-sm font-semibold">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                    </svg>
                                    Pesanan Saya
                                </a>
                            </div>

                            {{-- Logout --}}
                            <div class="py-1" style="border-top: 2px dashed var(--c-petal);">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="cute-menu-item cute-menu-danger flex w-full items-center gap-2 px-4 py-2.5 text-sm font-semibold"
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
                    <a href="{{ route('register') }}" class="cute-nav-btn cute-nav-btn-primary px-6 py-2 text-sm">Daftar ✨</a>
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
         class="lg:hidden backdrop-blur-lg"
         style="background: rgba(255, 245, 248, 0.97); border-top: 2px dashed var(--c-petal);">
        <div class="px-4 py-4 space-y-1">
            {{-- Navigation Links --}}
            <a href="#produk" @click="mobileOpen = false" class="cute-nav-link block px-4 py-2.5 text-base">Produk</a>
            <a href="#tentang" @click="mobileOpen = false" class="cute-nav-link block px-4 py-2.5 text-base">Tentang</a>
            <a href="#testimoni" @click="mobileOpen = false" class="cute-nav-link block px-4 py-2.5 text-base">Testimoni</a>
            <a href="#faq" @click="mobileOpen = false" class="cute-nav-link block px-4 py-2.5 text-base">FAQ</a>
            <a href="#kontak" @click="mobileOpen = false" class="cute-nav-link block px-4 py-2.5 text-base">Kontak</a>
        </div>

        {{-- Auth Section --}}
        <div class="px-4 py-4" style="border-top: 2px dashed var(--c-petal);">
            @auth
                {{-- User Info --}}
                <div class="flex items-center gap-3 px-3 py-2 mb-2 rounded-2xl" style="background: var(--c-petal);">
                    <span class="cute-avatar inline-flex items-center justify-center w-10 h-10 rounded-full text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="cute-display text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs truncate" style="color: #9C7A8A;">{{ Auth::user()->email }}</p>
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

                <div class="mt-2 pt-2" style="border-top: 2px dashed var(--c-petal);">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="cute-nav-link cute-menu-danger flex w-full items-center gap-2 px-4 py-2.5 text-base"
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
                    <a href="{{ route('login') }}" @click="mobileOpen = false" class="cute-nav-btn cute-nav-btn-ghost w-full px-4 py-2.5 text-base">Masuk</a>
                    <a href="{{ route('register') }}" @click="mobileOpen = false" class="cute-nav-btn cute-nav-btn-primary w-full px-4 py-2.5 text-base">Daftar ✨</a>
                </div>
            @endauth
        </div>
    </div>
</nav>