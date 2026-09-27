@extends('layouts.store')
@section('title', 'Detail Pesanan ' . $order->order_number)
@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-extrabold text-gray-900">Detail Pesanan</h1>
            <a href="{{ route('dashboard') }}" class="text-brand-600 hover:text-brand-800 font-medium text-sm">&larr; Kembali ke Dashboard</a>
        </div>

        <!-- ALERT: Jika Status Selesai, Tampilkan Akun -->
        @if($order->status == 'completed')
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-md p-6 mb-8 text-white relative overflow-hidden">
                <div class="absolute -right-10 -top-10 text-9xl opacity-10">🎉</div>
                <h2 class="text-xl font-bold mb-2 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Pesanan Selesai!
                </h2>
                <p class="text-green-50 mb-4">Terima kasih! Berikut adalah detail akses akun premium Anda. Harap simpan dengan baik.</p>
                
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                    <p class="font-mono text-sm text-white whitespace-pre-wrap">{!! nl2br(e($order->account_credentials ?? 'Data akun belum dikirim. Hubungi admin.')) !!}</p>
                </div>
            </div>
        @elseif($order->status == 'pending')
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl shadow-sm p-6 mb-8 flex items-start gap-4">
                <div class="text-3xl">⏳</div>
                <div>
                    <h2 class="text-lg font-bold text-yellow-800 mb-1">Menunggu Pembayaran</h2>
                    <p class="text-yellow-700 text-sm">Pesanan Anda sedang dalam status pending. Silakan lakukan pembayaran sebesar <span class="font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span> melalui metode <span class="font-bold">{{ $order->payment->payment_method }}</span>.</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Informasi Pesanan -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Pesanan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Order ID</span>
                        <span class="font-semibold text-gray-900">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal</span>
                        <span class="font-semibold text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status Pesanan</span>
                        <span class="font-semibold text-brand-600 uppercase">{{ $order->status }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Metode Pembayaran</span>
                        <span class="font-semibold text-gray-900">{{ $order->payment->payment_method }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status Pembayaran</span>
                        <span class="font-semibold {{ $order->payment->status == 'verified' ? 'text-green-600' : 'text-yellow-600' }} uppercase">{{ $order->payment->status }}</span>
                    </div>
                </div>
            </div>

            <!-- Rincian Produk -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Produk yang Dibeli</h3>
                <div class="space-y-4 mb-4">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-start text-sm">
                            <div class="flex gap-3">
                                <span class="font-semibold text-gray-900">{{ $item->quantity }}x</span>
                                <span class="text-gray-600">{{ $item->product->name }}</span>
                            </div>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-100 pt-3 flex justify-between items-center">
                    <span class="font-bold text-gray-900">Total Belanja</span>
                    <span class="font-extrabold text-xl text-brand-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection