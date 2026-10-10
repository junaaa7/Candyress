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

            {{-- Section 4: If status is pending --}}
            @if($status === 'pending')
                <div class="mt-6 border-t pt-6 text-center">
                    <h3 class="font-semibold text-gray-800 text-lg mb-2">Selesaikan Pembayaran via Midtrans</h3>
                    <p class="text-sm text-gray-500 mb-6">Silakan selesaikan pembayaran top up sebesar <strong>Rp {{ number_format($topup->amount, 0, ',', '.') }}</strong>.</p>
                    
                    @if(isset($snapToken) && $snapToken)
                        <button id="pay-button" class="px-6 py-3 text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 rounded-xl shadow transition">
                            Lanjutkan Pembayaran
                        </button>
                    @else
                        <div class="p-4 bg-rose-50 text-rose-600 rounded-lg text-sm font-medium border border-rose-200">
                            Mohon maaf, terjadi kesalahan saat memuat metode pembayaran Midtrans. Silakan refresh halaman.
                        </div>
                    @endif
                </div>

                @if(isset($snapToken) && $snapToken)
                <script type="text/javascript"
                        src="https://app.sandbox.midtrans.com/snap/snap.js"
                        data-client-key="{{ config('midtrans.client_key') ?? env('MIDTRANS_CLIENT_KEY') }}">
                </script>
                <script type="text/javascript">
                    document.addEventListener('DOMContentLoaded', function () {
                        var payButton = document.getElementById('pay-button');
                        if (payButton) {
                            payButton.addEventListener('click', function () {
                                window.snap.pay('{{ $snapToken }}', {
                                    onSuccess: function(result) {
                                        window.location.reload();
                                    },
                                    onPending: function(result) {
                                        window.location.reload();
                                    },
                                    onError: function(result) {
                                        alert("Pembayaran gagal!");
                                    },
                                    onClose: function() {
                                        console.log('Customer closed the popup without finishing the payment');
                                    }
                                });
                            });
                            
                            // Auto trigger Midtrans popup when page loads
                            payButton.click();
                        }
                    });
                </script>
                @endif
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
