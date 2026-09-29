@extends('layouts.store')

@section('title', 'Home')

@section('content')
    <!-- 1. Hero Section -->
    <div class="relative overflow-hidden bg-white">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-[0.03]"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-brand-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-accent-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-brand-50 text-brand-600 text-sm font-semibold mb-4 border border-brand-100">
                🚀 #1 Digital Accounts Platform
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-brand-900 tracking-tight leading-tight">
                Premium Apps, <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-500">Harga Bersahabat.</span>
            </h1>
            <p class="mt-6 text-lg text-gray-500 max-w-2xl mx-auto leading-relaxed">
                Temukan berbagai layanan digital premium untuk kebutuhan hiburan, produktivitas, desain, AI, dan lainnya dengan proses instan & bergaransi.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#produk" class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-full text-base font-semibold transition shadow-lg hover:shadow-brand-500/30">
                    Jelajahi Produk
                </a>
                <a href="#cara-beli" class="bg-white border border-gray-200 hover:border-gray-300 text-gray-700 px-8 py-3.5 rounded-full text-base font-semibold transition shadow-sm">
                    Cara Pembelian
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Kategori Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-brand-900">Kategori Populer</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $categories = [
                    ['name' => 'Streaming', 'icon' => '🎬'],
                    ['name' => 'AI Tools', 'icon' => '🤖'],
                    ['name' => 'Design', 'icon' => '🎨'],
                    ['name' => 'Productivity', 'icon' => '📈'],
                ];
            @endphp
            @foreach($categories as $cat)
                <a href="#" class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-brand-200 transition text-center group">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">{{ $cat['icon'] }}</div>
                    <h3 class="font-semibold text-gray-800">{{ $cat['name'] }}</h3>
                </a>
            @endforeach
        </div>
    </div>
    
    <!-- TAMBAHAN: Section Tentang Kami (Target id="tentang") -->
    <div id="tentang" class="bg-white py-20 scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-brand-900 mb-6">Tentang Candyress</h2>
            <p class="text-lg text-gray-500 max-w-3xl mx-auto leading-relaxed">
                Candyress adalah platform penyedia layanan akun digital premium yang berdedikasi untuk memberikan akses mudah, murah, dan aman ke berbagai aplikasi favorit Anda. Kami menjamin setiap transaksi diproses secara instan dan didukung oleh layanan garansi penuh.
            </p>
        </div>
    </div>

    <!-- 3. Katalog Showcase Section (Target id="produk") -->
    <div id="produk" class="bg-gray-50 py-20 scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-14">
                <span class="inline-block px-4 py-1.5 rounded-full bg-brand-50 text-brand-600 text-xs font-bold tracking-widest uppercase border border-brand-100 mb-4">
                    Katalog
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-brand-900 tracking-tight">
                    Aplikasi Premium Pilihan
                </h2>
                <p class="mt-4 text-gray-500 max-w-2xl mx-auto leading-relaxed">
                    Koleksi lengkap layanan digital terbaik untuk menunjang produktivitas dan hiburanmu.
                </p>
            </div>

            {{-- Catalog Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <a href="{{ route('product.show', $product->slug) }}"
                       class="group bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center hover:shadow-md hover:-translate-y-1 transition-all duration-300">

                        {{-- Logo / Icon --}}
                        <div class="w-20 h-20 rounded-2xl overflow-hidden mb-5 shadow-sm ring-1 ring-gray-100 group-hover:shadow-md group-hover:ring-brand-200 transition-all duration-300 flex-shrink-0">
                            @if($product->thumbnail)
                                <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-brand-100 to-accent-100 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-brand-500">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- App Name --}}
                        <h3 class="text-base font-bold text-brand-900 mb-1.5 group-hover:text-brand-600 transition-colors line-clamp-1">
                            {{ $product->name }}
                        </h3>

                        {{-- Tagline / Short Description --}}
                        <p class="text-sm text-gray-400 leading-relaxed line-clamp-2 mb-4">
                            {{ Str::limit(strip_tags($product->description), 70) ?: ($product->category->name ?? 'Layanan digital premium') }}
                        </p>

                        {{-- Category Pill --}}
                        <span class="mt-auto inline-block px-3 py-1 rounded-full bg-brand-50 text-brand-600 text-xs font-semibold border border-brand-100">
                            {{ $product->category->name ?? 'Digital' }}
                        </span>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-gray-100">
                        <div class="mx-auto w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada produk yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>

            {{-- View All Link --}}
            @if($products->count())
                <div class="mt-12 text-center">
                    <a href="{{ route('home') }}#produk"
                       class="inline-flex items-center gap-2 text-brand-600 font-semibold hover:text-brand-700 transition-colors text-sm">
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
    <div id="cara-beli" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 scroll-mt-16">
        <div class="grid md:grid-cols-2 gap-16">
            <!-- Kenapa Kami -->
            <div>
                <h2 class="text-2xl font-bold text-brand-900 mb-8">Mengapa Candyress?</h2>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-xl font-bold">✓</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Proses Otomatis & Cepat</h3>
                            <p class="text-gray-500 mt-1">Akun digital dikirim secara instan setelah pembayaran terverifikasi.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl font-bold">🛡️</div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Full Garansi</h3>
                            <p class="text-gray-500 mt-1">Jika akun bermasalah selama masa aktif, kami ganti baru tanpa ribet.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cara Pembelian -->
            <div class="bg-brand-900 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white opacity-5 rounded-full"></div>
                <h2 class="text-2xl font-bold mb-8">Cara Pembelian</h2>
                <ul class="space-y-5 relative z-10">
                    <li class="flex items-center gap-4">
                        <span class="w-8 h-8 rounded-full bg-brand-700 flex items-center justify-center font-bold text-sm">1</span>
                        <span class="text-brand-50">Pilih produk digital yang Anda inginkan.</span>
                    </li>
                    <li class="flex items-center gap-4">
                        <span class="w-8 h-8 rounded-full bg-brand-700 flex items-center justify-center font-bold text-sm">2</span>
                        <span class="text-brand-50">Lakukan checkout & pembayaran via sistem.</span>
                    </li>
                    <li class="flex items-center gap-4">
                        <span class="w-8 h-8 rounded-full bg-brand-700 flex items-center justify-center font-bold text-sm">3</span>
                        <span class="text-brand-50">Dapatkan detail akun di Dashboard Anda.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- TAMBAHAN: Section Testimoni (Target id="testimoni") -->
    <div id="testimoni" class="bg-white py-20 scroll-mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-brand-900 mb-10">Apa Kata Mereka?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Dummy Testimoni 1 -->
                <div class="bg-gray-50 p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-yellow-400 text-lg mb-4">★★★★★</div>
                    <p class="text-gray-600 italic mb-4">"Akun Netflix mendarat dengan aman, prosesnya cepat banget. Recommended!"</p>
                    <p class="font-semibold text-gray-900">- Budi S.</p>
                </div>
                <!-- Dummy Testimoni 2 -->
                <div class="bg-gray-50 p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-yellow-400 text-lg mb-4">★★★★★</div>
                    <p class="text-gray-600 italic mb-4">"Langganan Canva Pro di sini harganya miring, garansinya beneran aktif."</p>
                    <p class="font-semibold text-gray-900">- Rina M.</p>
                </div>
                <!-- Dummy Testimoni 3 -->
                <div class="bg-gray-50 p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-yellow-400 text-lg mb-4">★★★★★</div>
                    <p class="text-gray-600 italic mb-4">"Adminnya fast response, sangat terbantu waktu ada kendala di awal. Mantap Candyress."</p>
                    <p class="font-semibold text-gray-900">- Andi P.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. FAQ Section (Target id="faq") (Alpine JS) -->
    <div id="faq" class="bg-gray-50 py-20 scroll-mt-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-brand-900 text-center mb-10">Pertanyaan Sering Diajukan (FAQ)</h2>
            <div class="space-y-4">
                <!-- Item FAQ -->
                <div x-data="{ expanded: false }" class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
                    <button @click="expanded = !expanded" class="w-full px-6 py-4 flex justify-between items-center text-left focus:outline-none">
                        <span class="font-semibold text-gray-800">Apakah akun yang dijual legal?</span>
                        <span x-text="expanded ? '−' : '+'" class="text-2xl text-gray-500"></span>
                    </button>
                    <div x-show="expanded" x-collapse x-cloak class="px-6 pb-4 text-gray-500">
                        Ya, semua akun yang kami sediakan adalah 100% legal dan menggunakan metode pembayaran resmi, sehingga aman digunakan.
                    </div>
                </div>

                <div x-data="{ expanded: false }" class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
                    <button @click="expanded = !expanded" class="w-full px-6 py-4 flex justify-between items-center text-left focus:outline-none">
                        <span class="font-semibold text-gray-800">Bagaimana sistem garansinya?</span>
                        <span x-text="expanded ? '−' : '+'" class="text-2xl text-gray-500"></span>
                    </button>
                    <div x-show="expanded" x-collapse x-cloak class="px-6 pb-4 text-gray-500">
                        Kami memberikan garansi penuh sesuai durasi produk. Cukup lapor melalui tiket di dashboard Anda jika ada kendala.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dummy div untuk target id="kontak" di paling bawah agar tidak lompat kosong -->
    <div id="kontak"></div>
@endsection