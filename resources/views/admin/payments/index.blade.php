<x-admin-layout>
    <div class="mx-auto max-w-7xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <h1 class="mb-6 text-3xl font-bold">Kelola <span class="text-brand-600">Pembayaran</span> 💳</h1>

        <div class="cute-card overflow-x-auto p-3">
            <table class="cute-table min-w-[56rem]">
                <thead>
                    <tr>
                        <th>No. Pesanan & User</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td class="whitespace-nowrap">
                            <div class="font-bold text-brand-600">#{{ $payment->order->order_number }}</div>
                            <div class="text-sm text-mauve">{{ $payment->order->user->name ?? '-' }}</div>
                        </td>
                        <td class="whitespace-nowrap font-bold">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                        <td class="whitespace-nowrap">
                            <span class="inline-block rounded-lg border-2 border-brand-100 bg-brand-50 px-2.5 py-0.5 text-xs font-bold">{{ strtoupper($payment->payment_method) }}</span>
                        </td>
                        <td class="whitespace-nowrap text-mauve">
                            {{ $payment->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="whitespace-nowrap">
                            @if($payment->status == 'pending')
                                <span class="inline-block rounded-full border-2 border-amber-200 bg-amber-50 px-3.5 py-0.5 text-xs font-bold text-amber-700">Menunggu Verifikasi</span>
                            @elseif($payment->status == 'approved')
                                <span class="inline-block rounded-full border-2 border-emerald-200 bg-mint px-3.5 py-0.5 text-xs font-bold text-emerald-700">Disetujui</span>
                            @else
                                <span class="inline-block rounded-full border-2 border-brand-300 bg-brand-100 px-3.5 py-0.5 text-xs font-bold text-rose-600">Ditolak</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap">
                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="cute-act cute-act-edit">Lihat Bukti &rarr;</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center font-semibold text-mauve">Belum ada data pembayaran masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>