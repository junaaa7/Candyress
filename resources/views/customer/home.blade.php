{{-- Asumsi Anda menggunakan layout bawaan Laravel atau komponen kustom --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8 space-y-12">

        <!-- 1. SECTION: PROMO & BANNER UTAMA -->
        <section x-data="{ show: true }" class="relative bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-lg overflow-hidden">
            <div class="relative z-10 w-full md:w-2/3">
                <span class="bg-red-500 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Promo Spesial</span>
                <h2 class="mt-4 text-3xl font-extrabold sm:text-4xl">Diskon 20% Untuk Langganan Netflix 1 Tahun!</h2>
                <p class="mt-2 text-lg text-blue-100">Gunakan kode voucher: <span class="font-mono font-bold bg-white/20 px-2 py-1 rounded">CHILL20</span> saat checkout.</p>
                <button class="mt-6 bg-white text-blue-700 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300">
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
                <h3 class="text-xl font-bold text-gray-800">Kategori Layanan</h3>
            </div>
            <!-- Grid Kategori -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                {{-- Contoh Item Kategori --}}
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition duration-200">
                    <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-3">
                        <span class="font-bold">N</span> {{-- Ganti dengan icon/logo Netflix asli --}}
                    </div>
                    <span class="text-sm font-semibold text-gray-700">Streaming</span>
                </a>

                <a href="#" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition duration-200">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-3">
                        <span class="font-bold">C</span> {{-- Ganti dengan icon/logo Canva asli --}}
                    </div>
                    <span class="text-sm font-semibold text-gray-700">Desain</span>
                </a>

                <a href="#" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition duration-200">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-3">
                        <span class="font-bold">AI</span> {{-- Ganti dengan icon/logo AI asli --}}
                    </div>
                    <span class="text-sm font-semibold text-gray-700">Kecerdasan Buatan</span>
                </a>
                
                <a href="#" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 transition duration-200">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-3">
                        <span class="font-bold">M</span> {{-- Spotify/Music --}}
                    </div>
                    <span class="text-sm font-semibold text-gray-700">Musik</span>
                </a>
            </div>
        </section>

        <!-- 3. SECTION: PRODUK POPULER -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-bold text-gray-800">🔥 Produk Populer</h3>
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Lihat Semua</a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Card Produk 1 --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="h-40 bg-gray-900 flex items-center justify-center relative">
                        <!-- Badge -->
                        <span class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded">Terlaris</span>
                        <h4 class="text-4xl font-black text-red-600 tracking-tighter">NETFLIX</h4>
                    </div>
                    <div class="p-5">
                        <h5 class="text-lg font-bold text-gray-800 mb-1">Netflix Premium 4K</h5>
                        <p class="text-sm text-gray-500 mb-3">Profil Sharing • Garansi 30 Hari</p>
                        <div class="flex items-center justify-between mt-4">
                            <div>
                                <span class="text-xs text-gray-400 line-through">Rp 45.000</span>
                                <div class="text-xl font-extrabold text-blue-600">Rp 35.000<span class="text-sm font-normal text-gray-500">/bln</span></div>
                            </div>
                            <button class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Card Produk 2 --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="h-40 bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center justify-center relative">
                        <h4 class="text-3xl font-black text-white italic">Canva Pro</h4>
                    </div>
                    <div class="p-5">
                        <h5 class="text-lg font-bold text-gray-800 mb-1">Canva Pro Invite Link</h5>
                        <p class="text-sm text-gray-500 mb-3">Akun Pribadi • Garansi 1 Tahun</p>
                        <div class="flex items-center justify-between mt-4">
                            <div>
                                <div class="text-xl font-extrabold text-blue-600">Rp 20.000<span class="text-sm font-normal text-gray-500">/thn</span></div>
                            </div>
                            <button class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">
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
                <h3 class="text-2xl font-bold text-gray-800">✨ Produk Terbaru</h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Card Produk 3 --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300 relative">
                    <!-- Badge New -->
                    <div class="absolute top-0 left-0 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-br-lg z-10">Baru</div>
                    
                    <div class="h-40 bg-gray-800 flex items-center justify-center">
                        <h4 class="text-2xl font-black text-white">ChatGPT Plus</h4>
                    </div>
                    <div class="p-5">
                        <h5 class="text-lg font-bold text-gray-800 mb-1">ChatGPT Plus (GPT-4)</h5>
                        <p class="text-sm text-gray-500 mb-3">Akun Sharing (Max 3 Orang) • Garansi 30 Hari</p>
                        <div class="flex items-center justify-between mt-4">
                            <div>
                                <div class="text-xl font-extrabold text-blue-600">Rp 85.000<span class="text-sm font-normal text-gray-500">/bln</span></div>
                            </div>
                            <button class="bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>