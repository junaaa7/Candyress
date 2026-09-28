<x-admin-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Dashboard Admin</h1>

        <!-- Grid Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Total Pendapatan -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>

            <!-- Total Pesanan -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalPesanan }}</h3>
            </div>

            <!-- Pesanan Pending -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-orange-100 border-l-4 border-l-orange-500">
                <p class="text-sm text-gray-500 font-medium">Pesanan Pending</p>
                <h3 class="text-2xl font-bold text-orange-600">{{ $pesananPending }}</h3>
            </div>

            <!-- Pesanan Selesai -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-green-100 border-l-4 border-l-green-500">
                <p class="text-sm text-gray-500 font-medium">Pesanan Selesai</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $pesananSelesai }}</h3>
            </div>

            <!-- Total Customer -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 font-medium">Total Customer</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalCustomer }}</h3>
            </div>

            <!-- Akun Premium Tersedia -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-blue-100 border-l-4 border-l-blue-500">
                <p class="text-sm text-gray-500 font-medium">Akun Premium Tersedia</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $akunTersedia }}</h3>
            </div>
        </div>

        <!-- Bagian Bawah: Produk Terlaris -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Produk Terlaris</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terjual</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($produkTerlaris as $produk)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $produk->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $produk->orders_count }} kali</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data penjualan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>