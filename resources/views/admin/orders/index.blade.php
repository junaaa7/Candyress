<x-admin-layout>
    <div class="mx-auto max-w-7xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <h1 class="mb-6 text-3xl font-bold">Kelola <span class="text-brand-600">Pesanan</span> 🧾</h1>

        <div class="cute-card overflow-x-auto p-3">
            <table class="cute-table min-w-[56rem]">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="whitespace-nowrap font-bold text-brand-600">
                            #{{ $order->order_number }}
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="font-bold">{{ $order->user->name ?? 'User Dihapus' }}</div>
                            <div class="text-sm text-mauve">{{ $order->user->email ?? '' }}</div>
                        </td>
                        <td class="whitespace-nowrap text-mauve">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="whitespace-nowrap font-bold">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td class="whitespace-nowrap">
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
                        <td class="whitespace-nowrap">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="cute-act cute-act-edit">Lihat Detail &rarr;</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center font-semibold text-mauve">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
