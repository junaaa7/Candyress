@extends('layouts.store')
@section('title', 'Dashboard Saya')
@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center gap-4 mb-8">
            <div class="w-16 h-16 bg-brand-600 text-white rounded-full flex items-center justify-center text-2xl font-bold shadow-md">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Halo, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-500 text-sm">Selamat datang di Dasbor Candyress Anda.</p>
            </div>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-xl">🛒</div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center text-xl">⏳</div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Menunggu Pembayaran</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $pendingOrders }}</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-xl">✅</div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pesanan Selesai</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $completedOrders }}</h3>
                </div>
            </div>
        </div>

        <!-- Riwayat Pesanan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Riwayat Pesanan Terbaru</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-sm text-gray-500">
                            <th class="p-4 font-semibold">Order ID</th>
                            <th class="p-4 font-semibold">Tanggal</th>
                            <th class="p-4 font-semibold">Total</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($orders as $order)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                <td class="p-4 font-medium text-gray-900">{{ $order->order_number }}</td>
                                <td class="p-4 text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="p-4 font-bold text-brand-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    @if($order->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Pending</span>
                                    @elseif($order->status == 'processing')
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Diproses</span>
                                    @elseif($order->status == 'completed')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('customer.order.show', $order->order_number) }}" class="inline-block bg-white border border-gray-200 hover:border-brand-300 hover:text-brand-600 text-gray-600 font-semibold px-4 py-2 rounded-xl transition shadow-sm text-xs">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">Belum ada riwayat pesanan. Yuk, mulai belanja!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection