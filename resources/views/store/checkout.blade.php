@extends('layouts.store')
@section('title', 'Checkout')
@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Checkout Pesanan</h1>
        
        <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            
            <!-- Pilih Metode Pembayaran -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Pilih Metode Pembayaran</h2>
                    
                    <div class="space-y-4">
                        <label class="flex items-center justify-between p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-brand-500 hover:bg-brand-50 transition">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_method" value="QRIS" class="w-5 h-5 text-brand-600 focus:ring-brand-500 border-gray-300" required>
                                <div>
                                    <span class="block font-bold text-gray-900">QRIS (Otomatis)</span>
                                    <span class="text-sm text-gray-500">Gopay, OVO, Dana, ShopeePay, Mobile Banking</span>
                                </div>
                            </div>
                            <div class="text-2xl">📱</div>
                        </label>

                        <label class="flex items-center justify-between p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-brand-500 hover:bg-brand-50 transition">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="payment_method" value="BCA" class="w-5 h-5 text-brand-600 focus:ring-brand-500 border-gray-300" required>
                                <div>
                                    <span class="block font-bold text-gray-900">Transfer BCA</span>
                                    <span class="text-sm text-gray-500">Pengecekan manual 1-5 menit</span>
                                </div>
                            </div>
                            <div class="text-2xl">🏦</div>
                        </label>
                    </div>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ringkasan Order -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit sticky top-24">
                <h3 class="font-bold text-gray-900 text-lg mb-6">Ringkasan Order</h3>
                
                <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 no-scrollbar">
                    @php $totalPrice = 0; @endphp
                    @foreach($cart->items as $item)
                        @php 
                            $price = $item->product->discount_price ?? $item->product->price;
                            $totalPrice += $price * $item->quantity;
                        @endphp
                        <div class="flex justify-between items-start text-sm">
                            <div class="flex gap-3">
                                <span class="font-semibold text-gray-900">{{ $item->quantity }}x</span>
                                <span class="text-gray-600 line-clamp-2">{{ $item->product->name }}</span>
                            </div>
                            <span class="font-semibold text-gray-900 shrink-0">Rp {{ number_format($price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 pt-4 mb-6 flex justify-between items-center">
                    <span class="font-bold text-gray-900">Total Tagihan</span>
                    <span class="font-extrabold text-2xl text-brand-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
                <button type="submit" class="w-full block text-center bg-brand-600 hover:bg-brand-700 text-white py-3.5 rounded-xl font-bold text-lg transition-all shadow-md">
                    Bayar Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection