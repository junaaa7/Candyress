@extends('layouts.store')

@section('title', $product->name)

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-gray-500 mb-8">
            <a href="/" class="hover:text-brand-600">Home</a>
            <span class="mx-2">/</span>
            <a href="#" class="hover:text-brand-600">{{ $product->category->name ?? 'Kategori' }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">{{ $product->name }}</span>
        </nav>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex flex-col md:flex-row gap-0">
                
                <!-- Kiri: Gambar Produk -->
                <div class="w-full md:w-1/2 p-8 md:p-12 bg-gray-50/50 flex items-center justify-center border-b md:border-b-0 md:border-r border-gray-100">
                    @if($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-2xl shadow-md">
                    @else
                        <div class="w-full aspect-video bg-gradient-to-br from-brand-100 to-accent-100 rounded-2xl flex items-center justify-center text-brand-600 font-bold text-6xl shadow-md">
                            {{ substr($product->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Kanan: Detail Informasi -->
                <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                    <span class="inline-block px-3 py-1 bg-brand-50 text-brand-600 rounded-full text-xs font-bold tracking-wide uppercase w-max mb-4">
                        {{ $product->product_type }}
                    </span>
                    
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center text-yellow-400">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="ml-1 font-medium text-gray-700">{{ $product->rating }}</span>
                        </div>
                        <span class="text-gray-300">|</span>
                        <span class="text-gray-500 text-sm">Terjual {{ $product->sold_count ?? 0 }}</span>
                    </div>

                    <div class="mb-8">
                        @if($product->discount_price)
                            <div class="flex items-baseline gap-3">
                                <span class="text-4xl font-extrabold text-brand-600">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                <span class="text-lg text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <span class="text-4xl font-extrabold text-brand-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </div>

                    <div class="prose prose-sm text-gray-600 mb-10 max-w-none">
                        <p>{{ $product->description }}</p>
                    </div>

                   <!-- Tombol Action -->
                    <form action="{{ route('cart.store') }}" method="POST" class="w-full flex flex-col sm:flex-row gap-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        @if($product->available_stock_count > 0)
                            <button type="submit" name="add_to_cart" value="1" class="flex-1 bg-white border-2 border-brand-500 text-brand-600 hover:bg-brand-50 py-3.5 px-6 rounded-2xl font-bold text-lg transition-all flex justify-center items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Tambah ke Keranjang
                            </button>

                            <button type="submit" name="buy_now" value="1" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white py-3.5 px-6 rounded-2xl font-bold text-lg transition-all shadow-lg hover:shadow-brand-500/30 flex justify-center items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Beli Sekarang
                            </button>
                        @else
                            <button type="button" disabled class="w-full py-3 px-6 rounded-xl bg-gray-200 text-gray-400 font-semibold cursor-not-allowed select-none flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                Stok Produk Sedang Habis
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
