@extends('layouts.store')
@section('title', 'Pesanan Berhasil')
@section('content')
<div class="bg-gray-50 py-16 min-h-screen flex items-center justify-center">
    <div class="max-w-xl w-full mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 text-center">
            
            @php
                $paymentMethod = $order->payment_method ?? $order->payment?->payment_method ?? '';
                $isSaldo = stripos($paymentMethod, 'saldo') !== false;
                $isBca = stripos($paymentMethod, 'bca') !== false;
                $isMidtrans = in_array(strtoupper($paymentMethod), ['MIDTRANS', 'QRIS']);
            @endphp

            @if(session('midtrans_error'))
                <div class="bg-rose-50 text-rose-600 p-4 rounded-xl mb-6 text-sm border border-rose-200">
                    <strong>Gagal memuat Midtrans:</strong> {{ session('midtrans_error') }}
                </div>
            @endif

            @if($isMidtrans && $order->status === 'pending')
                <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                    💳
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Selesaikan Pembayaran</h1>
                <p class="text-gray-500 mb-8">Klik tombol di bawah ini untuk melanjutkan pembayaran via Midtrans.</p>
            @elseif($order->status === 'pending')
                <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                    ⏳
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Menunggu Pembayaran</h1>
                <p class="text-gray-500 mb-8">Selesaikan pembayaran agar pesanan Anda dapat diproses.</p>
            @else
                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                    🎉
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Checkout Berhasil!</h1>
                <p class="text-gray-500 mb-8">
                    @if($isSaldo)
                        Pembayaran menggunakan saldo berhasil diproses.
                    @else
                        Selesaikan pembayaran agar akun digital Anda segera dikirim.
                    @endif
                </p>
            @endif
            
            <div class="bg-gray-50 p-6 rounded-2xl mb-6 border border-gray-200 text-left">
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
                    <span class="text-gray-500">Order ID</span>
                    <span class="font-bold text-gray-900">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200">
                    <span class="text-gray-500">Metode</span>
                    <span class="font-bold uppercase text-brand-600">{{ $order->payment->payment_method }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Total Tagihan</span>
                    <span class="font-extrabold text-2xl text-brand-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($isBca && $order->status === 'pending')
                <div class="text-left bg-blue-50 p-4 rounded-xl mb-8 border border-blue-100">
                    <p class="text-sm text-blue-800 font-medium mb-2">Silakan transfer ke rekening berikut:</p>
                    <p class="text-lg font-bold text-gray-900">BCA - 1234567890</p>
                    <p class="text-sm text-gray-600 mb-4">a.n. Candyress Digital</p>
                    <p class="text-xs text-blue-600">Setelah transfer, konfirmasi atau upload bukti pembayaran melalui dashboard Anda.</p>
                </div>
            @endif

            @if($isMidtrans && $order->status === 'pending' && $order->snap_token)
                <button id="pay-button" class="block w-full text-center bg-pink-600 hover:bg-pink-700 text-white py-3.5 rounded-xl font-bold transition-all shadow-md mb-3">
                    Bayar Sekarang (Midtrans)
                </button>
            @endif

            <a href="{{ route('customer.order.show', $order->order_number) }}" class="block w-full text-center {{ ($isMidtrans && $order->status === 'pending') ? 'bg-gray-100 hover:bg-gray-200 text-gray-800' : 'bg-brand-600 hover:bg-brand-700 text-white' }} py-3.5 rounded-xl font-bold transition-all shadow-md">
                Cek Detail & Status Pesanan
            </a>
        </div>
    </div>
</div>

@if($isMidtrans && $order->status === 'pending' && $order->snap_token)
    @php
        $snapUrl = config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script src="{{ $snapUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        function triggerMidtrans() {
            snap.pay('{{ $order->snap_token }}', {
                onSuccess: function(result){
                    window.location.href = "{{ route('customer.order.show', $order->order_number) }}";
                },
                onPending: function(result){
                    window.location.href = "{{ route('customer.order.show', $order->order_number) }}";
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    console.log('User closed the popup without finishing the payment');
                }
            });
        }

        document.getElementById('pay-button').onclick = function(){
            triggerMidtrans();
        };

        // Otomatis buka popup Midtrans saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            triggerMidtrans();
        });
    </script>
@endif
@endsection
