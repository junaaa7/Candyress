<x-admin-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800">Laporan Penjualan</h1>
            
            <!-- Form Filter Tanggal -->
            <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-center gap-2 bg-white p-2 rounded-lg shadow-sm border border-gray-200">
                <div>
                    <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="text-sm rounded border-gray-300">
                </div>
                <span class="text-gray-500">-</span>
                <div>
                    <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="text-sm rounded border-gray-300">
                </div>
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded text-sm font-medium hover:bg-gray-900">
                    Filter
                </button>
            </form>
        </div>

        <!-- Ringkasan Penjualan & Pendapatan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="p-4 bg-blue-100 rounded-lg text-blue-600 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Penjualan Sukses</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($summary->total_orders ?? 0, 0, ',', '.') }} <span class="text-lg font-medium text-gray-500">Pesanan</span></p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center">
                <div class="p-4 bg-green-100 rounded-lg text-green-600 mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</p>
                    <p class="text-3xl font-bold text-green-600">Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tabel Produk Terlaris -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-bold text-gray-800">10 Produk Terlaris</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Terjual</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($topProducts as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 text-center font-bold">{{ $product->total_sold }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 text-right font-medium">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-sm text-gray-500">Belum ada data penjualan pada periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Pesanan Berdasarkan Periode (Harian) -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-bold text-gray-800">Pesanan Harian (Periode Terpilih)</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Jumlah Pesanan</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pendapatan Harian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($dailySales as $sales)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($sales->date)->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500 text-center font-bold">{{ $sales->total_orders }}</td>
                                <td class="px-4 py-3 text-sm text-green-600 text-right font-bold">Rp {{ number_format($sales->daily_revenue, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-sm text-gray-500">Tidak ada transaksi pada periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</x-admin-layout>