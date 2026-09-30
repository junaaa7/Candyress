@extends('layouts.store')

@section('title', 'Home')

@section('content')
    <style>

        :root {
            --c-blush: #FFF5F8;
            --c-petal: #FFE1EA;
            --c-rose: #FF9EBB;
            --c-berry: #D6477F;
            --c-cocoa: #5B3A4A;
            --c-lilac: #EBDDFB;
            --c-peach: #FFE6D6;
        }

        .cute-page { font-family: 'Nunito', system-ui, sans-serif; color: var(--c-cocoa); background: var(--c-blush); }
        .cute-page h1, .cute-page h2, .cute-page h3, .cute-display { font-family: 'Fredoka', 'Nunito', sans-serif; letter-spacing: 0.005em; }
        .cute-muted { color: #9C7A8A; }

        /* Sticker-style cards: soft pink outline + offset shadow */
        .cute-card {
            background: #fff;
            border: 2px solid var(--c-petal);
            border-radius: 1.75rem;
            box-shadow: 0 6px 0 var(--c-petal);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }
        .cute-card:hover { transform: translateY(-4px); border-color: var(--c-rose); box-shadow: 0 10px 0 var(--c-petal); }

        .cute-pill {
            display: inline-block; padding: .3rem .9rem; border-radius: 999px;
            background: var(--c-petal); color: var(--c-berry);
            font-weight: 700; font-size: .8rem; border: 2px dashed var(--c-rose);
        }

        .cute-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
            padding: .85rem 2rem; border-radius: 999px; font-family: 'Fredoka', sans-serif; font-weight: 600;
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .cute-btn:hover { transform: translateY(2px); }
        .cute-btn-primary { background: var(--c-rose); color: #fff; box-shadow: 0 5px 0 var(--c-berry); }
        .cute-btn-primary:hover { box-shadow: 0 3px 0 var(--c-berry); }
        .cute-btn-ghost { background: #fff; color: var(--c-berry); border: 2px solid var(--c-rose); box-shadow: 0 5px 0 var(--c-petal); }
        .cute-btn-ghost:hover { box-shadow: 0 3px 0 var(--c-petal); }

        .cute-title-underline {
            background-image: linear-gradient(transparent 62%, var(--c-petal) 62%);
            padding: 0 .25rem;
        }

        .cute-dots {
            background-image: radial-gradient(var(--c-rose) 1.4px, transparent 1.4px);
            background-size: 22px 22px; opacity: .22;
        }

        /* Hero stickers: the single animated moment on the page */
        .cute-float { animation: cute-float 5s ease-in-out infinite; }
        .cute-float.d2 { animation-delay: -1.6s; }
        .cute-float.d3 { animation-delay: -3.2s; }
        @keyframes cute-float { 0%,100% { transform: translateY(0) rotate(var(--r, 0deg)); } 50% { transform: translateY(-12px) rotate(var(--r, 0deg)); } }
        @media (prefers-reduced-motion: reduce) { .cute-float { animation: none; } }

        .cute-wave { display: block; width: 100%; height: 48px; }

        /* Cara Pembelian card (plain CSS so it never depends on Tailwind's compiled classes) */
        .cute-steps { position: relative; overflow: hidden; border-radius: 2rem; padding: 2rem; color: #fff;
            background: linear-gradient(145deg, #FF9EBB, #E86FA0); box-shadow: 0 18px 36px -14px rgba(214, 71, 127, .45); }
        .cute-steps-bubble-a { position: absolute; top: -2.5rem; right: -2.5rem; width: 10rem; height: 10rem; border-radius: 999px; background: rgba(255,255,255,.2); pointer-events: none; }
        .cute-steps-bubble-b { position: absolute; bottom: -3rem; left: -2rem; width: 8rem; height: 8rem; border-radius: 999px; background: rgba(255,255,255,.12); pointer-events: none; }
        .cute-steps-title { position: relative; z-index: 1; font-size: 1.875rem; font-weight: 700; margin-bottom: 2rem; }
        .cute-steps-list { position: relative; z-index: 1; list-style: none; margin: 0; padding: 0; }
        .cute-step { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem; }
        .cute-step:last-child { margin-bottom: 0; }
        .cute-step-num { flex: none; width: 2.25rem; height: 2.25rem; border-radius: 999px; background: #fff; color: var(--c-berry);
            display: flex; align-items: center; justify-content: center; font-family: 'Fredoka', sans-serif; font-weight: 700; font-size: .9rem; }
        .cute-step-text { font-weight: 700; }

        /* Hero sticker positions */
        .cute-s1 { position: absolute; left: 6%; top: 18%; }
        .cute-s2 { position: absolute; right: 8%; top: 22%; }
        .cute-s3 { position: absolute; left: 12%; bottom: 16%; }
        .cute-s4 { position: absolute; right: 14%; bottom: 20%; }

        /* Hover / focus helpers */
        .cute-card:hover .cute-product-name { color: var(--c-berry); }
        .cute-faq-btn:focus-visible { outline: 2px solid var(--c-rose); outline-offset: -2px; }

        /* Hero: big, bold first impression */
        .cute-hero-inner { position: relative; max-width: 80rem; margin: 0 auto; text-align: center;
            padding: clamp(4.5rem, 10vw, 9rem) 1.25rem clamp(5rem, 11vw, 10rem); }
        .cute-hero-pill { font-size: clamp(.9rem, 1.4vw, 1.1rem); padding: .5rem 1.4rem; margin-bottom: 1.75rem; }
        .cute-hero-title { font-size: clamp(3rem, 9vw, 7.25rem); font-weight: 700; line-height: 1.02;
            letter-spacing: -0.01em; color: var(--c-cocoa); margin: 0; }
        .cute-hero-sub { margin: 1.75rem auto 0; max-width: 44rem; font-size: clamp(1.1rem, 2vw, 1.45rem); line-height: 1.65; }
        .cute-hero-actions { margin-top: 2.75rem; display: flex; flex-wrap: wrap; gap: 1.1rem; justify-content: center; }
        .cute-btn-lg { padding: 1.05rem 2.6rem; font-size: clamp(1.05rem, 1.6vw, 1.25rem); }
        .cute-hero-inner .cute-title-underline { background-image: linear-gradient(transparent 66%, var(--c-petal) 66%); padding: 0 .4rem; }

        .cute-s1, .cute-s2, .cute-s3, .cute-s4 { display: none; transform: rotate(var(--r, 0deg)); }
        .cute-s1, .cute-s2 { width: 3.25rem; height: 3.25rem; }
        .cute-s3 { width: 5.5rem; height: 3.4rem; }
        .cute-s4 { width: 4.25rem; height: 2.8rem; }
        @media (min-width: 640px) { .cute-s1, .cute-s2 { display: block; } }
        @media (min-width: 768px) { .cute-s3, .cute-s4 { display: block; } }
        @media (min-width: 1024px) {
            .cute-s1, .cute-s2 { width: 4.25rem; height: 4.25rem; }
            .cute-s3 { width: 7rem; height: 4.4rem; }
            .cute-s4 { width: 5.25rem; height: 3.5rem; }
        }

        /* Ikon kawaii */
        .cute-ic { display: block; width: 2.5rem; height: 2.5rem; flex: none; }
        .cute-ic-lg { width: 4rem; height: 4rem; margin: 0 auto .75rem; }

        /* Maskot permen */
        .cute-mascot { display: block; width: clamp(7.5rem, 16vw, 11rem); height: auto; margin: 0 auto 1.25rem; }
        .cute-mascot-sm { width: 7rem; margin-bottom: 1rem; }
        [x-cloak] { display: none !important; }
    </style>

    <div class="cute-page">


    <!-- 1. Hero Section -->
    <div class="relative overflow-hidden" style="background: linear-gradient(180deg, #FFEAF1 0%, var(--c-blush) 100%);">
        <div class="absolute inset-0 cute-dots"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full blur-3xl opacity-70" style="background: var(--c-lilac);"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full blur-3xl opacity-70" style="background: var(--c-peach);"></div>

        {{-- Stiker dekorasi SVG --}}
        <svg class="cute-s1" style="--r:-12deg" viewBox="0 0 32 32" aria-hidden="true"><use href="#cute-heart"/></svg>
        <svg class="cute-s2" style="--r:10deg" viewBox="0 0 32 32" aria-hidden="true"><use href="#cute-sparkle"/></svg>
        <svg class="cute-s3" style="--r:6deg" viewBox="0 0 64 40" aria-hidden="true"><use href="#cute-cloud"/></svg>
        <svg class="cute-s4" style="--r:-8deg" viewBox="0 0 48 32" aria-hidden="true"><use href="#cute-bow"/></svg>

        <div class="cute-hero-inner">
            <svg class="cute-mascot cute-float" style="--r:0deg" viewBox="0 0 200 140" role="img" aria-label="Maskot permen Candyress"><use href="#cute-mascot"/></svg>
            <span class="cute-pill cute-hero-pill">🍬 Toko akun digital favoritmu</span>
            <h1 class="cute-hero-title">
                Premium Apps, <br />
                <span class="cute-title-underline" style="color: var(--c-berry);">Harga Bersahabat</span> 💕
            </h1>
            <p class="cute-hero-sub cute-muted">
                Temukan berbagai layanan digital premium untuk hiburan, produktivitas, desain, AI, dan lainnya. Proses instan dan bergaransi.
            </p>
            <div class="cute-hero-actions">
                <a href="#produk" class="cute-btn cute-btn-primary cute-btn-lg">Jelajahi Produk</a>
                <a href="#cara-beli" class="cute-btn cute-btn-ghost cute-btn-lg">Cara Pembelian</a>
            </div>
        </div>

        <svg class="cute-wave" viewBox="0 0 1440 48" preserveAspectRatio="none" aria-hidden="true">
            <path d="M0 24 Q 60 0 120 24 T 240 24 T 360 24 T 480 24 T 600 24 T 720 24 T 840 24 T 960 24 T 1080 24 T 1200 24 T 1320 24 T 1440 24 V48 H0 Z" fill="#fff"/>
        </svg>
    </div>

    <!-- 2. Kategori Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold">Kategori Populer</h2>
                <p class="cute-muted mt-2">Pilih yang paling kamu suka</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @php
                    $categories = [
                        ['name' => 'Streaming', 'icon' => 'cute-ic-streaming', 'bg' => '#FFE1EA'],
                        ['name' => 'AI Tools', 'icon' => 'cute-ic-ai', 'bg' => '#EBDDFB'],
                        ['name' => 'Design', 'icon' => 'cute-ic-design', 'bg' => '#FFE6D6'],
                        ['name' => 'Productivity', 'icon' => 'cute-ic-productivity', 'bg' => '#DDF3EA'],
                    ];
                @endphp
                @foreach($categories as $cat)
                    <a href="#" class="cute-card p-6 text-center group">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform" style="background: {{ $cat['bg'] }};"><svg class="cute-ic" viewBox="0 0 48 48" aria-hidden="true"><use href="#{{ $cat['icon'] }}"/></svg></div>
                        <h3 class="font-semibold text-lg">{{ $cat['name'] }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAMBAHAN: Section Tentang Kami (Target id="tentang") -->
    <div id="tentang" class="py-20 scroll-mt-16" style="background: var(--c-petal);">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="cute-card p-8 md:p-12" style="box-shadow: 0 6px 0 var(--c-rose); border-color: var(--c-rose);">
                <svg class="cute-ic cute-ic-lg" viewBox="0 0 48 48" aria-hidden="true"><use href="#cute-ic-lollipop"/></svg>
                <h2 class="text-3xl font-bold mb-5">Tentang Candyress</h2>
                <p class="text-lg cute-muted leading-relaxed">
                    Candyress adalah platform penyedia layanan akun digital premium yang berdedikasi untuk memberikan akses mudah, murah, dan aman ke berbagai aplikasi favorit Anda. Kami menjamin setiap transaksi diproses secara instan dan didukung oleh layanan garansi penuh.
                </p>
            </div>
        </div>
    </div>

    <!-- 3. Katalog Showcase Section (Target id="produk") -->
    <div id="produk" class="py-20 scroll-mt-16" style="background: var(--c-blush);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-14">
                <span class="cute-pill mb-4">🛍️ Katalog</span>
                <h2 class="text-3xl md:text-4xl font-bold">Aplikasi Premium Pilihan</h2>
                <p class="mt-4 cute-muted max-w-2xl mx-auto leading-relaxed">
                    Koleksi lengkap layanan digital terbaik untuk menunjang produktivitas dan hiburanmu.
                </p>
            </div>

            {{-- Catalog Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <a href="{{ route('product.show', $product->slug) }}"
                       class="group cute-card p-6 flex flex-col items-center text-center">

                        {{-- Logo / Icon --}}
                        <div class="w-20 h-20 rounded-3xl overflow-hidden mb-5 flex-shrink-0 transition-transform duration-300 group-hover:rotate-3"
                             style="border: 3px solid var(--c-petal); box-shadow: 0 4px 0 var(--c-petal);">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--c-petal), var(--c-lilac));">
                                    <span class="cute-display text-2xl font-bold" style="color: var(--c-berry);">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- App Name --}}
                        <h3 class="text-lg font-semibold mb-1.5 transition-colors line-clamp-1 cute-product-name">
                            {{ $product->name }}
                        </h3>

                        {{-- Tagline / Short Description --}}
                        <p class="text-sm cute-muted leading-relaxed line-clamp-2 mb-4">
                            {{ Str::limit(strip_tags($product->description), 70) ?: ($product->category->name ?? 'Layanan digital premium') }}
                        </p>

                        {{-- Category Pill --}}
                        <span class="cute-pill mt-auto">
                            {{ $product->category->name ?? 'Digital' }}
                        </span>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16 cute-card">
                        <svg class="cute-mascot cute-mascot-sm" viewBox="0 0 200 140" aria-hidden="true"><use href="#cute-mascot"/></svg>
                        <p class="font-semibold" style="color: var(--c-berry);">Belum ada produk yang ditambahkan.</p>
                        <p class="cute-muted text-sm mt-1">Produk akan muncul di sini setelah ditambahkan.</p>
                    </div>
                @endforelse
            </div>

            {{-- View All Link --}}
            @if($products->count())
                <div class="mt-12 text-center">
                    <a href="{{ route('home') }}#produk" class="cute-btn cute-btn-ghost text-sm">
                        Lihat Semua Produk
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- 4. Mengapa Memilih Kami & Cara Kerja (Target id="cara-beli") -->
    <div id="cara-beli" class="bg-white scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid md:grid-cols-2 gap-12 md:gap-16 items-start">
                <!-- Kenapa Kami -->
                <div>
                    <h2 class="text-3xl font-bold mb-8">Mengapa Candyress? 💖</h2>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-14 h-14 rounded-2xl flex items-center justify-center" style="background: #DDF3EA;"><svg class="cute-ic" viewBox="0 0 48 48" aria-hidden="true"><use href="#cute-ic-bolt"/></svg></div>
                            <div>
                                <h3 class="font-semibold text-xl">Proses Otomatis & Cepat</h3>
                                <p class="cute-muted mt-1">Akun digital dikirim secara instan setelah pembayaran terverifikasi.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-14 h-14 rounded-2xl flex items-center justify-center" style="background: var(--c-lilac);"><svg class="cute-ic" viewBox="0 0 48 48" aria-hidden="true"><use href="#cute-ic-shield"/></svg></div>
                            <div>
                                <h3 class="font-semibold text-xl">Full Garansi</h3>
                                <p class="cute-muted mt-1">Jika akun bermasalah selama masa aktif, kami ganti baru tanpa ribet.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cara Pembelian -->
                <div class="cute-steps">
                    <div class="cute-steps-bubble-a" aria-hidden="true"></div>
                    <div class="cute-steps-bubble-b" aria-hidden="true"></div>
                    <h2 class="cute-steps-title">Cara Pembelian</h2>
                    <ul class="cute-steps-list">
                        <li class="cute-step">
                            <span class="cute-step-num">1</span>
                            <span class="cute-step-text">Pilih produk digital yang Anda inginkan.</span>
                        </li>
                        <li class="cute-step">
                            <span class="cute-step-num">2</span>
                            <span class="cute-step-text">Lakukan checkout &amp; pembayaran via sistem.</span>
                        </li>
                        <li class="cute-step">
                            <span class="cute-step-num">3</span>
                            <span class="cute-step-text">Dapatkan detail akun di Dashboard Anda.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- TAMBAHAN: Section Testimoni (Target id="testimoni") -->
    <div id="testimoni" class="py-20 scroll-mt-16" style="background: linear-gradient(180deg, var(--c-blush), #FFEAF1);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-10">Apa Kata Mereka? 💌</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Dummy Testimoni 1 -->
                <div class="cute-card p-6" style="transform: rotate(-1.2deg);">
                    <div class="text-lg mb-4" style="color: #FFB84D;">★★★★★</div>
                    <p class="mb-4">"Akun Netflix mendarat dengan aman, prosesnya cepat banget. Recommended!"</p>
                    <p class="font-semibold" style="color: var(--c-berry);">- Budi S.</p>
                </div>
                <!-- Dummy Testimoni 2 -->
                <div class="cute-card p-6" style="transform: rotate(1deg);">
                    <div class="text-lg mb-4" style="color: #FFB84D;">★★★★★</div>
                    <p class="mb-4">"Langganan Canva Pro di sini harganya miring, garansinya beneran aktif."</p>
                    <p class="font-semibold" style="color: var(--c-berry);">- Rina M.</p>
                </div>
                <!-- Dummy Testimoni 3 -->
                <div class="cute-card p-6" style="transform: rotate(-0.8deg);">
                    <div class="text-lg mb-4" style="color: #FFB84D;">★★★★★</div>
                    <p class="mb-4">"Adminnya fast response, sangat terbantu waktu ada kendala di awal. Mantap Candyress."</p>
                    <p class="font-semibold" style="color: var(--c-berry);">- Andi P.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. FAQ Section (Target id="faq") (Alpine JS) -->
    <div id="faq" class="bg-white py-20 scroll-mt-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-10">Pertanyaan Sering Diajukan (FAQ) 🙋‍♀️</h2>
            <div class="space-y-4">
                <!-- Item FAQ -->
                <div x-data="{ expanded: false }" class="cute-card overflow-hidden" style="border-radius: 1.5rem; box-shadow: 0 4px 0 var(--c-petal);">
                    <button @click="expanded = !expanded" class="w-full px-6 py-4 flex justify-between items-center text-left focus:outline-none cute-faq-btn" :aria-expanded="expanded">
                        <span class="font-semibold">Apakah akun yang dijual legal?</span>
                        <span x-text="expanded ? '−' : '+'" class="w-8 h-8 rounded-full flex items-center justify-center text-xl flex-shrink-0 ml-3" style="background: var(--c-petal); color: var(--c-berry);"></span>
                    </button>
                    <div x-show="expanded" x-collapse x-cloak class="px-6 pb-4 cute-muted">
                        Ya, semua akun yang kami sediakan adalah 100% legal dan menggunakan metode pembayaran resmi, sehingga aman digunakan.
                    </div>
                </div>

                <div x-data="{ expanded: false }" class="cute-card overflow-hidden" style="border-radius: 1.5rem; box-shadow: 0 4px 0 var(--c-petal);">
                    <button @click="expanded = !expanded" class="w-full px-6 py-4 flex justify-between items-center text-left focus:outline-none cute-faq-btn" :aria-expanded="expanded">
                        <span class="font-semibold">Bagaimana sistem garansinya?</span>
                        <span x-text="expanded ? '−' : '+'" class="w-8 h-8 rounded-full flex items-center justify-center text-xl flex-shrink-0 ml-3" style="background: var(--c-petal); color: var(--c-berry);"></span>
                    </button>
                    <div x-show="expanded" x-collapse x-cloak class="px-6 pb-4 cute-muted">
                        Kami memberikan garansi penuh sesuai durasi produk. Cukup lapor melalui tiket di dashboard Anda jika ada kendala.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dummy div untuk target id="kontak" di paling bawah agar tidak lompat kosong -->
    <div id="kontak"></div>

    </div>
@endsection