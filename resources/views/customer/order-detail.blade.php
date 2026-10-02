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

                    @php
                        $hasCredentials = false;
                        foreach($order->items as $item) {
                            if($item->productStock) {
                                $hasCredentials = true;
                                break;
                            }
                        }
                    @endphp

                    @if($hasCredentials)
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                @if($item->productStock)
                                    <div class="rounded-2xl border-2 border-white/30 bg-white/15 p-5 backdrop-blur-sm relative" x-data="{ copied: false }">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-bold text-white">{{ $item->product->name ?? 'Akun' }}</h4>
                                            
                                            <!-- Tombol Salin -->
                                            <button @click="
                                                let textToCopy = `Email: {{ $item->productStock->email }}\nPassword: {{ $item->productStock->password }}\n{{ $item->productStock->token_or_pin ? 'PIN/Token: ' . $item->productStock->token_or_pin : '' }}`;
                                                navigator.clipboard.writeText(textToCopy.trim());
                                                copied = true;
                                                setTimeout(() => copied = false, 2000);
                                            " class="inline-flex items-center gap-1.5 px-3 py-1 bg-white text-emerald-600 rounded-lg text-xs font-bold shadow-sm hover:bg-emerald-50 transition-colors">
                                                <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                <svg x-show="copied" style="display: none;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                <span x-text="copied ? 'Tersalin!' : 'Salin'">Salin</span>
                                            </button>
                                        </div>

                                        <div class="font-mono text-sm whitespace-pre-wrap break-words text-white bg-black/20 p-3 rounded-xl mb-3">Email: {{ $item->productStock->email }}
Password: {{ $item->productStock->password }}
@if($item->productStock->token_or_pin)
PIN/Token: {{ $item->productStock->token_or_pin }}
@endif
@if($item->productStock->additional_info)
Info Tambahan: {{ $item->productStock->additional_info }}
@endif
</div>

                                        <!-- Instruksi Login (Jika ada) -->
                                        @if($item->product->login_instructions)
                                            <div class="mt-3 text-sm text-emerald-50 bg-emerald-900/30 p-3 rounded-xl border border-emerald-400/30">
                                                <span class="font-bold block mb-1">💡 Cara Login:</span>
                                                <p class="whitespace-pre-wrap">{{ $item->product->login_instructions }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- Tampilkan S&K Produk --}}
                        @php
                            $hasTnC = false;
                            foreach($order->items as $item) {
                                if($item->product && (!empty($item->product->terms_and_conditions) || !empty($item->product->terms))) {
                                    $hasTnC = true;
                                    break;
                                }
                            }
                        @endphp
                        
                        @if($hasTnC)
                            <div class="mt-4 rounded-2xl border-2 border-amber-300 bg-amber-50 p-4 text-amber-900 shadow-sm">
                                <h4 class="mb-2 font-bold flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Peringatan & Syarat Ketentuan Aplikasi
                                </h4>
                                <div class="space-y-3">
                                    @foreach($order->items as $item)
                                        @if($item->product && (!empty($item->product->terms_and_conditions) || !empty($item->product->terms)))
                                            <div class="text-sm">
                                                <span class="font-bold text-amber-800 border-b border-amber-200 pb-0.5 inline-block mb-1">{{ $item->product->name }}</span>
                                                <p class="whitespace-pre-wrap text-amber-700">{{ !empty($item->product->terms_and_conditions) ? $item->product->terms_and_conditions : $item->product->terms }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    @else
                        <p class="text-sm italic text-emerald-50">Kredensial akun belum tersedia.</p>
                    @endif
                </div>
            @elseif($order->status === 'pending')
                @if(stripos($order->payment_method, 'qris') !== false)
                    <div class="rounded-4xl border-2 border-brand-300 bg-white p-6 shadow-xl shadow-brand-500/10">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold text-brand-700 mb-2">Selesaikan Pembayaran QRIS</h3>
                            <p class="text-sm text-mauve">Sisa waktu pembayaran: <span class="font-bold text-rose-600">23:59:59</span></p>
                        </div>
                        
                        <div class="flex flex-col items-center mb-6">
                            <div class="bg-brand-50 p-4 rounded-3xl border-2 border-brand-200 shadow-md">
                                <img src="{{ asset('images/payments/qris.jpg') }}" alt="QRIS Payment" class="w-full max-w-[320px] rounded-2xl object-contain">
                            </div>
                            <div class="mt-4">
                                <a href="{{ asset('images/payments/qris.jpg') }}" download="QRIS-Candyress.jpg" class="cute-btn cute-btn-ghost px-5 py-2 text-sm border-2 border-brand-300 hover:bg-brand-50 text-brand-700">
                                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh QRIS
                                </a>
                            </div>
                        </div>

                        <div class="bg-amber-50 rounded-2xl p-5 border-2 border-amber-200">
                            <h4 class="font-bold text-amber-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Cara Pembayaran:
                            </h4>
                            <ol class="list-decimal list-inside space-y-2 text-sm text-amber-800">
                                <li>Scan QRIS menggunakan aplikasi e-wallet atau mobile banking apa saja (GoPay, OVO, Dana, BCA, dll).</li>
                                <li>Masukkan nominal persis: <strong class="text-brand-600 text-base">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></li>
                                <li>Simpan / tangkap layar bukti pembayaran Anda.</li>
                                <li>Upload bukti transfer di form bawah ATAU konfirmasi langsung via WhatsApp.</li>
                            </ol>
                            
                            @php
                                $waText = urlencode("Halo Admin Candyress, saya ingin mengkonfirmasi pembayaran pesanan saya.\n\nNomor Order: #{$order->order_number}\nTotal Bayar: Rp " . number_format($order->total_price, 0, ',', '.') . "\n\nBerikut saya lampirkan bukti pembayarannya.");
                            @endphp
                            <div class="mt-4 pt-4 border-t border-amber-200 text-center">
                                <a href="https://wa.me/6281371711181?text={{ $waText }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center w-full sm:w-auto rounded-full bg-[#25D366] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#25D366]/30 hover:bg-[#128C7E] transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.012c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                    Konfirmasi via WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-start rounded-4xl border-2 border-amber-200 bg-amber-50 p-5">
                        <div class="text-2xl mr-4 flex-shrink-0">⏳</div>
                        <div>
                            <h3 class="mb-1 text-lg font-bold text-amber-800">Menunggu Pembayaran</h3>
                            <p class="text-sm text-amber-700">
                                Silakan selesaikan pembayaran sebesar <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> menggunakan metode <strong>{{ $order->payment_method ?? 'Transfer Bank' }}</strong>.
                            </p>
                        </div>
                    </div>
                @endif
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
                                {{-- Kotak diperlebar (max-w-xs) dan gambar menggunakan object-contain --}}
                                <div class="group relative h-64 w-full max-w-xs overflow-hidden rounded-2xl border-2 border-brand-100 bg-brand-50 p-2">
                                    <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" alt="Bukti Pembayaran" class="w-full h-full object-contain">
                                    <div class="absolute inset-0 flex items-center justify-center bg-brand-900/40 opacity-0 transition-opacity group-hover:opacity-100 rounded-2xl">
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
                                                    {{-- Note: Menambahkan id yang sesuai dengan label agar bisa diklik --}}
                                                    <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg" required>
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