<x-admin-layout>
    <div class="mx-auto max-w-5xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('admin.payments.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">&larr; Kembali</a>
            <h1 class="text-3xl font-bold">Verifikasi <span class="text-brand-600">Pembayaran</span> 💳</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border-2 border-dashed border-emerald-300 bg-mint px-5 py-3.5 font-bold text-emerald-700" role="status">
                <svg class="h-6 w-6 flex-none" viewBox="0 0 24 24" fill="#fff" stroke="#1F7A57" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6" fill="none"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <!-- Kiri: Bukti Pembayaran -->
            <div class="cute-card p-6">
                <h2 class="mb-4 text-xl font-semibold">Bukti Pembayaran (Struk) 🧾</h2>

                @if($payment->payment_proof)
                    <div class="mb-4 flex justify-center rounded-2xl border-2 border-brand-100 bg-brand-50 p-2">
                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Transfer" class="h-auto max-h-96 max-w-full rounded-xl object-contain">
                    </div>
                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" rel="noopener" class="cute-link block text-center text-sm">Buka Gambar Penuh &nearr;</a>
                @else
                    <div class="rounded-2xl border-2 border-dashed border-brand-300 p-8 text-center text-mauve">
                        <svg class="mx-auto h-12 w-12 text-brand-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-2 text-sm font-semibold">Pelanggan belum mengunggah bukti pembayaran.</p>
                    </div>
                @endif
            </div>

            <!-- Kanan: Detail & Form Verifikasi -->
            <div class="space-y-6">
                <div class="cute-card p-6">
                    <h2 class="mb-4 text-xl font-semibold">Informasi Transaksi</h2>
                    <table class="w-full text-sm">
                        <tr class="border-b-2 border-dashed border-brand-100"><td class="py-2.5 text-mauve">No. Pesanan</td><td class="py-2.5 font-bold text-brand-600">#{{ $payment->order->order_number }}</td></tr>
                        <tr class="border-b-2 border-dashed border-brand-100"><td class="py-2.5 text-mauve">Pelanggan</td><td class="py-2.5 font-bold">{{ $payment->order->user->name }}</td></tr>
                        <tr class="border-b-2 border-dashed border-brand-100"><td class="py-2.5 text-mauve">Metode Pembayaran</td><td class="py-2.5 font-bold">{{ strtoupper($payment->payment_method) }}</td></tr>
                        <tr class="border-b-2 border-dashed border-brand-100"><td class="py-2.5 text-mauve">Nominal Transfer</td><td class="py-2.5 font-display text-lg font-bold text-brand-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td></tr>
                        <tr><td class="py-2.5 text-mauve">Status Saat Ini</td>
                            <td class="py-2.5">
                                @if($payment->status == 'pending') <span class="inline-block rounded-full border-2 border-amber-200 bg-amber-50 px-3.5 py-0.5 text-xs font-bold text-amber-700">Menunggu Verifikasi</span> @endif
                                @if($payment->status == 'approved') <span class="inline-block rounded-full border-2 border-emerald-200 bg-mint px-3.5 py-0.5 text-xs font-bold text-emerald-700">Disetujui</span> @endif
                                @if($payment->status == 'rejected') <span class="inline-block rounded-full border-2 border-brand-300 bg-brand-100 px-3.5 py-0.5 text-xs font-bold text-rose-600">Ditolak</span> @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Form Aksi Terima/Tolak -->
                <div class="cute-card p-6">
                    <h2 class="mb-4 text-xl font-semibold">Aksi Verifikasi</h2>

                    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <label class="cute-label">Keputusan:</label>
                            <select name="status" id="payment_status" class="cute-select" onchange="toggleRejectionReason()">
                                <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Biarkan Pending</option>
                                <option value="approved" {{ $payment->status == 'approved' ? 'selected' : '' }}>Setujui (Ubah pesanan jadi Diproses)</option>
                                <option value="rejected" {{ $payment->status == 'rejected' ? 'selected' : '' }}>Tolak Pembayaran</option>
                            </select>
                        </div>

                        <div class="mb-5 {{ $payment->status == 'rejected' ? '' : 'hidden' }}" id="rejection_box">
                            <label class="cute-label">Alasan Penolakan (Wajib jika ditolak):</label>
                            <textarea name="rejection_reason" rows="3" placeholder="Contoh: Bukti transfer buram, atau nominal tidak sesuai." class="cute-input resize-y focus:border-rose-400 focus:ring-rose-300/40">{{ $payment->rejection_reason }}</textarea>
                        </div>

                        <button type="submit" class="cute-btn cute-btn-primary w-full py-2.5">
                            Simpan Verifikasi
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Script sederhana untuk memunculkan kolom alasan penolakan -->
    <script>
        function toggleRejectionReason() {
            var status = document.getElementById('payment_status').value;
            var rejectionBox = document.getElementById('rejection_box');
            if (status === 'rejected') {
                rejectionBox.classList.remove('hidden');
            } else {
                rejectionBox.classList.add('hidden');
            }
        }
    </script>
</x-admin-layout>
