@extends('layouts.store')
@section('title', 'Pesanan Berhasil')
@section('content')
<div class="bg-gray-50 py-16 min-h-screen flex items-center justify-center">
    <div class="max-w-xl w-full mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 text-center">
            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                ✓
            </div>
            <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Checkout Berhasil!</h1>
            <p class="text-gray-500 mb-8">Selesaikan pembayaran agar akun digital Anda segera dikirim.</p>
            
            <div class="bg-gray-50 p-6 rounded-2xl mb-8 border border-gray-200 text-left">
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
                    <span class="text-gray-500">Order ID</span>
                    <span class="font-bold text-gray-900">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
                    <span class="text-gray-500">Metode</span>
                    <span class="font-bold text-brand-600">{{ $order->payment->payment_method }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Total Tagihan</span>
                    <span class="font-extrabold text-2xl text-brand-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($order->payment->payment_method == 'BCA')
                <div class="text-left bg-blue-50 p-4 rounded-xl mb-8 border border-blue-100">
                    <p class="text-sm text-blue-800 font-medium mb-2">Silakan transfer ke rekening berikut:</p>
                    <p class="text-lg font-bold text-gray-900">BCA - 1234567890</p>
                    <p class="text-sm text-gray-600 mb-4">a.n. Candyress Digital</p>
                    <p class="text-xs text-blue-600">Setelah transfer, upload bukti pembayaran melalui dashboard Anda.</p>
                </div>
            @endif

            <a href="{{ url('/dashboard') }}" class="block w-full text-center bg-brand-600 hover:bg-brand-700 text-white py-3.5 rounded-xl font-bold transition-all shadow-md">
                Cek Status Pesanan di Dashboard
            </a>
        </div>
    </div>
</div>
@endsection