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

        {{-- Maskot floating di samping (absolute) --}}
        <div class="pointer-events-none absolute right-[2%] lg:right-[8%] top-[55%] -translate-y-1/2 hidden md:block opacity-90 transition-transform hover:scale-105 duration-300">
            <svg class="cute-mascot animate-float motion-reduce:animate-none w-48 lg:w-64 h-auto drop-shadow-md" viewBox="0 0 200 140" role="img" aria-label="Maskot permen Candyress"><use href="#cute-mascot"/></svg>
        </div>

        <div class="relative mx-auto max-w-4xl px-5 pb-[clamp(5rem,11vw,10rem)] pt-[clamp(4.5rem,10vw,9rem)] text-center flex flex-col items-center">
            <span class="hero-in cute-pill mb-7 px-5 py-2 text-[clamp(0.9rem,1.4vw,1.1rem)] shadow-sm" style="--hero-delay: 100ms">🍬 Toko akun digital favoritmu</span>
            
            <h1 class="hero-in text-[clamp(3rem,9vw,7.25rem)] font-bold leading-[1.02] tracking-tight text-brand-900 mb-6" style="--hero-delay: 200ms">
                Premium Apps, <br />
                <span class="cute-underline text-brand-600">Harga Bersahabat</span> 💕
            </h1>
            
            <p class="hero-in text-base sm:text-lg lg:text-[clamp(1.1rem,2vw,1.45rem)] text-mauve max-w-2xl mx-auto leading-relaxed mb-8" style="--hero-delay: 320ms">
                Temukan berbagai layanan digital premium untuk hiburan, produktivitas, desain, AI, dan lainnya. Proses instan dan bergaransi.
            </p>
            
            <div class="hero-in flex flex-wrap items-center justify-center gap-4" style="--hero-delay: 440ms">
                <a href="#produk" class="cute-btn cute-btn-primary px-10 py-4 text-[clamp(1.05rem,1.6vw,1.25rem)] hover:-translate-y-0.5 transition-all duration-200">Jelajahi Produk</a>
                <a href="#cara-beli" class="cute-btn cute-btn-ghost px-10 py-4 text-[clamp(1.05rem,1.6vw,1.25rem)] hover:-translate-y-0.5 transition-all duration-200">Cara Pembelian</a>
            </div>
        </div>

        <svg class="block h-12 w-full" viewBox="0 0 1440 48" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 24 Q 60 0 120 24 T 240 24 T 360 24 T 480 24 T 600 24 T 720 24 T 840 24 T 960 24 T 1080 24 T 1200 24 T 1320 24 T 1440 24 V48 H0 Z" fill="#fff"/>
        </svg>
    </div>

    <!-- 2. Katalog Section (Target id="produk" dipindahkan ke sini) -->
    <div id="produk" class="scroll-mt-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="reveal text-center mb-10">
                <h2 class="text-3xl font-bold">Katalog</h2>
                <p class="mt-2 text-mauve">Pilih yang paling kamu suka</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @php
                    $categories = [
                        ['name' => 'Streaming', 'icon' => 'cute-ic-streaming', 'bg' => 'bg-brand-100'],
                        ['name' => 'AI Tools', 'icon' => 'cute-ic-ai', 'bg' => 'bg-accent-100'],
                        ['name' => 'Design', 'icon' => 'cute-ic-design', 'bg' => 'bg-peach'],
                        ['name' => 'Productivity', 'icon' => 'cute-ic-productivity', 'bg' => 'bg-mint'],
                    ];
                @endphp
                @foreach($categories as $cat)
                    <a href="#" class="reveal cute-card cute-lift group p-6 text-center" style="--reveal-delay: {{ $loop->index * 90 }}ms">
                        <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-full transition-transform group-hover:scale-110 {{ $cat['bg'] }}">
                            <svg class="h-10 w-10 flex-none" viewBox="0 0 48 48" aria-hidden="true"><use href="#{{ $cat['icon'] }}"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold">{{ $cat['name'] }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Section Tentang Kami (Target id="tentang") -->
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

    <!-- 3. Mengapa Memilih Kami & Cara Kerja (Target id="cara-beli") -->
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

    <!-- Section Testimoni (Target id="testimoni") -->
    <div id="testimoni" class="scroll-mt-16 bg-gradient-to-b from-brand-50 to-brand-100/70 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="reveal mb-10 text-3xl font-bold">Apa Kata Mereka? 💌</h2>
            @if(isset($reviews) && $reviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($reviews as $review)
                        @php
                            $rotation = $loop->iteration % 2 === 0 ? 'rotate-1' : '-rotate-1';
                            $delay = ($loop->iteration - 1) * 120;
                        @endphp
                        <div class="reveal cute-card {{ $rotation }} p-6" style="--reveal-delay: {{ $delay }}ms">
                            <div class="mb-4 text-lg text-amber-400">
                                {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                            </div>
                            <p class="mb-4">"{{ $review->comment ?? 'Pelayanan sangat memuaskan!' }}"</p>
                            <p class="font-semibold text-brand-600">- {{ explode(' ', $review->user->name)[0] }}</p>
                            @if($review->product)
                                <p class="text-xs text-mauve mt-1">{{ $review->product->name }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Dummy Testimoni 1 -->
                    <div class="reveal cute-card -rotate-1 p-6">
                        <div class="mb-4 text-lg text-amber-400">★★★★★</div>
                        <p class="mb-4">"Akun Netflix mendarat dengan aman, prosesnya cepat banget. Recommended!"</p>
                        <p class="font-semibold text-brand-600">- Budi S.</p>
                    </div>
                    <!-- Dummy Testimoni 2 -->
                    <div class="reveal cute-card rotate-1 p-6" style="--reveal-delay: 120ms">
                        <div class="mb-4 text-lg text-amber-400">★★★★★</div>
                        <p class="mb-4">"Langganan Canva Pro di sini harganya miring, garansinya beneran aktif."</p>
                        <p class="font-semibold text-brand-600">- Rina M.</p>
                    </div>
                    <!-- Dummy Testimoni 3 -->
                    <div class="reveal cute-card -rotate-1 p-6" style="--reveal-delay: 240ms">
                        <div class="mb-4 text-lg text-amber-400">★★★★★</div>
                        <p class="mb-4">"Adminnya fast response, sangat terbantu waktu ada kendala di awal. Mantap Candyress."</p>
                        <p class="font-semibold text-brand-600">- Andi P.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- 4. FAQ Section (Target id="faq") (Alpine JS) -->
    <div id="faq" class="scroll-mt-16 bg-white py-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="reveal mb-10 text-center text-3xl font-bold">Pertanyaan Sering Diajukan (FAQ) 🙋‍♀️</h2>
            <div x-data="{ active: null }" class="space-y-4">
                @php
                    $faqs = [
                        [
                            'q' => 'Berapa lama proses pengiriman akun setelah pembayaran?',
                            'a' => 'Pengiriman akun dilakukan secara otomatis dan instan detik itu juga setelah pembayaran berhasil. Detail akun (email, password/token) serta panduan login akan langsung tampil pada invoice pesanan Anda.'
                        ],
                        [
                            'q' => 'Bagaimana sistem garansi jika akun bermasalah?',
                            'a' => 'Semua akun bergaransi penuh sesuai durasi paket yang dibeli. Jika terjadi kendala sebelum masa aktif habis, silakan hubungi admin via WhatsApp dengan menyertakan Nomor Pesanan untuk perbaikan atau pergantian akun.'
                        ],
                        [
                            'q' => 'Apakah akun yang dijual bersifat Private atau Sharing?',
                            'a' => 'Kami menyediakan pilihan akun Private maupun Sharing sesuai keterangan pada kartu produk. Untuk akun Sharing, pembeli mendapatkan profil dan PIN khusus serta dilarang mengubah data akun atau login melebihi batas perangkat.'
                        ],
                        [
                            'q' => 'Metode pembayaran apa saja yang tersedia?',
                            'a' => 'Kami mendukung pembayaran menggunakan Saldo Candyress untuk checkout instan, serta QRIS yang dapat di-scan dari seluruh mobile banking dan e-wallet (GoPay, OVO, DANA, dll).'
                        ],
                        [
                            'q' => 'Apa yang harus dilakukan jika gagal login?',
                            'a' => 'Pastikan mengikuti langkah-langkah pada instruksi \'Cara Login\' di halaman pesanan. Jika masih mengalami kendala, klik menu Kontak / WhatsApp admin untuk mendapatkan bantuan langsung.'
                        ]
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                    <div class="reveal cute-card overflow-hidden rounded-3xl shadow-sticker-sm" style="--reveal-delay: {{ $index * 60 }}ms">
                        <button @click="active === {{ $index }} ? active = null : active = {{ $index }}" class="flex w-full items-center justify-between px-4 py-3.5 sm:px-6 sm:py-4 text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-brand-300" :aria-expanded="active === {{ $index }}">
                            <span class="font-semibold">{{ $faq['q'] }}</span>
                            <span x-text="active === {{ $index }} ? '−' : '+'" class="ml-3 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-brand-100 text-xl text-brand-600 transition-colors duration-300" :class="active === {{ $index }} ? 'bg-brand-200' : 'bg-brand-100'"></span>
                        </button>
                        <div x-show="active === {{ $index }}" x-collapse x-cloak class="px-6 pb-4 text-mauve">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Dummy div untuk target id="kontak" di paling bawah agar tidak lompat kosong -->
    <div id="kontak"></div>
@endsection
