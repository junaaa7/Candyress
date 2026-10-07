@extends('layouts.store')
@section('title', 'Pesanan Berhasil')
@section('content')
<div class="bg-gray-50 py-16 min-h-screen flex items-center justify-center">
    <div class="max-w-xl w-full mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 text-center">
            
            @php
                $isQris = stripos($order->payment->payment_method, 'qris') !== false;
                $isSaldo = stripos($order->payment->payment_method, 'saldo') !== false;
                $storeSetting = \App\Models\Setting::first();
                $qrisUrl = !empty($storeSetting?->qris_image) 
                    ? asset('storage/' . $storeSetting->qris_image) 
                    : asset('images/payments/qris.jpg');
            @endphp

            @if($isQris && $order->status === 'pending')
                <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                    ⏳
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 mb-2">Selesaikan Pembayaran QRIS</h1>
                <p class="text-gray-500 mb-8">Scan QRIS di bawah ini agar pesanan Anda dapat diproses.</p>
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

            @if($isQris && $order->status === 'pending')
                <div class="bg-brand-50 p-6 rounded-2xl mb-8 border border-brand-200 text-center">
                    <img src="{{ $qrisUrl }}" alt="QRIS Candyress" class="w-full max-w-[280px] mx-auto rounded-xl shadow-sm mb-6 object-contain">
                    
                    <div class="flex flex-col sm:flex-row gap-3 justify-center mb-6">
                        <a href="{{ $qrisUrl }}" download="QRIS-Candyress.jpg" class="inline-flex justify-center items-center px-4 py-2 bg-white border border-brand-300 rounded-xl text-brand-700 font-semibold hover:bg-brand-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh QRIS
                        </a>
                        @php
                            $waText = urlencode("Halo Admin Candyress, saya sudah transfer untuk Order ID: {$order->order_number} sebesar Rp " . number_format($order->total_price, 0, ',', '.'));
                        @endphp
                        <a href="https://wa.me/6281371711181?text={{ $waText }}" target="_blank" rel="noopener" class="inline-flex justify-center items-center px-4 py-2 bg-[#25D366] rounded-xl text-white font-semibold hover:bg-[#128C7E] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.012c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            Konfirmasi via WhatsApp
                        </a>
                    </div>

                    <div class="text-left bg-white p-4 rounded-xl border border-brand-100">
                        <h4 class="font-bold text-gray-900 mb-2">Cara Pembayaran:</h4>
                        <ol class="list-decimal list-inside text-sm text-gray-600 space-y-1">
                            <li>Buka aplikasi e-Wallet atau Mobile Banking (GoPay, OVO, Dana, BCA, dll).</li>
                            <li>Scan kode QR di atas dan bayar sesuai total tagihan (Rp {{ number_format($order->total_price, 0, ',', '.') }}).</li>
                            <li>Kirim bukti transfer ke WhatsApp admin untuk verifikasi.</li>
                        </ol>
                    </div>
                </div>
            @elseif(stripos($order->payment->payment_method, 'bca') !== false)
                <div class="text-left bg-blue-50 p-4 rounded-xl mb-8 border border-blue-100">
                    <p class="text-sm text-blue-800 font-medium mb-2">Silakan transfer ke rekening berikut:</p>
                    <p class="text-lg font-bold text-gray-900">BCA - 1234567890</p>
                    <p class="text-sm text-gray-600 mb-4">a.n. Candyress Digital</p>
                    <p class="text-xs text-blue-600">Setelah transfer, konfirmasi atau upload bukti pembayaran melalui dashboard Anda.</p>
                </div>
            @endif

            <a href="{{ route('customer.order.show', $order->order_number) }}" class="block w-full text-center bg-brand-600 hover:bg-brand-700 text-white py-3.5 rounded-xl font-bold transition-all shadow-md">
                Cek Detail & Status Pesanan
            </a>
        </div>
    </div>
</div>
@endsection
