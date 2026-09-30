<x-admin-layout>
    <div class="mx-auto max-w-7xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <h1 class="mb-6 text-3xl font-bold">Dashboard <span class="text-brand-600">Admin</span> 💕</h1>

        <!-- Grid Statistik Utama -->
        <div class="mb-8 grid grid-cols-[repeat(auto-fit,minmax(15rem,1fr))] gap-5">

            <!-- Total Pendapatan -->
            <div class="cute-card cute-lift flex items-center gap-4 p-5">
                <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full border-2 border-brand-900 bg-brand-100">
                    <span class="font-display text-sm font-bold">Rp</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-mauve">Total Pendapatan</p>
                    <h3 class="mt-0.5 text-2xl font-bold leading-tight">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>

            <!-- Total Pesanan -->
            <div class="cute-card cute-lift flex items-center gap-4 p-5">
                <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full border-2 border-brand-900 bg-brand-100">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 8h14l-1 12H6L5 8Z"/><path d="M9 8V6a3 3 0 0 1 6 0v2" fill="none"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-mauve">Total Pesanan</p>
                    <h3 class="mt-0.5 text-2xl font-bold leading-tight">{{ $totalPesanan }}</h3>
                </div>
            </div>

            <!-- Pesanan Pending -->
            <div class="cute-card cute-lift flex items-center gap-4 border-orange-200 p-5 shadow-[0_5px_0_theme(colors.peach)]">
                <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full border-2 border-brand-900 bg-peach">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="#fff" stroke="#5B3A4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2" fill="none"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-mauve">Pesanan Pending</p>
                    <h3 class="mt-0.5 text-2xl font-bold leading-tight text-orange-700">{{ $pesananPending }}</h3>
                </div>
            </div>

            <!-- Pesanan Selesai -->
            <div class="cute-card cute-lift flex items-center gap-4 border-emerald-200 p-5 shadow-[0_5px_0_theme(colors.mint)]">
                <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full border-2 border-brand-900 bg-mint">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="#fff" stroke="#5B3A4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6" fill="none"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-mauve">Pesanan Selesai</p>
                    <h3 class="mt-0.5 text-2xl font-bold leading-tight text-emerald-700">{{ $pesananSelesai }}</h3>
                </div>
            </div>

            <!-- Total Customer -->
            <div class="cute-card cute-lift flex items-center gap-4 p-5">
                <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full border-2 border-brand-900 bg-brand-100">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="#FF9EBB" stroke="#5B3A4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-4 3-6 7-6s7 2 7 6Z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-mauve">Total Customer</p>
                    <h3 class="mt-0.5 text-2xl font-bold leading-tight">{{ $totalCustomer }}</h3>
                </div>
            </div>

            <!-- Akun Premium Tersedia -->
            <div class="cute-card cute-lift flex items-center gap-4 border-accent-200 p-5 shadow-[0_5px_0_theme(colors.accent.100)]">
                <div class="flex h-12 w-12 flex-none items-center justify-center rounded-full border-2 border-brand-900 bg-accent-100">
                    <svg class="h-6 w-6" viewBox="0 0 32 32" fill="#FFD98A" stroke="#5B3A4A" stroke-width="2.2" stroke-linejoin="round" aria-hidden="true">
                        <path d="M16 3C17 11 21 15 29 16C21 17 17 21 16 29C15 21 11 17 3 16C11 15 15 11 16 3Z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-mauve">Akun Premium Tersedia</p>
                    <h3 class="mt-0.5 text-2xl font-bold leading-tight text-purple-600">{{ $akunTersedia }}</h3>
                </div>
            </div>
        </div>

        <!-- Bagian Bawah: Produk Terlaris -->
        <div class="cute-card p-6">
            <h2 class="mb-4 text-xl font-semibold">Produk Terlaris 🏆</h2>
            <div class="overflow-x-auto">
                <table class="cute-table min-w-[24rem]">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produkTerlaris as $produk)
                        <tr>
                            <td class="font-bold">{{ $produk->name }}</td>
                            <td><span class="cute-pill">{{ $produk->orders_count }} kali</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center font-semibold text-mauve">Belum ada data penjualan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>