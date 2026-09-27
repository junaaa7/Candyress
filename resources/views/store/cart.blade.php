@extends('layouts.store')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Keranjang Belanja</h1>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- List Produk -->
            <div class="lg:col-span-2 space-y-4">
                @php $totalPrice = 0; @endphp
                
                @forelse($cartItems as $item)
                    @php 
                        $price = $item->product->discount_price ?? $item->product->price;
                        $subtotal = $price * $item->quantity;
                        $totalPrice += $subtotal;
                    @endphp
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-center relative">
                        <!-- Thumbnail -->
                        <div class="w-24 h-24 bg-gray-100 rounded-xl flex-shrink-0 overflow-hidden">
                            @if($item->product->thumbnail)
                                <img src="{{ asset('storage/' . $item->product->thumbnail) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        
                        <!-- Info Produk -->
                        <div class="flex-grow">
                            <h3 class="font-bold text-gray-900 text-lg">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $item->product->product_type }}</p>
                            <div class="font-bold text-brand-600">Rp {{ number_format($price, 0, ',', '.') }} <span class="text-xs text-gray-400 font-normal">x {{ $item->quantity }}</span></div>
                        </div>

                        <!-- Hapus -->
                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="absolute top-4 right-4">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 p-2 bg-red-50 hover:bg-red-100 rounded-lg transition" title="Hapus dari keranjang">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="bg-white p-12 rounded-2xl shadow-sm border border-gray-100 text-center">
                        <div class="text-6xl mb-4">🛒</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Keranjang Anda Kosong</h3>
                        <p class="text-gray-500 mb-6">Yuk temukan akun premium favorit Anda di Candyress!</p>
                        <a href="/" class="inline-block bg-brand-600 text-white px-6 py-2.5 rounded-full font-semibold hover:bg-brand-700 transition">Belanja Sekarang</a>
                    </div>
                @endforelse
            </div>

            <!-- Ringkasan Belanja -->
            @if($cartItems->count() > 0)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit sticky top-24">
                    <h3 class="font-bold text-gray-900 text-lg mb-6">Ringkasan Belanja</h3>
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Harga ({{ $cartItems->sum('quantity') }} Produk)</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Layanan</span>
                            <span class="font-semibold text-green-600">Gratis</span>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-4 mb-6 flex justify-between items-center">
                        <span class="font-bold text-gray-900">Total Tagihan</span>
                        <span class="font-extrabold text-2xl text-brand-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="w-full block text-center bg-brand-600 hover:bg-brand-700 text-white py-3.5 rounded-xl font-bold text-lg transition-all shadow-md">
                        Lanjut ke Pembayaran
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection