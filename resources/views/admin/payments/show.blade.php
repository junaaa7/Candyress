<x-admin-layout>
    <div class="p-6 max-w-5xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.payments.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Kembali</a>
            <h1 class="text-2xl font-bold text-gray-800">Verifikasi Pembayaran</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Kiri: Bukti Pembayaran -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Bukti Pembayaran (Struk)</h2>
                
                @if($payment->payment_proof)
                    <div class="border rounded-md p-2 bg-gray-50 flex justify-center mb-4">
                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Transfer" class="max-w-full h-auto max-h-96 object-contain rounded">
                    </div>
                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-sm text-blue-600 hover:underline block text-center">Buka Gambar Penuh &nearr;</a>
                @else
                    <div class="border-2 border-dashed border-gray-300 rounded-md p-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-2 text-sm">Pelanggan belum mengunggah bukti pembayaran.</p>
                    </div>
                @endif
            </div>

            <!-- Kanan: Detail & Form Verifikasi -->
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Transaksi</h2>
                    <table class="w-full text-sm">
                        <tr class="border-b"><td class="py-2 text-gray-500">No. Pesanan</td><td class="py-2 font-bold text-gray-900">#{{ $payment->order->order_number }}</td></tr>
                        <tr class="border-b"><td class="py-2 text-gray-500">Pelanggan</td><td class="py-2 font-bold text-gray-900">{{ $payment->order->user->name }}</td></tr>
                        <tr class="border-b"><td class="py-2 text-gray-500">Metode Pembayaran</td><td class="py-2 font-bold text-gray-900">{{ strtoupper($payment->payment_method) }}</td></tr>
                        <tr class="border-b"><td class="py-2 text-gray-500">Nominal Transfer</td><td class="py-2 font-bold text-blue-600 text-lg">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td></tr>
                        <tr><td class="py-2 text-gray-500">Status Saat Ini</td>
                            <td class="py-2">
                                @if($payment->status == 'pending') <span class="text-yellow-600 font-bold">Menunggu Verifikasi</span> @endif
                                @if($payment->status == 'approved') <span class="text-green-600 font-bold">Disetujui</span> @endif
                                @if($payment->status == 'rejected') <span class="text-red-600 font-bold">Ditolak</span> @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Form Aksi Terima/Tolak -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Aksi Verifikasi</h2>
                    
                    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keputusan:</label>
                            <select name="status" id="payment_status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" onchange="toggleRejectionReason()">
                                <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Biarkan Pending</option>
                                <option value="approved" {{ $payment->status == 'approved' ? 'selected' : '' }}>Setujui (Ubah pesanan jadi Diproses)</option>
                                <option value="rejected" {{ $payment->status == 'rejected' ? 'selected' : '' }}>Tolak Pembayaran</option>
                            </select>
                        </div>

                        <div class="mb-4 {{ $payment->status == 'rejected' ? '' : 'hidden' }}" id="rejection_box">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan (Wajib jika ditolak):</label>
                            <textarea name="rejection_reason" rows="3" placeholder="Contoh: Bukti transfer buram, atau nominal tidak sesuai." class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">{{ $payment->rejection_reason }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-gray-800 text-white py-2 px-4 rounded-md hover:bg-gray-900 font-medium transition">
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