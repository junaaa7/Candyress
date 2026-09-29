<x-customer-layout>
    <x-slot name="title">Pembayaran QRIS</x-slot>
    <x-slot name="header">Pembayaran QRIS</x-slot>

    <div class="max-w-lg mx-auto space-y-6">
        {{-- Status Cards --}}
        @if($topup->payment_status === 'paid')
            {{-- SUCCESS --}}
            <div class="bg-white rounded-2xl border border-green-200 shadow-sm p-8 text-center">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-green-700 mb-1">Pembayaran Berhasil!</h3>
                <p class="text-sm text-gray-500 mb-4">Saldo Anda sudah ditambahkan.</p>
                <div class="bg-green-50 rounded-xl p-4 mb-6">
                    <p class="text-sm text-green-600 font-medium">Jumlah Top-Up</p>
                    <p class="text-2xl font-extrabold text-green-700">Rp {{ number_format($topup->amount, 0, ',', '.') }}</p>
                </div>
                <a href="{{ route('customer.topup.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                    Kembali ke Saldo
                </a>
            </div>
        @elseif($topup->payment_status === 'expired' || ($topup->expired_at && $topup->expired_at->isPast()))
            {{-- EXPIRED --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-700 mb-1">Pembayaran Kedaluwarsa</h3>
                <p class="text-sm text-gray-500 mb-6">Kode QRIS sudah tidak berlaku. Silakan buat top-up baru.</p>
                <a href="{{ route('customer.topup.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition shadow-sm">
                    Buat Top-Up Baru
                </a>
            </div>
        @elseif($topup->payment_status === 'failed')
            {{-- FAILED --}}
            <div class="bg-white rounded-2xl border border-red-200 shadow-sm p-8 text-center">
                <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-red-700 mb-1">Pembayaran Gagal</h3>
                <p class="text-sm text-gray-500 mb-6">Terjadi masalah pada pembayaran. Silakan coba lagi.</p>
                <a href="{{ route('customer.topup.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition shadow-sm">
                    Buat Top-Up Baru
                </a>
            </div>
        @else
            {{-- PENDING — Show QRIS --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
                 x-data="qrisCountdown('{{ $topup->expired_at?->toIso8601String() }}')"
                 x-init="startCountdown()">

                {{-- Header --}}
                <div class="p-6 border-b border-gray-100 text-center">
                    <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
                    <p class="text-3xl font-extrabold text-brand-900">Rp {{ number_format($topup->amount, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">Ref: {{ $topup->reference_id }}</p>
                </div>

                {{-- QR Code --}}
                <div class="p-8 flex flex-col items-center">
                    @if($topup->qr_code_url)
                        <div class="bg-white p-4 rounded-2xl border-2 border-dashed border-gray-200 mb-6">
                            <img src="{{ $topup->qr_code_url }}" alt="QRIS QR Code" class="w-64 h-64 object-contain" />
                        </div>
                    @endif

                    <p class="text-sm text-gray-600 font-medium mb-2">Scan menggunakan aplikasi e-wallet</p>
                    <div class="flex flex-wrap items-center justify-center gap-2 text-xs text-gray-400 mb-6">
                        <span class="px-2 py-1 bg-gray-100 rounded-md">GoPay</span>
                        <span class="px-2 py-1 bg-gray-100 rounded-md">OVO</span>
                        <span class="px-2 py-1 bg-gray-100 rounded-md">Dana</span>
                        <span class="px-2 py-1 bg-gray-100 rounded-md">ShopeePay</span>
                        <span class="px-2 py-1 bg-gray-100 rounded-md">Mobile Banking</span>
                    </div>

                    {{-- Countdown Timer --}}
                    <div class="w-full bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
                        <p class="text-xs text-amber-600 font-medium mb-1">Selesaikan pembayaran dalam</p>
                        <p class="text-2xl font-bold text-amber-700 font-mono" x-text="timeDisplay">--:--</p>
                        <template x-if="isExpired">
                            <p class="text-xs text-red-500 font-medium mt-1">Waktu habis! Silakan buat top-up baru.</p>
                        </template>
                    </div>
                </div>

                {{-- Instructions --}}
                <div class="px-6 pb-6">
                    <div class="bg-gray-50 rounded-xl p-5">
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Cara Pembayaran:</h4>
                        <ol class="text-sm text-gray-500 space-y-2">
                            <li class="flex gap-2">
                                <span class="w-5 h-5 bg-brand-100 text-brand-700 rounded-full flex items-center justify-center text-xs font-bold shrink-0">1</span>
                                Buka aplikasi e-wallet atau mobile banking Anda.
                            </li>
                            <li class="flex gap-2">
                                <span class="w-5 h-5 bg-brand-100 text-brand-700 rounded-full flex items-center justify-center text-xs font-bold shrink-0">2</span>
                                Pilih menu "Scan QR" atau "Bayar QRIS".
                            </li>
                            <li class="flex gap-2">
                                <span class="w-5 h-5 bg-brand-100 text-brand-700 rounded-full flex items-center justify-center text-xs font-bold shrink-0">3</span>
                                Scan kode QR di atas, lalu konfirmasi pembayaran.
                            </li>
                            <li class="flex gap-2">
                                <span class="w-5 h-5 bg-brand-100 text-brand-700 rounded-full flex items-center justify-center text-xs font-bold shrink-0">4</span>
                                Saldo otomatis bertambah setelah pembayaran dikonfirmasi.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('customer.topup.index') }}" class="text-sm text-gray-500 hover:text-brand-600 transition-colors">
                    ← Kembali ke halaman saldo
                </a>
            </div>
        @endif
    </div>

    {{-- Countdown Timer Script --}}
    @push('scripts')
    @endpush
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('qrisCountdown', (expiredAtStr) => ({
                timeDisplay: '--:--',
                isExpired: false,
                intervalId: null,

                startCountdown() {
                    if (!expiredAtStr) {
                        this.timeDisplay = '--:--';
                        return;
                    }

                    const expiredAt = new Date(expiredAtStr).getTime();

                    this.intervalId = setInterval(() => {
                        const now = Date.now();
                        const diff = expiredAt - now;

                        if (diff <= 0) {
                            this.timeDisplay = '00:00';
                            this.isExpired = true;
                            clearInterval(this.intervalId);
                            // Reload page after 2 seconds to show expired state
                            setTimeout(() => window.location.reload(), 2000);
                            return;
                        }

                        const minutes = Math.floor(diff / 60000);
                        const seconds = Math.floor((diff % 60000) / 1000);
                        this.timeDisplay = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
                    }, 1000);
                },

                destroy() {
                    if (this.intervalId) clearInterval(this.intervalId);
                }
            }));
        });
    </script>
</x-customer-layout>
