<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-display text-xl font-semibold leading-tight">
            {{ __('Pembayaran Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Info Card --}}
            <div class="mb-6 flex items-start space-x-3 rounded-2xl border-2 border-dashed border-brand-300 bg-brand-100/60 p-4">
                <svg class="w-6 h-6 mt-0.5 flex-shrink-0 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm font-semibold">
                    <p>Setelah checkout, upload bukti pembayaran Anda di sini. Admin akan memverifikasi dalam 1-5 menit.</p>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-6 rounded-2xl border-2 border-dashed border-emerald-300 bg-mint px-4 py-3 font-bold text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border-2 border-dashed border-brand-300 bg-brand-100 px-4 py-3 font-bold text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Payments List --}}
            @forelse ($orders as $order)
                <div class="cute-card mb-4 p-6">
                    {{-- Header Row --}}
                    <div class="mb-4 flex items-center justify-between border-b-2 border-dashed border-brand-100 pb-4">
                        <h3 class="text-lg font-semibold">
                            Pesanan <span class="text-brand-600">#{{ $order->order_number }}</span>
                        </h3>
                        <div>
                            @if ($order->payment)
                                @if ($order->payment->payment_status === 'pending')
                                    <span class="inline-flex items-center rounded-full border-2 border-amber-200 bg-amber-50 px-3.5 py-1 text-xs font-bold text-amber-700">
                                        Menunggu Verifikasi
                                    </span>
                                @elseif ($order->payment->payment_status === 'approved')
                                    <span class="inline-flex items-center rounded-full border-2 border-emerald-200 bg-mint px-3.5 py-1 text-xs font-bold text-emerald-700">
                                        Terverifikasi
                                    </span>
                                @elseif ($order->payment->payment_status === 'rejected')
                                    <span class="inline-flex items-center rounded-full border-2 border-brand-300 bg-brand-100 px-3.5 py-1 text-xs font-bold text-rose-600">
                                        Ditolak
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center rounded-full border-2 border-brand-200 bg-brand-50 px-3.5 py-1 text-xs font-bold text-mauve">
                                    Belum Dibayar
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Info Grid --}}
                    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                        @if ($order->payment)
                            <div>
                                <p class="text-sm text-mauve">Metode</p>
                                <p class="font-bold">{{ $order->payment->payment_method }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-mauve">Jumlah</p>
                                <p class="font-bold">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                            </div>
                        @else
                            <div>
                                <p class="text-sm text-mauve">Jumlah Tagihan</p>
                                <p class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-mauve">Tanggal</p>
                            <p class="font-bold">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-mauve">Status Pesanan</p>
                            <div class="mt-1">
                                @if ($order->status === 'pending')
                                    <span class="inline-flex items-center rounded-full border-2 border-amber-200 bg-amber-50 px-3 py-0.5 text-xs font-bold text-amber-700">Menunggu Pembayaran</span>
                                @elseif ($order->status === 'processing')
                                    <span class="inline-flex items-center rounded-full border-2 border-accent-200 bg-accent-100 px-3 py-0.5 text-xs font-bold text-purple-600">Diproses</span>
                                @elseif ($order->status === 'shipped')
                                    <span class="inline-flex items-center rounded-full border-2 border-accent-200 bg-accent-50 px-3 py-0.5 text-xs font-bold text-purple-600">Dikirim</span>
                                @elseif ($order->status === 'delivered')
                                    <span class="inline-flex items-center rounded-full border-2 border-emerald-200 bg-mint px-3 py-0.5 text-xs font-bold text-emerald-700">Selesai</span>
                                @elseif ($order->status === 'cancelled')
                                    <span class="inline-flex items-center rounded-full border-2 border-brand-300 bg-brand-100 px-3 py-0.5 text-xs font-bold text-rose-600">Dibatalkan</span>
                                @else
                                    <span class="inline-flex items-center rounded-full border-2 border-brand-200 bg-brand-50 px-3 py-0.5 text-xs font-bold text-mauve">{{ ucfirst($order->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($order->payment)
                        {{-- Uploaded Proof & Rejection Reason --}}
                        @if ($order->payment->payment_proof)
                            <div class="mb-6">
                                <p class="mb-2 text-sm text-mauve">Bukti Pembayaran</p>
                                <a href="{{ asset('storage/' . $order->payment->payment_proof) }}" target="_blank" rel="noopener" class="group relative inline-block">
                                    <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" alt="Bukti Pembayaran" class="h-32 w-32 rounded-2xl border-2 border-brand-100 object-cover">
                                    <div class="absolute inset-0 flex items-center justify-center rounded-2xl bg-brand-900/0 transition-all group-hover:bg-brand-900/30">
                                        <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if ($order->payment->payment_status === 'rejected' && $order->payment->rejection_reason)
                            <div class="mb-6 flex items-start space-x-2 rounded-2xl border-2 border-brand-300 bg-brand-100 p-4 text-sm text-rose-700">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-bold">Alasan Penolakan:</p>
                                    <p class="mt-1">{{ $order->payment->rejection_reason }}</p>
                                </div>
                            </div>
                        @endif
                    @endif

                    {{-- Action Area --}}
                    <div class="mt-4 border-t-2 border-dashed border-brand-100 pt-4">
                        @if ($order->payment && $order->payment->payment_status === 'approved')
                            <div class="flex items-center text-sm font-bold text-emerald-600">
                                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Pembayaran Terverifikasi
                            </div>
                        @elseif ($order->status === 'pending' && (!$order->payment || in_array($order->payment->payment_status, ['pending', 'rejected'])))
                            <form action="{{ route('customer.payment.upload', $order->order_number) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3 sm:flex-row">
                                @csrf
                                <div class="flex-1">
                                    <label class="cute-label">
                                        Upload Bukti Transfer
                                    </label>
                                    <input type="file" name="payment_proof" accept="image/*" required class="block w-full rounded-2xl border-2 border-brand-100 bg-brand-50 p-1.5 text-sm text-mauve
                                        file:mr-4 file:cursor-pointer file:rounded-full file:border-0
                                        file:bg-brand-100 file:px-4 file:py-2
                                        file:text-sm file:font-bold file:text-brand-600
                                        hover:file:bg-brand-200">
                                    @error('payment_proof')
                                        <p class="mt-1 text-sm font-semibold text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-end">
                                    <button type="submit" class="cute-btn cute-btn-primary w-full px-6 py-2.5 text-sm sm:w-auto">
                                        Upload Bukti
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="cute-card p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold">Belum ada riwayat pembayaran</h3>
                    <p class="mt-2 text-mauve">Anda belum memiliki pesanan atau pembayaran apapun.</p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}" class="cute-btn cute-btn-primary px-6 py-2.5 text-sm">
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            @endforelse

            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>
    </div>
</x-customer-layout>