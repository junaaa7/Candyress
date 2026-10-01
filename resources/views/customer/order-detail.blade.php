<x-customer-layout>
    <x-slot name="header">
        Detail Pesanan #{{ $order->order_number }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Back Button --}}
            <div>
                <a href="{{ route('customer.orders.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Pesanan
                </a>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="flex items-start rounded-2xl border-2 border-dashed border-emerald-300 bg-mint p-4 font-bold text-emerald-700">
                    <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-start rounded-2xl border-2 border-dashed border-brand-300 bg-brand-100 p-4 font-bold text-rose-700">
                    <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Status Alert Banners --}}
            @if($order->status === 'completed')
                <div class="rounded-4xl bg-gradient-to-r from-emerald-400 to-emerald-500 p-6 text-white shadow-xl shadow-emerald-500/20">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-3xl">🎉</span>
                        <h3 class="text-xl font-bold">Pesanan Selesai!</h3>
                    </div>
                    <p class="mb-4 text-emerald-50">Terima kasih atas pesanan Anda. Berikut adalah detail akun untuk pesanan ini:</p>

                    @if($order->account_credentials)
                        <div class="rounded-2xl border-2 border-white/30 bg-white/15 p-4 backdrop-blur-sm">
                            <pre class="font-mono text-sm whitespace-pre-wrap break-words text-white select-all">{{ $order->account_credentials }}</pre>
                            <p class="mt-2 flex items-center text-xs italic text-emerald-50">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Blok dan copy (salin) detail di atas.
                            </p>
                        </div>
                    @else
                        <p class="text-sm italic text-emerald-50">Kredensial akun belum tersedia.</p>
                    @endif
                </div>
            @elseif($order->status === 'pending')
                <div class="flex items-start rounded-4xl border-2 border-amber-200 bg-amber-50 p-5">
                    <div class="text-2xl mr-4 flex-shrink-0">⏳</div>
                    <div>
                        <h3 class="mb-1 text-lg font-bold text-amber-800">Menunggu Pembayaran</h3>
                        <p class="text-sm text-amber-700">
                            Silakan selesaikan pembayaran sebesar <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> menggunakan metode <strong>{{ $order->payment_method ?? 'Transfer Bank' }}</strong>.
                        </p>
                    </div>
                </div>
            @elseif($order->status === 'processing')
                <div class="flex items-start rounded-4xl border-2 border-accent-200 bg-accent-100 p-5">
                    <div class="text-2xl mr-4 flex-shrink-0">⚙️</div>
                    <div>
                        <h3 class="mb-1 text-lg font-bold text-purple-700">Sedang Diproses</h3>
                        <p class="text-sm text-purple-600">Pembayaran Anda sedang diverifikasi oleh admin. Kami akan memproses pesanan Anda secepatnya.</p>
                    </div>
                </div>
            @elseif($order->status === 'cancelled')
                <div class="flex items-start rounded-4xl border-2 border-brand-300 bg-brand-100 p-5">
                    <div class="text-2xl mr-4 flex-shrink-0">❌</div>
                    <div>
                        <h3 class="mb-1 text-lg font-bold text-rose-700">Pesanan Dibatalkan</h3>
                        <p class="text-sm text-rose-600">Pesanan ini telah dibatalkan.</p>
                    </div>
                </div>
            @endif

            {{-- Payment Rejection Alert --}}
            @if($order->payment && $order->payment->status === 'rejected')
                <div class="flex items-start rounded-4xl border-2 border-brand-300 bg-brand-100 p-5">
                    <svg class="w-6 h-6 mr-3 mt-0.5 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="mb-1 font-bold text-rose-700">Pembayaran Ditolak</h3>
                        <p class="text-sm text-rose-600">
                            <strong>Alasan:</strong> {{ $order->payment->rejection_reason ?? 'Bukti pembayaran tidak valid.' }}<br>
                            Silakan unggah kembali bukti pembayaran yang benar.
                        </p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Left Card: Informasi Pesanan --}}
                <div class="cute-card overflow-hidden">
                    <div class="border-b-2 border-dashed border-brand-100 bg-brand-100/60 px-6 py-5">
                        <h3 class="text-lg font-semibold">Informasi Pesanan</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between border-b-2 border-dashed border-brand-100 pb-4">
                                <dt class="text-sm text-mauve">Nomor Pesanan</dt>
                                <dd class="font-mono text-sm font-bold">#{{ $order->order_number }}</dd>
                            </div>
                            <div class="flex justify-between border-b-2 border-dashed border-brand-100 pb-4">
                                <dt class="text-sm text-mauve">Tanggal Pesanan</dt>
                                <dd class="text-sm font-bold">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                            <div class="flex items-center justify-between border-b-2 border-dashed border-brand-100 pb-4">
                                <dt class="text-sm text-mauve">Status Pesanan</dt>
                                <dd>
                                    @if($order->status == 'pending')
                                        <span class="inline-flex items-center rounded-full border-2 border-amber-200 bg-amber-50 px-3 py-0.5 text-xs font-bold text-amber-700">
                                            Menunggu
                                        </span>
                                    @elseif($order->status == 'processing')
                                        <span class="inline-flex items-center rounded-full border-2 border-accent-200 bg-accent-100 px-3 py-0.5 text-xs font-bold text-purple-600">
                                            Diproses
                                        </span>
                                    @elseif($order->status == 'completed')
                                        <span class="inline-flex items-center rounded-full border-2 border-emerald-200 bg-mint px-3 py-0.5 text-xs font-bold text-emerald-700">
                                            Selesai
                                        </span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="inline-flex items-center rounded-full border-2 border-brand-300 bg-brand-100 px-3 py-0.5 text-xs font-bold text-rose-600">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div class="flex justify-between border-b-2 border-dashed border-brand-100 pb-4">
                                <dt class="text-sm text-mauve">Metode Pembayaran</dt>
                                <dd class="text-sm font-bold uppercase">{{ $order->payment_method ?? 'Transfer Bank' }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-mauve">Status Pembayaran</dt>
                                <dd>
                                    @php
                                        $paymentStatus = $order->payment ? $order->payment->status : 'pending';
                                    @endphp

                                    @if($paymentStatus == 'pending')
                                        <span class="inline-flex items-center rounded-full border-2 border-amber-200 bg-amber-50 px-3 py-0.5 text-xs font-bold text-amber-700">
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($paymentStatus == 'approved')
                                        <span class="inline-flex items-center rounded-full border-2 border-emerald-200 bg-mint px-3 py-0.5 text-xs font-bold text-emerald-700">
                                            Disetujui
                                        </span>
                                    @elseif($paymentStatus == 'rejected')
                                        <span class="inline-flex items-center rounded-full border-2 border-brand-300 bg-brand-100 px-3 py-0.5 text-xs font-bold text-rose-600">
                                            Ditolak
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Right Card: Produk yang Dibeli --}}
                <div class="cute-card flex flex-col overflow-hidden">
                    <div class="border-b-2 border-dashed border-brand-100 bg-brand-100/60 px-6 py-5">
                        <h3 class="text-lg font-semibold">Produk yang Dibeli 🛍️</h3>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <div class="flex-1 space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between border-b-2 border-dashed border-brand-100 pb-4 last:border-0 last:pb-0">
                                    <div>
                                        <h4 class="text-sm font-bold">{{ $item->product_name ?? 'Produk' }}</h4>
                                        <p class="text-sm text-mauve">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-sm font-bold">
                                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 border-t-2 border-dashed border-brand-300 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base font-bold">Total Pembayaran</span>
                                <span class="font-display text-lg font-bold text-brand-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Upload Bukti Pembayaran Section --}}
            @php
                $paymentStatus = $order->payment ? $order->payment->status : 'pending';
                $showUpload = $order->status === 'pending' || in_array($paymentStatus, ['pending', 'rejected']);
            @endphp

            @if($showUpload && $order->status !== 'cancelled')
                <div class="cute-card mt-6 overflow-hidden">
                    <div class="border-b-2 border-dashed border-brand-100 bg-brand-100/60 px-6 py-5">
                        <h3 class="text-lg font-semibold">Upload Bukti Pembayaran 🧾</h3>
                    </div>
                    <div class="p-6">
                        @if($order->payment && $order->payment->payment_proof)
                            <div class="mb-6">
                                <p class="mb-3 text-sm font-bold text-mauve">Bukti Pembayaran Terakhir:</p>
                                <div class="group relative h-64 w-48 overflow-hidden rounded-2xl border-2 border-brand-100 bg-brand-50">
                                    <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" alt="Bukti Pembayaran" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 flex items-center justify-center bg-brand-900/40 opacity-0 transition-opacity group-hover:opacity-100">
                                        <a href="{{ asset('storage/' . $order->payment->payment_proof) }}" target="_blank" rel="noopener" class="rounded-full bg-white px-4 py-1.5 text-sm font-bold text-brand-600 hover:bg-brand-50">
                                            Lihat Penuh
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('customer.payment.upload', $order->order_number) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="max-w-md space-y-4">
                                <div>
                                    <label for="payment_proof" class="cute-label">
                                        Pilih File (JPG, JPEG, PNG, max 2MB)
                                    </label>
                                    <div class="mt-1 flex justify-center rounded-2xl border-2 border-dashed border-brand-300 bg-brand-50/60 px-6 pb-6 pt-5 transition-colors hover:border-brand-600">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-brand-300" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex justify-center text-sm">
                                                <label for="payment_proof" class="relative cursor-pointer rounded-md font-bold text-brand-600 hover:text-brand-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-brand-300 focus-within:ring-offset-2">
                                                    <span>Upload file</span>
                                                    <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                                                </label>
                                            </div>
                                            <p class="text-xs text-mauve">
                                                PNG, JPG, JPEG up to 2MB
                                            </p>
                                        </div>
                                    </div>
                                    @error('payment_proof')
                                        <p class="mt-2 text-sm font-semibold text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="cute-btn cute-btn-primary w-full py-2.5 text-sm">
                                        Upload Bukti Pembayaran
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-customer-layout>