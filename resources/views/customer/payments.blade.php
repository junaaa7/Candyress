<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Info Card --}}
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mb-6 flex items-start space-x-3">
                <svg class="w-6 h-6 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-blue-800 text-sm">
                    <p>Setelah checkout, upload bukti pembayaran Anda di sini. Admin akan memverifikasi dalam 1-5 menit.</p>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Payments List --}}
            @forelse ($orders as $order)
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-4">
                    {{-- Header Row --}}
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Pesanan #{{ $order->order_number }}
                        </h3>
                        <div>
                            @if ($order->payment)
                                @if ($order->payment->payment_status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Menunggu Verifikasi
                                    </span>
                                @elseif ($order->payment->payment_status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Terverifikasi
                                    </span>
                                @elseif ($order->payment->payment_status === 'rejected')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Belum Dibayar
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Info Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        @if ($order->payment)
                            <div>
                                <p class="text-sm text-gray-500">Metode</p>
                                <p class="font-medium text-gray-900">{{ $order->payment->payment_method }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jumlah</p>
                                <p class="font-medium text-gray-900">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                            </div>
                        @else
                            <div>
                                <p class="text-sm text-gray-500">Jumlah Tagihan</p>
                                <p class="font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500">Tanggal</p>
                            <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status Pesanan</p>
                            <div class="mt-1">
                                @if ($order->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu Pembayaran</span>
                                @elseif ($order->status === 'processing')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Diproses</span>
                                @elseif ($order->status === 'shipped')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">Dikirim</span>
                                @elseif ($order->status === 'delivered')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                                @elseif ($order->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Dibatalkan</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($order->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($order->payment)
                        {{-- Uploaded Proof & Rejection Reason --}}
                        @if ($order->payment->payment_proof)
                            <div class="mb-6">
                                <p class="text-sm text-gray-500 mb-2">Bukti Pembayaran</p>
                                <a href="{{ asset('storage/' . $order->payment->payment_proof) }}" target="_blank" class="inline-block relative group">
                                    <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" alt="Bukti Pembayaran" class="w-32 h-32 object-cover rounded-xl border border-gray-200">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if ($order->payment->payment_status === 'rejected' && $order->payment->rejection_reason)
                            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm flex items-start space-x-2">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-medium">Alasan Penolakan:</p>
                                    <p class="mt-1">{{ $order->payment->rejection_reason }}</p>
                                </div>
                            </div>
                        @endif
                    @endif

                    {{-- Action Area --}}
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        @if ($order->payment && $order->payment->payment_status === 'approved')
                            <div class="flex items-center text-green-600 font-medium text-sm">
                                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Pembayaran Terverifikasi
                            </div>
                        @elseif ($order->status === 'pending' && (!$order->payment || in_array($order->payment->payment_status, ['pending', 'rejected'])))
                            <form action="{{ route('customer.payment.upload', $order->order_number) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3">
                                @csrf
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Upload Bukti Transfer
                                    </label>
                                    <input type="file" name="payment_proof" accept="image/*" required class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-brand-50 file:text-brand-700
                                        hover:file:bg-brand-100
                                        border border-gray-300 rounded-lg p-1.5">
                                    @error('payment_proof')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-end">
                                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-brand-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Upload Bukti
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada riwayat pembayaran</h3>
                    <p class="mt-2 text-gray-500">Anda belum memiliki pesanan atau pembayaran apapun.</p>
                    <div class="mt-6">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
