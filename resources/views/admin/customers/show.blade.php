<x-admin-layout>
    <div class="mx-auto max-w-7xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('admin.customers.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">&larr; Kembali</a>
            <h1 class="text-3xl font-bold">Detail Pelanggan: <span class="text-brand-600">{{ $customer->name }}</span> 👤</h1>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- Kiri: Profil Pelanggan -->
            <div class="space-y-6 lg:col-span-1">
                <div class="cute-card p-6 text-center">
                    <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full border-2 border-white bg-gradient-to-br from-brand-300 to-brand-500 font-display text-3xl font-bold text-white ring-4 ring-brand-100">
                        {{ substr($customer->name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold">{{ $customer->name }}</h2>
                    <p class="mb-4 text-sm text-mauve">{{ $customer->email }}</p>

                    @if($customer->is_active)
                        <span class="mb-4 inline-block rounded-full border-2 border-emerald-200 bg-mint px-4 py-1 text-xs font-bold text-emerald-700">Akun Aktif</span>
                    @else
                        <span class="mb-4 inline-block rounded-full border-2 border-brand-300 bg-brand-100 px-4 py-1 text-xs font-bold text-rose-600">Akun Nonaktif</span>
                    @endif

                    <div class="border-t-2 border-dashed border-brand-100 pt-4 text-left">
                        <p class="mb-1 text-sm text-mauve">No. Handphone / WA</p>
                        <p class="mb-3 font-bold">{{ $customer->phone ?? 'Belum ditambahkan' }}</p>

                        <p class="mb-1 text-sm text-mauve">Bergabung Sejak</p>
                        <p class="font-bold">{{ $customer->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Kanan: Riwayat Pembelian -->
            <div class="lg:col-span-2">
                <div class="cute-card p-6">
                    <h2 class="mb-4 text-xl font-semibold">Riwayat Pembelian 🧾</h2>

                    <div class="overflow-x-auto">
                        <table class="cute-table min-w-[32rem]">
                            <thead>
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->orders->sortByDesc('created_at') as $order)
                                <tr>
                                    <td class="font-bold text-brand-600">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="underline-offset-4 hover:underline">#{{ $order->order_number }}</a>
                                    </td>
                                    <td class="text-mauve">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                            <span class="inline-block rounded-full border-2 border-amber-200 bg-amber-50 px-3.5 py-0.5 text-xs font-bold text-amber-700">Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="inline-block rounded-full border-2 border-accent-200 bg-accent-100 px-3.5 py-0.5 text-xs font-bold text-purple-600">Diproses</span>
                                        @elseif($order->status == 'completed')
                                            <span class="inline-block rounded-full border-2 border-emerald-200 bg-mint px-3.5 py-0.5 text-xs font-bold text-emerald-700">Selesai</span>
                                        @else
                                            <span class="inline-block rounded-full border-2 border-brand-300 bg-brand-100 px-3.5 py-0.5 text-xs font-bold text-rose-600">Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center font-semibold text-mauve">Pelanggan ini belum pernah melakukan pembelian.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>