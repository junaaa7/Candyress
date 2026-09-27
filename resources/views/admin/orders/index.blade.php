@extends('layouts.admin.app')
@section('title', 'Kelola Pesanan')
@section('content')
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Daftar Pesanan</h1>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                        <th class="p-4 font-semibold">Order ID</th>
                        <th class="p-4 font-semibold">Customer</th>
                        <th class="p-4 font-semibold">Total Tagihan</th>
                        <th class="p-4 font-semibold">Status Pembayaran</th>
                        <th class="p-4 font-semibold">Status Order</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($orders as $order)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                            <td class="p-4 font-bold text-brand-600">{{ $order->order_number }}</td>
                            <td class="p-4">
                                <span class="block text-gray-900 font-medium">{{ $order->user->name }}</span>
                                <span class="text-xs text-gray-500">{{ $order->user->email }}</span>
                            </td>
                            <td class="p-4 font-semibold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $order->payment->status == 'verified' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ strtoupper($order->payment->status) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold 
                                    {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-block bg-brand-50 hover:bg-brand-100 text-brand-700 font-semibold px-4 py-2 rounded-xl transition text-xs">Proses</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">Belum ada pesanan masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>
@endsection