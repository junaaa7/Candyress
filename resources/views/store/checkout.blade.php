@extends('layouts.store')

@section('title', 'Checkout')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8" 
     x-data="checkoutLogic({{ $totalAmount }}, {{ $userBalance }})">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Checkout</h1>
        <p class="text-gray-500 mt-2">Pilih metode pembayaran untuk menyelesaikan pesanan Anda.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">

        <!-- Bagian Kiri: Pilihan Metode Pembayaran -->
        <div class="w-full lg:w-2/3 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 p-6 overflow-hidden relative">
                <!-- Aksen Pink khas Candyress -->
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-300 to-pink-500"></div>

                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Pilih Metode Pembayaran
                </h2>

                <div class="space-y-4">
                    
                    <!-- Opsi 1: Saldo Candyress -->
                    <label for="metode_saldo"
                           @click="if(hasEnoughBalance) selectedPayment = 'SALDO'"
                           class="block relative border rounded-xl p-5 cursor-pointer transition-all duration-200"
                           :class="{
                               'border-pink-500 bg-pink-50': selectedPayment === 'SALDO',
                               'border-gray-200 hover:border-pink-300 hover:bg-pink-50/30': selectedPayment !== 'SALDO' && hasEnoughBalance,
                               'border-gray-100 bg-gray-50 opacity-60 cursor-not-allowed': !hasEnoughBalance
                           }"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-5 h-5 rounded-full border flex items-center justify-center"
                                     :class="selectedPayment === 'SALDO' ? 'border-pink-500' : (hasEnoughBalance ? 'border-gray-300' : 'border-gray-200')">
                                    <div class="w-3 h-3 rounded-full bg-pink-500" x-show="selectedPayment === 'SALDO'" x-cloak></div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">Saldo Candyress</h3>
                                    <p class="text-sm text-gray-500">Saldo aktif Anda: <span class="font-semibold text-pink-600" x-text="formatRupiah(balance)"></span></p>
                                </div>
                            </div>
                            <div class="bg-pink-100 p-2 rounded-full text-pink-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>

                        <!-- Peringatan Saldo Tidak Cukup -->
                        <div x-show="!hasEnoughBalance" class="mt-3 ml-9 text-xs font-semibold text-red-500" x-cloak>
                            Saldo tidak mencukupi untuk pesanan ini.
                        </div>

                        <!-- Input Radio -->
                        <input type="radio" 
                               id="metode_saldo"
                               name="payment_option" 
                               value="SALDO" 
                               x-model="selectedPayment" 
                               class="sr-only" 
                               :disabled="!hasEnoughBalance">
                    </label>

                    <!-- Opsi 2: Midtrans Snap (Otomatis) -->
                    <label for="metode_midtrans"
                           @click="selectedPayment = 'MIDTRANS'"
                           class="block relative border rounded-xl p-5 cursor-pointer transition-all duration-200"
                           :class="{
                               'border-pink-500 bg-pink-50': selectedPayment === 'MIDTRANS',
                               'border-gray-200 hover:border-pink-300 hover:bg-pink-50/30': selectedPayment !== 'MIDTRANS'
                           }">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4">
                                <div class="w-5 h-5 mt-1 rounded-full border border-gray-300 flex items-center justify-center shrink-0"
                                     :class="selectedPayment === 'MIDTRANS' ? 'border-pink-500' : ''">
                                    <div class="w-3 h-3 rounded-full bg-pink-500" x-show="selectedPayment === 'MIDTRANS'" x-cloak></div>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">Transfer / e-Wallet (Otomatis)</h3>
                                    <p class="text-sm text-gray-500 mt-1">Bayar menggunakan e-Wallet (Gopay, OVO, Dana, ShopeePay), Transfer Bank, atau QRIS. Diproses otomatis oleh Midtrans.</p>
                                    
                                    <!-- Logo e-Wallets -->
                                    <div class="flex items-center gap-2 mt-3">
                                        <span class="text-[10px] font-bold px-2 py-1 bg-green-500 text-white rounded">Gopay</span>
                                        <span class="text-[10px] font-bold px-2 py-1 bg-purple-600 text-white rounded">OVO</span>
                                        <span class="text-[10px] font-bold px-2 py-1 bg-blue-500 text-white rounded">DANA</span>
                                        <span class="text-[10px] font-bold px-2 py-1 bg-orange-500 text-white rounded">ShopeePay</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-100 p-2 rounded-xl text-gray-600 shrink-0 border border-gray-200">
                                <!-- Ikon Pembayaran -->
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>

                        <!-- Input Radio -->
                        <input type="radio" 
                               id="metode_midtrans"
                               name="payment_option" 
                               value="MIDTRANS" 
                               x-model="selectedPayment" 
                               class="sr-only">
                    </label>

                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Ringkasan Order -->
        <div class="w-full lg:w-1/3 space-y-6">
            
            <!-- Form Voucher -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Punya Kode Voucher?</h2>
                @if($activeVoucher)
                    <div class="flex items-center justify-between bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-100 p-1.5 rounded-full text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-emerald-700">{{ $activeVoucher->code }}</p>
                                <p class="text-xs text-emerald-600 font-medium">Berhasil dipakai!</p>
                            </div>
                        </div>
                        <form action="{{ route('checkout.voucher.remove') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm font-bold text-rose-500 hover:text-rose-700 px-2 py-1">Hapus</button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('checkout.voucher.apply') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="voucher_code" placeholder="Masukkan kode promo..." class="flex-1 border-gray-200 rounded-xl text-sm focus:border-pink-500 focus:ring focus:ring-pink-200 transition-colors" required>
                        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm">Gunakan</button>
                    </form>
                @endif
                
                @if(session('error'))
                    <p class="text-xs text-rose-500 mt-3 font-medium flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg> {{ session('error') }}</p>
                @endif
                @if(session('success'))
                    <p class="text-xs text-emerald-500 mt-3 font-medium flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> {{ session('success') }}</p>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-3">Ringkasan Order</h2>
                
                <div class="space-y-4 mb-6">
                    @foreach($cart->items as $item)
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-800">{{ $item->quantity }}x {{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">{{ $item->product->category->name ?? 'Digital Premium Account' }}</p>
                            </div>
                            <p class="font-semibold text-gray-800">Rp {{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-dashed border-gray-200 pt-4 mb-6 space-y-2">
                    <div class="flex justify-between items-center text-gray-600">
                        <p>Subtotal</p>
                        <p>Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                    </div>
                    @if($discount > 0)
                        <div class="flex justify-between items-center text-emerald-600 font-medium">
                            <p>Diskon Voucher</p>
                            <p>- Rp {{ number_format($discount, 0, ',', '.') }}</p>
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-4 mb-6">
                    <div class="flex justify-between items-center">
                        <p class="font-bold text-gray-800">Total Tagihan</p>
                        <p class="text-2xl font-black text-pink-600" x-text="formatRupiah(totalTagihan)"></p>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <form action="{{ route('checkout.process') ?? '#' }}" method="POST" id="form-checkout">
                    @csrf
                    <input type="hidden" name="payment_method" x-model="selectedPayment">
                    <button type="submit" 
                            class="w-full py-4 px-6 rounded-xl font-bold text-center transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            :class="buttonClass"
                            :disabled="!selectedPayment">
                        <span x-text="buttonText"></span>
                    </button>
                </form>

                <p class="text-xs text-center text-gray-400 mt-4 flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Pembayaran aman dan terenkripsi
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('checkoutLogic', (totalTagihan, saldoUser) => ({
            totalTagihan: totalTagihan,
            balance: saldoUser,
            selectedPayment: null, // 'SALDO' atau 'MIDTRANS'
            
            get hasEnoughBalance() {
                return this.balance >= this.totalTagihan;
            },

            get buttonText() {
                if (!this.selectedPayment) {
                    return 'Pilih Metode Pembayaran';
                }
                if (this.selectedPayment === 'SALDO') {
                    return 'Bayar dengan Saldo';
                }
                if (this.selectedPayment === 'MIDTRANS') {
                    return 'Lanjut ke Pembayaran';
                }
                return 'Bayar Sekarang';
            },

            get buttonClass() {
                if (!this.selectedPayment) {
                    return 'bg-gray-300 text-gray-600';
                }
                // Pink / Brand color untuk kondisi aktif
                return 'bg-pink-500 hover:bg-pink-600 text-white shadow-lg shadow-pink-200';
            },

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(number);
            }
        }))
    })
</script>
@endpush
@endsection
