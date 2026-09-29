<x-customer-layout>
    <x-slot name="header">
        Pesanan Saya
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Filter Tabs -->
        <div class="mb-6 flex overflow-x-auto pb-2 space-x-2 no-scrollbar">
            @php
                $currentStatus = request('status', 'all');
                $filters = [
                    'all' => 'Semua',
                    'pending' => 'Menunggu',
                    'processing' => 'Diproses',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan'
                ];
            @endphp
            @foreach($filters as $key => $label)
                <a href="{{ route('customer.orders.index', ['status' => $key]) }}"
                   class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap transition {{ $currentStatus === $key ? 'bg-brand-600 text-white' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Orders List -->
        @forelse ($orders as $order)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm mb-4 transition hover:shadow-md">
                <div class="flex flex-col md:flex-row justify-between md:items-center mb-4 pb-4 border-b border-gray-100 gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">#{{ $order->order_number }}</h3>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        @if ($order->status == 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu</span>
                        @elseif ($order->status == 'processing')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Diproses</span>
                        @elseif ($order->status == 'completed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                        @elseif ($order->status == 'cancelled')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Dibatalkan</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <ul class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                            <li class="py-3 flex items-center gap-4">
                                <div class="h-16 w-16 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden border border-gray-100">
                                    @if($item->product->thumbnail)
                                        <img src="{{ Storage::url($item->product->thumbnail) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-400">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center pt-4 border-t border-gray-100 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Belanja</p>
                        <p class="text-lg font-bold text-brand-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        @if($order->payment)
                            <p class="text-xs mt-1 font-medium">
                                Status Pembayaran: 
                                @if($order->payment->status == 'pending')
                                    <span class="text-yellow-600">Belum Diverifikasi</span>
                                @elseif($order->payment->status == 'approved')
                                    <span class="text-green-600">Terverifikasi</span>
                                @elseif($order->payment->status == 'rejected')
                                    <span class="text-red-600">Ditolak</span>
                                @endif
                            </p>
                        @endif
                    </div>
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <a href="{{ route('customer.order.show', $order->order_number) }}" class="inline-flex justify-center items-center px-4 py-2 border border-brand-600 text-sm font-medium rounded-xl text-brand-600 bg-white hover:bg-brand-50 w-full md:w-auto transition">
                            Lihat Detail
                        </a>
                        @if($order->status == 'pending' && (!$order->payment || ($order->payment->status == 'pending' && !$order->payment->payment_proof)))
                            <a href="{{ route('customer.order.show', $order->order_number) }}#payment" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-white bg-brand-600 hover:bg-brand-700 shadow-sm w-full md:w-auto transition">
                                Upload Bukti Bayar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-12 border border-gray-100 shadow-sm text-center">
                <div class="text-6xl mb-4">🛍️</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
                <p class="text-gray-500 mb-6">Anda belum memiliki pesanan dengan status ini.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</x-customer-layout>
