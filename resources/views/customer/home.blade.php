{{-- Asumsi Anda menggunakan layout bawaan Laravel atau komponen kustom --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">

        <!-- 1. SECTION: PROMO & BANNER UTAMA -->
        <section x-data="{ show: true }" class="relative overflow-hidden rounded-4xl bg-gradient-to-r from-brand-300 via-brand-400 to-brand-500 p-8 text-white shadow-xl shadow-brand-600/20">
            <div class="relative z-10 w-full md:w-2/3">
                <span class="rounded-full border-2 border-white bg-white/25 px-3 py-1 text-xs font-bold uppercase tracking-wider">Promo Spesial</span>
                <h2 class="mt-4 text-3xl font-bold sm:text-4xl">Diskon 20% Untuk Langganan Netflix 1 Tahun!</h2>
                <p class="mt-2 text-lg text-white/90">Gunakan kode voucher: <span class="rounded-lg bg-white/25 px-2 py-1 font-mono font-bold">CHILL20</span> saat checkout.</p>
                <button class="cute-btn cute-btn-ghost mt-6 px-6 py-3">
                    Klaim Sekarang
                </button>
            </div>
            <!-- Dekorasi Icon/Gambar Background (Opsional) -->
            <div class="absolute -top-10 -right-10 opacity-20">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
            </div>
        </section>

        <!-- 2. SECTION: KATEGORI PRODUK -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold">Kategori Layanan</h3>
            </div>
            <!-- Grid Kategori -->
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4 lg:grid-cols-6">
                {{-- Contoh Item Kategori --}}
                <a href="#" class="cute-card cute-lift flex flex-col items-center justify-center p-4">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-brand-100 text-brand-600">
                        <span class="font-bold">N</span> {{-- Ganti dengan icon/logo Netflix asli --}}
                    </div>
                    <span class="text-sm font-bold">Streaming</span>
                </a>

                <a href="#" class="cute-card cute-lift flex flex-col items-center justify-center p-4">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-accent-100 text-purple-600">
                        <span class="font-bold">C</span> {{-- Ganti dengan icon/logo Canva asli --}}
                    </div>
                    <span class="text-sm font-bold">Desain</span>
                </a>

                <a href="#" class="cute-card cute-lift flex flex-col items-center justify-center p-4">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-peach text-orange-600">
                        <span class="font-bold">AI</span> {{-- Ganti dengan icon/logo AI asli --}}
                    </div>
                    <span class="text-sm font-bold">Kecerdasan Buatan</span>
                </a>

                <a href="#" class="cute-card cute-lift flex flex-col items-center justify-center p-4">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-mint text-emerald-700">
                        <span class="font-bold">M</span> {{-- Spotify/Music --}}
                    </div>
                    <span class="text-sm font-bold">Musik</span>
                </a>
            </div>
        </section>

        <!-- 3. SECTION: PRODUK POPULER -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-semibold">🔥 Produk Populer</h3>
                <a href="#" class="cute-link text-sm">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Card Produk 1 --}}
                <div class="cute-card cute-lift overflow-hidden">
                    <div class="relative flex h-40 items-center justify-center bg-gradient-to-br from-rose-400 to-brand-600">
                        <!-- Badge -->
                        <span class="absolute top-3 right-3 rounded-full border-2 border-white bg-butter px-2.5 py-0.5 text-xs font-bold text-brand-900">Terlaris</span>
                        <h4 class="font-display text-4xl font-bold tracking-tighter text-white">NETFLIX</h4>
                    </div>
                    <div class="p-5">
                        <h5 class="mb-1 text-lg font-bold">Netflix Premium 4K</h5>
                        <p class="mb-3 text-sm text-mauve">Profil Sharing • Garansi 30 Hari</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-mauve/70 line-through">Rp 45.000</span>
                                <div class="font-display text-xl font-bold text-brand-600">Rp 35.000<span class="font-sans text-sm font-normal text-mauve">/bln</span></div>
                            </div>
                            <button class="cute-btn cute-btn-primary px-3 py-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Card Produk 2 --}}
                <div class="cute-card cute-lift overflow-hidden">
                    <div class="relative flex h-40 items-center justify-center bg-gradient-to-br from-accent-500 to-brand-300">
                        <h4 class="font-display text-3xl font-bold italic text-white">Canva Pro</h4>
                    </div>
                    <div class="p-5">
                        <h5 class="mb-1 text-lg font-bold">Canva Pro Invite Link</h5>
                        <p class="mb-3 text-sm text-mauve">Akun Pribadi • Garansi 1 Tahun</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <div class="font-display text-xl font-bold text-brand-600">Rp 20.000<span class="font-sans text-sm font-normal text-mauve">/thn</span></div>
                            </div>
                            <button class="cute-btn cute-btn-primary px-3 py-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. SECTION: PRODUK TERBARU (PREMIUM) -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-semibold">✨ Produk Terbaru</h3>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Card Produk 3 --}}
                <div class="cute-card cute-lift relative overflow-hidden">
                    <!-- Badge New -->
                    <div class="absolute top-3 left-3 z-10 rounded-full border-2 border-white bg-mint px-3 py-0.5 text-xs font-bold text-emerald-700">Baru</div>

                    <div class="flex h-40 items-center justify-center bg-gradient-to-br from-accent-100 to-brand-100">
                        <h4 class="font-display text-2xl font-bold text-brand-600">ChatGPT Plus</h4>
                    </div>
                    <div class="p-5">
                        <h5 class="mb-1 text-lg font-bold">ChatGPT Plus (GPT-4)</h5>
                        <p class="mb-3 text-sm text-mauve">Akun Sharing (Max 3 Orang) • Garansi 30 Hari</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <div class="font-display text-xl font-bold text-brand-600">Rp 85.000<span class="font-sans text-sm font-normal text-mauve">/bln</span></div>
                            </div>
                            <button class="cute-btn cute-btn-primary px-3 py-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>