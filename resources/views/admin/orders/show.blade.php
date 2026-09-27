@extends('layouts.admin.app')
@section('title', 'Proses Pesanan ' . $order->order_number)
@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Proses Pesanan: {{ $order->order_number }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="text-brand-600 hover:text-brand-800 font-medium text-sm">&larr; Kembali</a>
</div>

@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Detail Pesanan & Pembeli -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Informasi Pembeli</h3>
            <div class="text-sm space-y-2">
                <p><span class="text-gray-500 block">Nama:</span> <span class="font-semibold">{{ $order->user->name }}</span></p>
                <p><span class="text-gray-500 block">Email:</span> <span class="font-semibold">{{ $order->user->email }}</span></p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Rincian Produk</h3>
            <div class="space-y-4 mb-4">
                @foreach($order->items as $item)
                    <div class="text-sm">
                        <span class="font-semibold text-gray-900 block">{{ $item->product->name }}</span>
                        <span class="text-gray-500">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-gray-100 pt-3 flex justify-between items-center text-sm">
                <span class="font-bold text-gray-900">Total</span>
                <span class="font-extrabold text-brand-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Form Eksekusi Pesanan -->
    <div class="lg:col-span-2">
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            @csrf
            @method('PUT')
            
            <h3 class="font-bold text-gray-900 mb-6 text-lg border-b border-gray-100 pb-2">Update Status & Kirim Akun</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Pembayaran</label>
                    <select name="payment_status" class="w-full rounded-xl border-gray-200 focus:border-brand-500 shadow-sm">
                        <option value="pending" {{ $order->payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ $order->payment->status == 'verified' ? 'selected' : '' }}>Verified (Lunas)</option>
                        <option value="failed" {{ $order->payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Pesanan</label>
                    <select name="status" class="w-full rounded-xl border-gray-200 focus:border-brand-500 shadow-sm">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Detail Akun Premium / License Key</label>
                <textarea name="account_credentials" rows="5" class="w-full rounded-xl border-gray-200 focus:border-brand-500 shadow-sm" placeholder="Contoh:&#10;Email: user@candyress.com&#10;Password: pass123&#10;Profil: Screen 1&#10;PIN: 0000">{{ $order->account_credentials }}</textarea>
                <p class="text-xs text-gray-500 mt-2">Data ini akan muncul di dashboard pembeli saat status pesanan menjadi 'Completed'.</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-sm transition">
                    Simpan & Kirim
                </button>
            </div>
        </form>
    </div>
</div>
@endsection