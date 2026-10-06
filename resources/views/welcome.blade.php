@extends('layouts.store')

@section('title', 'Home')

@section('content')
    <!-- 1. Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-b from-brand-100/60 to-brand-50">
        <div class="pointer-events-none absolute inset-0 bg-cute-dots opacity-20"></div>
        <div class="pointer-events-none absolute -top-24 -left-24 h-96 w-96 rounded-full bg-accent-100 opacity-70 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-peach opacity-80 blur-3xl"></div>

        {{-- Stiker dekorasi SVG --}}
        <svg class="pointer-events-none absolute left-[6%] top-[18%] hidden h-[3.25rem] w-[3.25rem] -rotate-12 sm:block lg:h-[4.25rem] lg:w-[4.25rem]" viewBox="0 0 32 32" aria-hidden="true"><use href="#cute-heart"/></svg>
        <svg class="pointer-events-none absolute right-[8%] top-[22%] hidden h-[3.25rem] w-[3.25rem] rotate-[10deg] sm:block lg:h-[4.25rem] lg:w-[4.25rem]" viewBox="0 0 32 32" aria-hidden="true"><use href="#cute-sparkle"/></svg>
        <svg class="pointer-events-none absolute bottom-[16%] left-[12%] hidden h-[3.4rem] w-[5.5rem] rotate-6 md:block lg:h-[4.4rem] lg:w-28" viewBox="0 0 64 40" aria-hidden="true"><use href="#cute-cloud"/></svg>
        <svg class="pointer-events-none absolute bottom-[20%] right-[14%] hidden h-[2.8rem] w-[4.25rem] -rotate-[8deg] md:block lg:h-14 lg:w-[5.25rem]" viewBox="0 0 48 32" aria-hidden="true"><use href="#cute-bow"/></svg>

        <div class="relative mx-auto max-w-7xl px-5 pb-[clamp(5rem,11vw,10rem)] pt-[clamp(4.5rem,10vw,9rem)] text-center">
            <div class="hero-in">
                <svg class="cute-mascot animate-float motion-reduce:animate-none" viewBox="0 0 200 140" role="img" aria-label="Maskot permen Candyress"><use href="#cute-mascot"/></svg>
            </div>
            <span class="hero-in cute-pill mb-7 px-5 py-2 text-[clamp(0.9rem,1.4vw,1.1rem)]" style="--hero-delay: 100ms">🍬 Toko akun digital favoritmu</span>
            <h1 class="hero-in text-[clamp(3rem,9vw,7.25rem)] font-bold leading-[1.02] tracking-tight text-brand-900" style="--hero-delay: 200ms">
                Premium Apps, <br />
                <span class="cute-underline text-brand-600">Harga Bersahabat</span> 💕
            </h1>
            <p class="hero-in mx-auto mt-7 max-w-2xl text-[clamp(1.1rem,2vw,1.45rem)] leading-relaxed text-mauve" style="--hero-delay: 320ms">
                Temukan berbagai layanan digital premium untuk hiburan, produktivitas, desain, AI, dan lainnya. Proses instan dan bergaransi.
            </p>
            <div class="hero-in mt-11 flex flex-wrap items-center justify-center gap-4" style="--hero-delay: 440ms">
                <a href="#produk" class="cute-btn cute-btn-primary px-10 py-4 text-[clamp(1.05rem,1.6vw,1.25rem)]">Jelajahi Produk</a>
                <a href="#cara-beli" class="cute-btn cute-btn-ghost px-10 py-4 text-[clamp(1.05rem,1.6vw,1.25rem)]">Cara Pembelian</a>
            </div>
        </div>

        <svg class="block h-12 w-full" viewBox="0 0 1440 48" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 24 Q 60 0 120 24 T 240 24 T 360 24 T 480 24 T 600 24 T 720 24 T 840 24 T 960 24 T 1080 24 T 1200 24 T 1320 24 T 1440 24 V48 H0 Z" fill="#fff"/>
        </svg>
    </div>



    <!-- TAMBAHAN: Section Tentang Kami (Target id="tentang") -->
    <div id="tentang" class="scroll-mt-16 bg-brand-100 py-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="reveal cute-card border-brand-300 p-8 shadow-[0_6px_0_theme(colors.brand.300)] md:p-12">
                <svg class="mx-auto mb-3 block h-16 w-16" viewBox="0 0 48 48" aria-hidden="true"><use href="#cute-ic-lollipop"/></svg>
                <h2 class="mb-5 text-3xl font-bold">Tentang Candyress</h2>
                <p class="text-lg leading-relaxed text-mauve">
                    Candyress adalah platform penyedia layanan akun digital premium yang berdedikasi untuk memberikan akses mudah, murah, dan aman ke berbagai aplikasi favorit Anda. Kami menjamin setiap transaksi diproses secara instan dan didukung oleh layanan garansi penuh.
                </p>
            </div>
        </div>
    </div>

    <!-- Section Aplikasi Premium Pilihan (Statis dengan Logo Asli) -->
    <section id="produk" class="py-16 max-w-6xl mx-auto px-4 sm:px-6 text-center">
        <!-- Badge & Heading -->
        <div class="inline-block px-4 py-1.5 rounded-full bg-pink-100 text-pink-600 text-xs font-semibold mb-3">
            🛍️ Katalog
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-2">
            Aplikasi Premium Pilihan
        </h2>
        <p class="text-sm text-gray-500 max-w-xl mx-auto mb-10">
            Koleksi lengkap layanan digital terbaik untuk menunjang produktivitas dan hiburanmu.
        </p>

        <!-- Grid Kartu Produk -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5 text-center">
            <!-- 1. Netflix -->
            <div class="group bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col items-center justify-between cursor-default select-none transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:shadow-pink-100/80 hover:border-pink-300">
                <div class="h-14 w-full flex items-center justify-center mb-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg" 
                         alt="Netflix" 
                         class="max-h-8 max-w-[110px] object-contain transition-transform duration-300 group-hover:scale-110">
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition">Netflix</h3>
                    <p class="text-xs text-gray-400 mt-1">Streaming film & series tanpa batas</p>
                </div>
            </div>

            <!-- 2. YouTube Premium -->
            <div class="group bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col items-center justify-between cursor-default select-none transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:shadow-pink-100/80 hover:border-pink-300">
                <div class="h-14 w-full flex items-center justify-center mb-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/YouTube_Logo_2017.svg" 
                         alt="YouTube Premium" 
                         class="max-h-7 max-w-[120px] object-contain transition-transform duration-300 group-hover:scale-110">
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition">YouTube Premium</h3>
                    <p class="text-xs text-gray-400 mt-1">Bebas iklan, putar di latar belakang</p>
                </div>
            </div>

            <!-- 3. ChatGPT Plus -->
            <div class="group bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col items-center justify-between cursor-default select-none transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:shadow-pink-100/80 hover:border-pink-300">
                <div class="h-14 w-full flex items-center justify-center mb-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/ChatGPT_logo.svg" 
                         alt="ChatGPT Plus" 
                         class="max-h-11 max-w-[44px] object-contain transition-transform duration-300 group-hover:scale-110">
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition">ChatGPT Plus</h3>
                    <p class="text-xs text-gray-400 mt-1">AI assistant tanpa limit</p>
                </div>
            </div>

            <!-- 4. Spotify -->
            <div class="group bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col items-center justify-between cursor-default select-none transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:shadow-pink-100/80 hover:border-pink-300">
                <div class="h-14 w-full flex items-center justify-center mb-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/26/Spotify_logo_with_text.svg" 
                         alt="Spotify" 
                         class="max-h-8 max-w-[110px] object-contain transition-transform duration-300 group-hover:scale-110">
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition">Spotify</h3>
                    <p class="text-xs text-gray-400 mt-1">Jutaan lagu bebas iklan audio jernih</p>
                </div>
            </div>

            <!-- 5. Canva Pro -->
            <div class="group bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col items-center justify-between cursor-default select-none transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:shadow-pink-100/80 hover:border-pink-300">
                <div class="h-14 w-full flex items-center justify-center mb-3">
                    <div class="transition-transform duration-300 group-hover:scale-110">
                        <svg class="h-11 w-11" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" fill="url(#canva_gradient_anim)"/>
                            <path d="M49.2 68c-11.2 0-19.2-8.4-19.2-20.2 0-13.4 9.8-23.8 22.8-23.8 7.6 0 13.2 3.8 15.6 9.8l-7.2 3.6c-1.4-3.6-4.6-5.8-8.4-5.8-7.8 0-13.4 6.8-13.4 16.2 0 7.8 5 13 12.4 13 4.2 0 7.8-2.2 9.6-6l7 3.8C65.8 64.4 60.2 68 49.2 68z" fill="white"/>
                            <defs>
                                <linearGradient id="canva_gradient_anim" x1="0" y1="0" x2="100" y2="100" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#00C4CC"/>
                                    <stop offset="1" stop-color="#7D2AE8"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition">Canva Pro</h3>
                    <p class="text-xs text-gray-400 mt-1">Desain profesional tanpa ribet</p>
                </div>
            </div>

            <!-- 6. Zoom Pro -->
            <div class="group bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col items-center justify-between cursor-default select-none transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:shadow-pink-100/80 hover:border-pink-300">
                <div class="h-14 w-full flex items-center justify-center mb-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/7b/Zoom_Communications_Logo.svg" 
                         alt="Zoom Pro" 
                         class="max-h-6 max-w-[100px] object-contain transition-transform duration-300 group-hover:scale-110">
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition">Zoom Pro</h3>
                    <p class="text-xs text-gray-400 mt-1">Meeting tanpa batas waktu</p>
                </div>
            </div>

            <!-- 7. Vidio -->
            <div class="group bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col items-center justify-between cursor-default select-none transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:shadow-pink-100/80 hover:border-pink-300">
                <div class="h-14 w-full flex items-center justify-center mb-3">
                    <img src="{{ asset('images/vidio.png') }}" 
                         alt="Vidio" 
                         class="h-11 w-11 rounded-xl object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
                         onerror="this.src='https://placehold.co/100x100/e50914/white?text=Vidio'">
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition">Vidio</h3>
                    <p class="text-xs text-gray-400 mt-1">Liga & konten lokal terlengkap</p>
                </div>
            </div>

            <!-- 8. Viu -->
            <div class="group bg-white p-6 rounded-2xl border border-pink-100 shadow-sm flex flex-col items-center justify-between cursor-default select-none transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-xl hover:shadow-pink-100/80 hover:border-pink-300">
                <div class="h-14 w-full flex items-center justify-center mb-3">
                    <div class="bg-[#F8B600] px-4 py-1.5 rounded-xl flex items-center justify-center shadow-sm transition-transform duration-300 group-hover:scale-110">
                        <span class="text-black font-black text-xl tracking-tight font-sans">viu</span>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition">Viu</h3>
                    <p class="text-xs text-gray-400 mt-1">Drama Asia favorit kamu</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Mengapa Memilih Kami & Cara Kerja (Target id="cara-beli") -->
    <div id="cara-beli" class="scroll-mt-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid items-start gap-12 md:grid-cols-2 md:gap-16">
                <!-- Kenapa Kami -->
                <div class="reveal">
                    <h2 class="mb-8 text-3xl font-bold">Mengapa Candyress? 💖</h2>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-mint">
                                <svg class="h-10 w-10 flex-none" viewBox="0 0 48 48" aria-hidden="true"><use href="#cute-ic-bolt"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Proses Otomatis & Cepat</h3>
                                <p class="mt-1 text-mauve">Akun digital dikirim secara instan setelah pembayaran terverifikasi.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl bg-accent-100">
                                <svg class="h-10 w-10 flex-none" viewBox="0 0 48 48" aria-hidden="true"><use href="#cute-ic-shield"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Full Garansi</h3>
                                <p class="mt-1 text-mauve">Jika akun bermasalah selama masa aktif, kami ganti baru tanpa ribet.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cara Pembelian -->
                <div class="reveal relative overflow-hidden rounded-4xl bg-gradient-to-br from-brand-300 to-brand-500 p-8 text-white shadow-xl shadow-brand-600/30" style="--reveal-delay: 120ms">
                    <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/20"></div>
                    <div class="pointer-events-none absolute -bottom-12 -left-8 h-32 w-32 rounded-full bg-white/10"></div>
                    <h2 class="relative z-10 mb-8 text-3xl font-bold">Cara Pembelian</h2>
                    <ul class="relative z-10 space-y-5">
                        <li class="flex items-center gap-4">
                            <span class="flex h-9 w-9 flex-none items-center justify-center rounded-full bg-white font-display text-sm font-bold text-brand-600">1</span>
                            <span class="font-bold">Pilih produk digital yang Anda inginkan.</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <span class="flex h-9 w-9 flex-none items-center justify-center rounded-full bg-white font-display text-sm font-bold text-brand-600">2</span>
                            <span class="font-bold">Lakukan checkout &amp; pembayaran via sistem.</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <span class="flex h-9 w-9 flex-none items-center justify-center rounded-full bg-white font-display text-sm font-bold text-brand-600">3</span>
                            <span class="font-bold">Dapatkan detail akun di Dashboard Anda.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- TAMBAHAN: Section Testimoni (Target id="testimoni") -->
    <div id="testimoni" class="scroll-mt-16 bg-gradient-to-b from-brand-50 to-brand-100/70 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="reveal mb-10 text-3xl font-bold">Apa Kata Mereka? 💌</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($testimonials as $testimonial)
                    @php
                        $rotation = $loop->index % 2 === 0 ? '-rotate-1' : 'rotate-1';
                        $delay = $loop->index * 120;
                    @endphp
                    <div class="reveal cute-card {{ $rotation }} p-6" style="--reveal-delay: {{ $delay }}ms">
                        <div class="mb-4 text-lg text-amber-400">
                            {{ str_repeat('★', $testimonial->rating) }}{{ str_repeat('☆', 5 - $testimonial->rating) }}
                        </div>
                        <p class="mb-4">"{{ $testimonial->comment }}"</p>
                        <p class="font-semibold text-brand-600">- {{ $testimonial->user->name ?? 'Pelanggan' }}</p>
                        @if($testimonial->product)
                            <p class="text-xs text-mauve mt-1">{{ $testimonial->product->name }}</p>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full text-center text-mauve">
                        Belum ada ulasan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 5. FAQ Section (Target id="faq") (Alpine JS) -->
    <section id="faq" class="py-16 max-w-4xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 flex items-center justify-center gap-2">
                Pertanyaan Sering Diajukan (FAQ) 🙋‍♀️
            </h2>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            @php
                $faqs = [
                    [
                        'q' => 'Berapa lama proses pengiriman akun setelah pembayaran?',
                        'a' => 'Pengiriman akun dilakukan secara otomatis dan instan setelah pembayaran terkonfirmasi. Data akun (email, password/token) beserta instruksi login langsung dapat Anda akses di halaman detail pesanan.'
                    ],
                    [
                        'q' => 'Bagaimana ketentuan dan proses klaim garansi?',
                        'a' => 'Seluruh produk bergaransi penuh selama masa aktif paket. Jika terjadi kendala login sebelum durasi habis, hubungi admin WhatsApp dengan menyertakan Nomor Pesanan Anda untuk penanganan atau penggantian akun.'
                    ],
                    [
                        'q' => 'Apakah akun yang dijual bertipe Private atau Sharing?',
                        'a' => 'Tersedia pilihan Private maupun Sharing sesuai keterangan produk. Untuk akun Sharing, Anda mendapatkan profil/PIN khusus dan dilarang mengubah password, email, atau login melebihi batas perangkat.'
                    ],
                    [
                        'q' => 'Metode pembayaran apa saja yang didukung?',
                        'a' => 'Kami mendukung pembayaran melalui Saldo Candyress untuk proses instan, serta QRIS yang dapat dipindai oleh semua aplikasi e-wallet (DANA, OVO, GoPay) dan seluruh Mobile Banking.'
                    ],
                    [
                        'q' => 'Apa yang harus dilakukan jika gagal login?',
                        'a' => 'Pastikan Anda mengikuti instruksi pada bagian Cara Login di rincian pesanan dan menyalin kredensial tanpa spasi tambahan. Jika kendala berlanjut, hubungi admin kami via WhatsApp untuk bantuan segera.'
                    ],
                ];
            @endphp

            @foreach($faqs as $index => $faq)
                <div class="bg-white border border-pink-200/80 rounded-2xl overflow-hidden shadow-sm transition">
                    <button type="button" 
                            @click="active = (active === {{ $index }} ? null : {{ $index }})" 
                            class="w-full py-4 px-6 text-left flex justify-between items-center gap-4 text-gray-800 font-medium hover:text-pink-600 transition">
                        <span class="text-sm sm:text-base">{{ $faq['q'] }}</span>
                        <span class="w-7 h-7 flex items-center justify-center rounded-full bg-pink-50 text-pink-500 font-bold text-lg flex-shrink-0 transition-transform duration-200"
                              :class="active === {{ $index }} ? 'rotate-45 bg-pink-500 text-white' : ''">
                            +
                        </span>
                    </button>
                    <div x-show="active === {{ $index }}" 
                         x-collapse 
                         x-cloak
                         class="px-6 pb-5 text-xs sm:text-sm text-gray-600 leading-relaxed border-t border-pink-50 pt-3">
                        {{ $faq['a'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Dummy div untuk target id="kontak" di paling bawah agar tidak lompat kosong -->
    <div id="kontak"></div>
@endsection