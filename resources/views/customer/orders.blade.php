<x-customer-layout>
    <x-slot name="header">
        Pesanan Saya
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
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
                   class="whitespace-nowrap rounded-full px-5 py-2 text-sm font-bold transition {{ $currentStatus === $key ? 'bg-brand-300 text-white shadow-pop-sm' : 'border-2 border-brand-100 bg-white text-brand-900 hover:border-brand-300 hover:bg-brand-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Orders List -->
        @forelse ($orders as $order)
            <div class="cute-card cute-lift mb-4 p-6">
                <div class="mb-4 flex flex-col justify-between gap-4 border-b-2 border-dashed border-brand-100 pb-4 md:flex-row md:items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-brand-600">#{{ $order->order_number }}</h3>
                        <p class="text-sm text-mauve">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        @if ($order->status == 'pending')
                            <span class="inline-flex items-center rounded-full border-2 border-amber-200 bg-amber-50 px-3 py-0.5 text-xs font-bold text-amber-700">Menunggu</span>
                        @elseif ($order->status == 'processing')
                            <span class="inline-flex items-center rounded-full border-2 border-accent-200 bg-accent-100 px-3 py-0.5 text-xs font-bold text-purple-600">Diproses</span>
                        @elseif ($order->status == 'completed')
                            <span class="inline-flex items-center rounded-full border-2 border-emerald-200 bg-mint px-3 py-0.5 text-xs font-bold text-emerald-700">Selesai</span>
                        @elseif ($order->status == 'cancelled')
                            <span class="inline-flex items-center rounded-full border-2 border-brand-300 bg-brand-100 px-3 py-0.5 text-xs font-bold text-rose-600">Dibatalkan</span>
                        @else
                            <span class="inline-flex items-center rounded-full border-2 border-brand-200 bg-brand-50 px-3 py-0.5 text-xs font-bold text-mauve">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <ul class="divide-y-2 divide-dashed divide-brand-100">
                        @foreach($order->items as $item)
                            <li class="flex items-center gap-4 py-3">
                                <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-2xl border-2 border-brand-100 bg-brand-50">
                                    @if($item->product->thumbnail)
                                        <img src="{{ Storage::url($item->product->thumbnail) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-brand-300">
                                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-bold">{{ $item->product->name }}</p>
                                    <p class="text-sm text-mauve">{{ $item->quantity }} x Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex flex-col items-start justify-between gap-4 border-t-2 border-dashed border-brand-100 pt-4 md:flex-row md:items-center">
                    <div>
                        <p class="mb-1 text-sm text-mauve">Total Belanja</p>
                        <p class="font-display text-lg font-bold text-brand-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        @if($order->payment)
                            <p class="mt-1 text-xs font-bold">
                                Status Pembayaran:
                                @if($order->payment->status == 'pending')
                                    <span class="text-amber-600">Belum Diverifikasi</span>
                                @elseif($order->payment->status == 'approved')
                                    <span class="text-emerald-600">Terverifikasi</span>
                                @elseif($order->payment->status == 'rejected')
                                    <span class="text-rose-600">Ditolak</span>
                                @endif
                            </p>
                        @endif
                    </div>
                    <div class="flex w-full items-center gap-3 md:w-auto">
                        <a href="{{ route('customer.order.show', $order->order_number) }}" class="cute-btn cute-btn-ghost w-full px-5 py-2 text-sm md:w-auto">
                            Lihat Detail
                        </a>
                        @if($order->status == 'pending' && (!$order->payment || ($order->payment->status == 'pending' && !$order->payment->payment_proof)))
                            <a href="{{ route('customer.order.show', $order->order_number) }}#payment" class="cute-btn cute-btn-primary w-full px-5 py-2 text-sm md:w-auto">
                                Upload Bukti Bayar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="cute-card p-12 text-center">
                <div class="mb-4 text-6xl">🛍️</div>
                <h3 class="mb-2 text-lg font-semibold">Belum ada pesanan</h3>
                <p class="mb-6 text-mauve">Anda belum memiliki pesanan dengan status ini.</p>
                <a href="{{ route('home') }}" class="cute-btn cute-btn-primary px-6 py-2.5 text-sm">
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
