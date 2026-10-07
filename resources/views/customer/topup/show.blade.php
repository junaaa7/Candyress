<x-customer-layout>
    <x-slot name="header">
        Detail Top Up #{{ $topup->reference_id }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            {{-- Section 1: Back button + Flash messages --}}
            <div>
                <a href="{{ route('customer.topup.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg">
                    <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg">
                    <p class="text-rose-700 text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Section 2: Detail Top Up --}}
            @php
                $status = $topup->status;
            @endphp
            <div class="cute-card overflow-hidden">
                <div class="border-b-2 border-dashed border-brand-100 bg-brand-100/60 px-6 py-5 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-brand-800">Detail Top Up</h3>
                    <div>
                        @if($status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pending</span>
                        @elseif($status === 'waiting_confirmation')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Menunggu Konfirmasi</span>
                        @elseif($status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Berhasil</span>
                        @elseif($status === 'rejected')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">Ditolak</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">ID Referensi</p>
                            <p class="font-mono text-gray-900">{{ $topup->reference_id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal</p>
                            <p class="text-gray-900">{{ $topup->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Nominal</p>
                            <p class="text-2xl font-bold text-brand-600">Rp {{ number_format($topup->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 3: Rejection alert --}}
            @if($status === 'rejected' && !empty($topup->admin_notes))
                <div class="border-2 border-dashed border-rose-300 bg-rose-50 p-4 rounded-xl mb-6">
                    <h4 class="text-rose-800 font-semibold mb-1">Top Up Ditolak</h4>
                    <p class="text-sm text-rose-600">Alasan: {{ $topup->admin_notes }}</p>
                </div>
            @endif

            {{-- Section 4: If status is pending or rejected --}}
            @if($status === 'pending' || $status === 'rejected')
                <div class="mt-6 border-t pt-6 text-center">
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">Scan QRIS untuk Pembayaran</h3>
                    <p class="text-sm text-gray-500 mb-4">Silakan scan kode QR di bawah ini menggunakan aplikasi e-Wallet atau Mobile Banking.</p>

                    @php
                        $storeSetting = \App\Models\Setting::first();
                        $qrisUrl = !empty($storeSetting?->qris_image) 
                            ? asset('storage/' . $storeSetting->qris_image) 
                            : asset('images/payments/qris.jpg');
                    @endphp
                    <!-- QRIS Image -->
                    <div class="inline-block p-3 bg-white border rounded-2xl shadow-sm">
                        <img src="{{ $qrisUrl }}" 
                             alt="QRIS Pembayaran" 
                             class="w-56 sm:w-64 max-w-full mx-auto rounded-xl object-contain"
                             onerror="this.onerror=null; this.src='{{ asset('images/qris.jpg') }}';">
                    </div>

                    <!-- Instructions -->
                    <div class="mt-4 text-xs text-gray-500 space-y-1">
                        <p>1. Transfer sesuai nominal: <strong class="text-pink-600 font-bold">Rp {{ number_format($topup->amount ?? 10000, 0, ',', '.') }}</strong></p>
                        <p>2. Pastikan nominal transfer sama persis.</p>
                        <p>3. Konfirmasi pembayaran setelah berhasil transfer.</p>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex flex-col sm:flex-row w-full gap-3 justify-center items-center">
                        <a href="{{ $qrisUrl }}" download="QRIS-Candyress.jpg" 
                           class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-pink-600 bg-pink-50 hover:bg-pink-100 rounded-lg border border-pink-200 transition text-center">
                            Unduh Gambar QRIS
                        </a>
                        <a href="https://wa.me/6281371711181?text=Halo%20Admin,%20saya%20sudah%20transfer%20top%20up%20dengan%20ID:%20{{ $topup->reference_id ?? $topup->id }}%20sebesar%20Rp%20{{ number_format($topup->amount ?? 10000, 0, ',', '.') }}" 
                           target="_blank"
                           class="w-full sm:w-auto px-5 py-2 text-sm font-medium text-white bg-pink-500 hover:bg-pink-600 rounded-lg shadow transition text-center">
                            Konfirmasi ke WhatsApp Admin
                        </a>
                    </div>
                    
                    <form action="{{ route('customer.topup.upload-proof', $topup->reference_id) }}" method="POST" enctype="multipart/form-data" class="mt-6 p-4 bg-gray-50 rounded-xl text-left border">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Bukti Pembayaran</label>
                            <input type="file" name="proof_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100" accept="image/*" required>
                            @error('proof_image')
                                <p class="text-rose-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full px-5 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-gray-900 rounded-lg shadow transition">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            @endif

            {{-- Section 5: If status is waiting_confirmation --}}
            @if($status === 'waiting_confirmation')
                <div class="cute-card p-8 text-center border-2 border-purple-200 bg-purple-50/30">
                    <div class="text-5xl mb-4">⏳</div>
                    <h4 class="text-xl font-bold text-purple-800 mb-2">Bukti Pembayaran Terkirim</h4>
                    <p class="text-purple-600 mb-6">Terima kasih! Admin sedang memverifikasi pembayaran Anda (estimasi 5-30 menit).</p>
                    
                    @if(!empty($topup->proof_image))
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-2">Bukti yang diupload:</p>
                            <img src="{{ asset('storage/' . $topup->proof_image) }}" alt="Bukti Pembayaran" class="max-w-[200px] mx-auto rounded-xl shadow-sm border border-gray-200">
                        </div>
                    @endif
                </div>
            @endif

            {{-- Section 6: If status is approved --}}
            @if($status === 'approved')
                <div class="cute-card p-8 text-center border-2 border-emerald-200 bg-emerald-50/30">
                    <div class="text-5xl mb-4">🎉</div>
                    <h4 class="text-xl font-bold text-emerald-800 mb-2">Top Up Berhasil Disetujui!</h4>
                    <p class="text-emerald-600">Saldo telah ditambahkan ke akun Anda.</p>
                </div>
            @endif

        </div>
    </div>
</x-customer-layout>
