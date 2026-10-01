<x-admin-layout>
    <div class="mx-auto max-w-7xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-col items-center justify-between gap-4 md:flex-row">
            <h1 class="text-3xl font-bold">Laporan <span class="text-brand-600">Penjualan</span> 📊</h1>

            <!-- Form Filter Tanggal -->
            <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-wrap items-center justify-center gap-2 rounded-2xl border-2 border-brand-100 bg-white p-2 shadow-sticker-sm">
                <div>
                    <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="cute-input w-auto px-3 py-2 text-sm">
                </div>
                <span class="font-bold text-brand-300">-</span>
                <div>
                    <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="cute-input w-auto px-3 py-2 text-sm">
                </div>
                <button type="submit" class="cute-btn cute-btn-primary px-5 py-2 text-sm">
                    Filter
                </button>
            </form>
        </div>

        <!-- Ringkasan Penjualan & Pendapatan -->
        <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="cute-card flex items-center p-6">
                <div class="mr-4 rounded-2xl bg-brand-100 p-4 text-brand-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-mauve">Total Penjualan Sukses</p>
                    <p class="font-display text-3xl font-bold">{{ number_format($summary->total_orders ?? 0, 0, ',', '.') }} <span class="font-sans text-lg font-semibold text-mauve">Pesanan</span></p>
                </div>
            </div>

            <div class="cute-card flex items-center p-6">
                <div class="mr-4 rounded-2xl bg-mint p-4 text-emerald-700">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold uppercase tracking-wider text-mauve">Total Pendapatan</p>
                    <p class="font-display text-3xl font-bold text-emerald-700">Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Tabel Produk Terlaris -->
            <div class="cute-card overflow-hidden">
                <div class="border-b-2 border-dashed border-brand-100 bg-brand-100/60 p-4">
                    <h2 class="text-lg font-semibold">10 Produk Terlaris 🏆</h2>
                </div>
                <div class="overflow-x-auto p-3">
                    <table class="cute-table min-w-[24rem]">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th class="text-center">Terjual</th>
                                <th class="text-right">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $product)
                            <tr>
                                <td class="font-bold">{{ $product->name }}</td>
                                <td class="text-center font-bold text-mauve">{{ $product->total_sold }}</td>
                                <td class="text-right font-bold">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center font-semibold text-mauve">Belum ada data penjualan pada periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Pesanan Berdasarkan Periode (Harian) -->
            <div class="cute-card overflow-hidden">
                <div class="border-b-2 border-dashed border-brand-100 bg-brand-100/60 p-4">
                    <h2 class="text-lg font-semibold">Pesanan Harian (Periode Terpilih) 📅</h2>
                </div>
                <div class="overflow-x-auto p-3">
                    <table class="cute-table min-w-[24rem]">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th class="text-center">Jumlah Pesanan</th>
                                <th class="text-right">Pendapatan Harian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dailySales as $sales)
                            <tr>
                                <td class="font-bold">{{ \Carbon\Carbon::parse($sales->date)->format('d M Y') }}</td>
                                <td class="text-center font-bold text-mauve">{{ $sales->total_orders }}</td>
                                <td class="text-right font-bold text-emerald-700">Rp {{ number_format($sales->daily_revenue, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center font-semibold text-mauve">Tidak ada transaksi pada periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>