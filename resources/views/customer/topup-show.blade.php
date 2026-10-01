<x-customer-layout>
    <x-slot name="title">Pembayaran QRIS</x-slot>
    <x-slot name="header">Pembayaran QRIS</x-slot>

    <div class="max-w-lg mx-auto space-y-6">
        {{-- Status Cards --}}
        @if($topup->payment_status === 'paid')
            {{-- SUCCESS --}}
            <div class="cute-card border-emerald-200 p-8 text-center shadow-[0_6px_0_theme(colors.mint)]">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-mint text-emerald-700">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <h3 class="mb-1 text-xl font-bold text-emerald-700">Pembayaran Berhasil! 🎉</h3>
                <p class="mb-4 text-sm text-mauve">Saldo Anda sudah ditambahkan.</p>
                <div class="mb-6 rounded-2xl border-2 border-dashed border-emerald-300 bg-mint p-4">
                    <p class="text-sm font-bold text-emerald-700">Jumlah Top-Up</p>
                    <p class="font-display text-2xl font-bold text-emerald-700">Rp {{ number_format($topup->amount, 0, ',', '.') }}</p>
                </div>
                <a href="{{ route('customer.topup.index') }}" class="cute-btn cute-btn-primary px-6 py-3">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                    Kembali ke Saldo
                </a>
            </div>
        @elseif($topup->payment_status === 'expired' || ($topup->expired_at && $topup->expired_at->isPast()))
            {{-- EXPIRED --}}
            <div class="cute-card p-8 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-brand-100 text-brand-300">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h3 class="mb-1 text-xl font-bold">Pembayaran Kedaluwarsa</h3>
                <p class="mb-6 text-sm text-mauve">Kode QRIS sudah tidak berlaku. Silakan buat top-up baru.</p>
                <a href="{{ route('customer.topup.index') }}" class="cute-btn cute-btn-primary px-6 py-3">
                    Buat Top-Up Baru
                </a>
            </div>
        @elseif($topup->payment_status === 'failed')
            {{-- FAILED --}}
            <div class="cute-card border-brand-300 p-8 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-brand-100 text-rose-500">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>
                <h3 class="mb-1 text-xl font-bold text-rose-700">Pembayaran Gagal</h3>
                <p class="mb-6 text-sm text-mauve">Terjadi masalah pada pembayaran. Silakan coba lagi.</p>
                <a href="{{ route('customer.topup.index') }}" class="cute-btn cute-btn-primary px-6 py-3">
                    Buat Top-Up Baru
                </a>
            </div>
        @else
            {{-- PENDING — Show QRIS --}}
            <div class="cute-card overflow-hidden"
                 x-data="qrisCountdown('{{ $topup->expired_at?->toIso8601String() }}')"
                 x-init="startCountdown()">

                {{-- Header --}}
                <div class="border-b-2 border-dashed border-brand-100 bg-brand-100/60 p-6 text-center">
                    <p class="mb-1 text-sm text-mauve">Total Pembayaran</p>
                    <p class="font-display text-3xl font-bold text-brand-600">Rp {{ number_format($topup->amount, 0, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-mauve">Ref: {{ $topup->reference_id }}</p>
                </div>

                {{-- QR Code --}}
                <div class="flex flex-col items-center p-8">
                    @if($topup->qr_code_url)
                        <div class="mb-6 rounded-2xl border-2 border-dashed border-brand-300 bg-white p-4">
                            <img src="{{ $topup->qr_code_url }}" alt="QRIS QR Code" class="w-64 h-64 object-contain" />
                        </div>
                    @endif

                    <p class="mb-2 text-sm font-bold">Scan menggunakan aplikasi e-wallet</p>
                    <div class="mb-6 flex flex-wrap items-center justify-center gap-2 text-xs font-bold text-brand-600">
                        <span class="rounded-lg bg-brand-100 px-2.5 py-1">GoPay</span>
                        <span class="rounded-lg bg-brand-100 px-2.5 py-1">OVO</span>
                        <span class="rounded-lg bg-brand-100 px-2.5 py-1">Dana</span>
                        <span class="rounded-lg bg-brand-100 px-2.5 py-1">ShopeePay</span>
                        <span class="rounded-lg bg-brand-100 px-2.5 py-1">Mobile Banking</span>
                    </div>

                    {{-- Countdown Timer --}}
                    <div class="w-full rounded-2xl border-2 border-amber-200 bg-amber-50 p-4 text-center">
                        <p class="mb-1 text-xs font-bold text-amber-600">Selesaikan pembayaran dalam</p>
                        <p class="font-mono text-2xl font-bold text-amber-700" x-text="timeDisplay">--:--</p>
                        <template x-if="isExpired">
                            <p class="mt-1 text-xs font-bold text-rose-600">Waktu habis! Silakan buat top-up baru.</p>
                        </template>
                    </div>
                </div>

                {{-- Instructions --}}
                <div class="px-6 pb-6">
                    <div class="rounded-2xl bg-brand-50 p-5">
                        <h4 class="mb-3 text-sm font-bold">Cara Pembayaran:</h4>
                        <ol class="space-y-2 text-sm text-mauve">
                            <li class="flex gap-2">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-600">1</span>
                                Buka aplikasi e-wallet atau mobile banking Anda.
                            </li>
                            <li class="flex gap-2">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-600">2</span>
                                Pilih menu "Scan QR" atau "Bayar QRIS".
                            </li>
                            <li class="flex gap-2">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-600">3</span>
                                Scan kode QR di atas, lalu konfirmasi pembayaran.
                            </li>
                            <li class="flex gap-2">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-600">4</span>
                                Saldo otomatis bertambah setelah pembayaran dikonfirmasi.
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('customer.topup.index') }}" class="cute-link text-sm">
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