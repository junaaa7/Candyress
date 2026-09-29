<x-customer-layout>
    <x-slot name="header">
        Detail Pesanan #{{ $order->order_number }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Back Button --}}
            <div>
                <a href="{{ route('customer.orders.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors">
                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Pesanan
                </a>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-start">
                    <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-start">
                    <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Status Alert Banners --}}
            @if($order->status === 'completed')
                <div class="p-6 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl text-white shadow-sm border border-green-400">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-3xl">🎉</span>
                        <h3 class="text-xl font-bold">Pesanan Selesai!</h3>
                    </div>
                    <p class="mb-4 text-green-50">Terima kasih atas pesanan Anda. Berikut adalah detail akun untuk pesanan ini:</p>
                    
                    @if($order->account_credentials)
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <pre class="font-mono text-sm whitespace-pre-wrap break-words text-white select-all">{{ $order->account_credentials }}</pre>
                            <p class="text-xs text-green-100 mt-2 italic flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Blok dan copy (salin) detail di atas.
                            </p>
                        </div>
                    @else
                        <p class="text-sm text-green-100 italic">Kredensial akun belum tersedia.</p>
                    @endif
                </div>
            @elseif($order->status === 'pending')
                <div class="p-5 bg-yellow-50 border border-yellow-200 rounded-2xl flex items-start shadow-sm">
                    <div class="text-2xl mr-4 flex-shrink-0">⏳</div>
                    <div>
                        <h3 class="font-bold text-yellow-800 text-lg mb-1">Menunggu Pembayaran</h3>
                        <p class="text-yellow-700 text-sm">
                            Silakan selesaikan pembayaran sebesar <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> menggunakan metode <strong>{{ $order->payment_method ?? 'Transfer Bank' }}</strong>.
                        </p>
                    </div>
                </div>
            @elseif($order->status === 'processing')
                <div class="p-5 bg-blue-50 border border-blue-200 rounded-2xl flex items-start shadow-sm">
                    <div class="text-2xl mr-4 flex-shrink-0">⚙️</div>
                    <div>
                        <h3 class="font-bold text-blue-800 text-lg mb-1">Sedang Diproses</h3>
                        <p class="text-blue-700 text-sm">Pembayaran Anda sedang diverifikasi oleh admin. Kami akan memproses pesanan Anda secepatnya.</p>
                    </div>
                </div>
            @elseif($order->status === 'cancelled')
                <div class="p-5 bg-red-50 border border-red-200 rounded-2xl flex items-start shadow-sm">
                    <div class="text-2xl mr-4 flex-shrink-0">❌</div>
                    <div>
                        <h3 class="font-bold text-red-800 text-lg mb-1">Pesanan Dibatalkan</h3>
                        <p class="text-red-700 text-sm">Pesanan ini telah dibatalkan.</p>
                    </div>
                </div>
            @endif

            {{-- Payment Rejection Alert --}}
            @if($order->payment && $order->payment->status === 'rejected')
                <div class="p-5 bg-red-50 border border-red-200 rounded-2xl flex items-start shadow-sm">
                    <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold text-red-800 mb-1">Pembayaran Ditolak</h3>
                        <p class="text-red-700 text-sm">
                            <strong>Alasan:</strong> {{ $order->payment->rejection_reason ?? 'Bukti pembayaran tidak valid.' }}<br>
                            Silakan unggah kembali bukti pembayaran yang benar.
                        </p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Left Card: Informasi Pesanan --}}
                <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-800">Informasi Pesanan</h3>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between pb-4 border-b border-gray-50">
                                <dt class="text-sm text-gray-500">Nomor Pesanan</dt>
                                <dd class="text-sm font-medium text-gray-900 font-mono">#{{ $order->order_number }}</dd>
                            </div>
                            <div class="flex justify-between pb-4 border-b border-gray-50">
                                <dt class="text-sm text-gray-500">Tanggal Pesanan</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                            <div class="flex justify-between pb-4 border-b border-gray-50 items-center">
                                <dt class="text-sm text-gray-500">Status Pesanan</dt>
                                <dd>
                                    @if($order->status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            Menunggu
                                        </span>
                                    @elseif($order->status == 'processing')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                            Diproses
                                        </span>
                                    @elseif($order->status == 'completed')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Selesai
                                        </span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div class="flex justify-between pb-4 border-b border-gray-50">
                                <dt class="text-sm text-gray-500">Metode Pembayaran</dt>
                                <dd class="text-sm font-medium text-gray-900 uppercase">{{ $order->payment_method ?? 'Transfer Bank' }}</dd>
                            </div>
                            <div class="flex justify-between items-center">
                                <dt class="text-sm text-gray-500">Status Pembayaran</dt>
                                <dd>
                                    @php
                                        $paymentStatus = $order->payment ? $order->payment->status : 'pending';
                                    @endphp
                                    
                                    @if($paymentStatus == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($paymentStatus == 'approved')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Disetujui
                                        </span>
                                    @elseif($paymentStatus == 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            Ditolak
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Right Card: Produk yang Dibeli --}}
                <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-800">Produk yang Dibeli</h3>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="space-y-4 flex-1">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $item->product_name ?? 'Produk' }}</h4>
                                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">
                                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-base font-bold text-gray-900">Total Pembayaran</span>
                                <span class="text-lg font-bold text-brand-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
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
                <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden mt-6">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-lg font-semibold text-gray-800">Upload Bukti Pembayaran</h3>
                    </div>
                    <div class="p-6">
                        @if($order->payment && $order->payment->payment_proof)
                            <div class="mb-6">
                                <p class="text-sm text-gray-600 mb-3 font-medium">Bukti Pembayaran Terakhir:</p>
                                <div class="relative w-48 h-64 border rounded-xl overflow-hidden bg-gray-100 group">
                                    <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" alt="Bukti Pembayaran" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ asset('storage/' . $order->payment->payment_proof) }}" target="_blank" class="text-white bg-black/50 px-3 py-1.5 rounded-lg text-sm hover:bg-black/70">
                                            Lihat Penuh
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('customer.payment.upload', $order->order_number) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="space-y-4 max-w-md">
                                <div>
                                    <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pilih File (JPG, JPEG, PNG, max 2MB)
                                    </label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-brand-500 transition-colors bg-gray-50/50">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-medium text-brand-600 hover:text-brand-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-500">
                                                    <span>Upload file</span>
                                                    <input id="payment_proof" name="payment_proof" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, JPEG up to 2MB
                                            </p>
                                        </div>
                                    </div>
                                    @error('payment_proof')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
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