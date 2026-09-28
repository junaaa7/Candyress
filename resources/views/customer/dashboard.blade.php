<x-app-layout>
    {{-- Asumsi Navbar sudah diatur di dalam komponen layout --}}
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
        
        <!-- ==========================================
             BAGIAN 1: PROFIL & STATISTIK PESANAN (Eksisting)
             ========================================== -->
        <section>
            <!-- Welcome Section -->
            <div class="flex items-center mb-8">
                <div class="w-16 h-16 rounded-full bg-indigo-600 text-white flex items-center justify-center text-3xl font-bold shadow-md">
                    {{ substr(Auth::user()->name ?? 'C', 0, 1) }}
                </div>
                <div class="ml-5">
                    <h1 class="text-2xl font-bold text-gray-900">Halo, {{ Auth::user()->name ?? 'Customer Akun Premium' }}!</h1>
                    <p class="text-sm text-gray-500 mt-1">Selamat datang di Dasbor Candyress Anda.</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
                        <!-- Menggunakan variabel dari Controller -->
                        <p class="text-2xl font-bold text-gray-900">{{ $totalOrders ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-500 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Menunggu Pembayaran</p>
                        <!-- Menggunakan variabel dari Controller -->
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingOrders ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-green-500 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Pesanan Selesai</p>
                        <!-- Menggunakan variabel dari Controller -->
                        <p class="text-2xl font-bold text-gray-900">{{ $completedOrders ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Riwayat Pesanan Terbaru</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <!-- Looping data pesanan dari Controller -->
                            @forelse($orders ?? [] as $order)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">#{{ $order->order_number }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <span class="px-2 py-1 bg-gray-100 rounded-full text-xs font-semibold">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <a href="{{ route('customer.order.show', $order->order_number) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada riwayat pesanan. Yuk, mulai belanja!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Garis Pemisah -->
        <hr class="border-gray-200">

        <!-- ==========================================
             BAGIAN 2: EKSPLORASI KATALOG (Baru Ditambahkan)
             ========================================== -->
        
        <!-- Promo Banner -->
        <section class="relative bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-8 text-white shadow-md overflow-hidden">
            <div class="relative z-10 md:w-2/3">
                <span class="bg-pink-500 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Promo Pengguna Baru</span>
                <h2 class="mt-4 text-3xl font-extrabold">Potongan 15% Untuk Semua Akun AI!</h2>
                <p class="mt-2 text-indigo-100">Gunakan kode voucher: <span class="font-mono font-bold bg-white/20 px-2 py-1 rounded">CANDYAI15</span></p>
            </div>
        </section>

        <!-- Kategori -->
        <section>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Kategori Pilihan</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="#" class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:border-indigo-300 hover:shadow-md transition">
                    <div class="w-10 h-10 bg-red-100 text-red-600 rounded-lg flex items-center justify-center mr-3 font-bold">N</div>
                    <span class="font-semibold text-gray-800">Streaming</span>
                </a>
                <a href="#" class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:border-indigo-300 hover:shadow-md transition">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 font-bold">C</div>
                    <span class="font-semibold text-gray-800">Design</span>
                </a>
                <a href="#" class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:border-indigo-300 hover:shadow-md transition">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mr-3 font-bold">A</div>
                    <span class="font-semibold text-gray-800">AI Tools</span>
                </a>
                <a href="#" class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:border-indigo-300 hover:shadow-md transition">
                    <div class="w-10 h-10 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center mr-3 font-bold">S</div>
                    <span class="font-semibold text-gray-800">Software</span>
                </a>
            </div>
        </section>

        <!-- Produk Populer -->
        <section>
            <div class="flex justify-between items-end mb-4">
                <h3 class="text-xl font-bold text-gray-900">🔥 Sedang Populer</h3>
                <a href="/produk" class="text-indigo-600 text-sm font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card Produk -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="h-32 bg-gray-900 flex items-center justify-center relative">
                        <span class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded">Terlaris</span>
                        <h4 class="text-2xl font-black text-red-600 tracking-tighter">NETFLIX</h4>
                    </div>
                    <div class="p-5">
                        <h5 class="font-bold text-gray-900">Netflix Premium Sharing</h5>
                        <p class="text-xs text-gray-500 mt-1 mb-4">Resolusi 4K • Garansi 1 Bulan</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-extrabold text-indigo-600">Rp 35.000</span>
                            <button class="bg-indigo-600 text-white px-4 py-2 text-sm rounded-lg hover:bg-indigo-700 font-semibold">Beli</button>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="h-32 bg-gradient-to-r from-cyan-500 to-blue-500 flex items-center justify-center">
                        <h4 class="text-2xl font-black text-white italic">Canva Pro</h4>
                    </div>
                    <div class="p-5">
                        <h5 class="font-bold text-gray-900">Canva Pro Invite Link</h5>
                        <p class="text-xs text-gray-500 mt-1 mb-4">Akun Pribadi • Garansi 1 Tahun</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-extrabold text-indigo-600">Rp 20.000</span>
                            <button class="bg-indigo-600 text-white px-4 py-2 text-sm rounded-lg hover:bg-indigo-700 font-semibold">Beli</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>