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

    <!-- 3. Produk Unggulan Section -->
    <div id="produk" class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-2xl font-bold text-brand-900">Produk Pilihan</h2>
                    <p class="text-gray-500 mt-2">Penawaran terbaik minggu ini untuk Anda.</p>
                </div>
                <a href="#" class="hidden sm:inline-block text-brand-600 font-semibold hover:text-brand-700">Lihat Semua &rarr;</a>
            </div>
            
           <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <x-product-card 
                        name="{{ $product->name }}" 
                        category="{{ $product->category->name ?? '-' }}" 
                        price="{{ $product->price }}" 
                        discountPrice="{{ $product->discount_price }}" 
                        rating="{{ $product->rating }}" 
                        sold="{{ $product->sold }}" 
                        image="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : null }}"
                        detailUrl="{{ route('product.show', $product->slug) }}"
                    />
                @empty
                    <div class="col-span-full text-center py-10 bg-white rounded-2xl border border-gray-100">
                        <p class="text-gray-500 font-medium">Belum ada produk yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8 text-center sm:hidden">
                <a href="#" class="inline-block text-brand-600 font-semibold hover:text-brand-700">Lihat Semua Produk &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 4. Mengapa Memilih Kami & Cara Kerja -->
    <div id="cara-beli" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
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

    <!-- 5. FAQ Section (Alpine JS) -->
    <div class="bg-gray-50 py-20">
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
@endsection