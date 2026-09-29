<x-customer-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="space-y-6">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-brand-600 to-brand-700 rounded-2xl p-6 sm:p-8 text-white shadow-sm">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-2xl font-bold backdrop-blur-sm border border-white/30 shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-1">Halo, {{ Auth::user()->name }}!</h2>
                    <p class="text-brand-100 text-sm sm:text-base">Selamat datang kembali di Candyress. {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Orders -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalOrders ?? 0 }}</p>
                </div>
            </div>

            <!-- Menunggu Pembayaran -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Menunggu Pembayaran</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingOrders ?? 0 }}</p>
                </div>
            </div>

            <!-- Sedang Diproses -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Sedang Diproses</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $processingOrders ?? 0 }}</p>
                </div>
            </div>

            <!-- Pesanan Selesai -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Pesanan Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $completedOrders ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Orders -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h3>
                    <a href="{{ route('customer.orders.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">Lihat Semua</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-sm">
                                <th class="px-6 py-4 font-medium">Order ID</th>
                                <th class="px-6 py-4 font-medium">Produk</th>
                                <th class="px-6 py-4 font-medium">Total</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                                <th class="px-6 py-4 font-medium">Pembayaran</th>
                                <th class="px-6 py-4 font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentOrders ?? [] as $order)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-900">#{{ $order->order_number }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($order->items && $order->items->count() > 0)
                                            <p class="text-sm text-gray-900 line-clamp-1">
                                                {{ $order->items->first()->product->name ?? 'Produk' }}
                                                @if($order->items->count() > 1)
                                                    <span class="text-gray-500 text-xs">+{{ $order->items->count() - 1 }} lainnya</span>
                                                @endif
                                            </p>
                                        @else
                                            <span class="text-sm text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusText = [
                                                'pending' => 'Menunggu',
                                                'processing' => 'Diproses',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Dibatalkan',
                                            ];
                                            $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                            $statusLabel = $statusText[$order->status] ?? ucfirst($order->status);
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $paymentStatus = $order->payment ? $order->payment->status : 'pending';
                                            $paymentColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-700',
                                                'approved' => 'bg-green-100 text-green-700',
                                                'rejected' => 'bg-red-100 text-red-700',
                                            ];
                                            $paymentText = [
                                                'pending' => 'Belum Lunas',
                                                'approved' => 'Lunas',
                                                'rejected' => 'Ditolak',
                                            ];
                                            $payColor = $paymentColors[$paymentStatus] ?? 'bg-gray-100 text-gray-700';
                                            $payLabel = $paymentText[$paymentStatus] ?? ucfirst($paymentStatus);
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payColor }}">
                                            {{ $payLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('customer.order.show', $order->order_number) }}" class="text-sm font-medium text-brand-600 hover:text-brand-800">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            </div>
                                            <p class="text-gray-500 mb-4">Belum ada pesanan. Yuk mulai belanja!</p>
                                            <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-xl font-medium text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 text-sm transition-colors shadow-sm">
                                                Mulai Belanja
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="lg:col-span-1 space-y-6">
                <h3 class="text-lg font-bold text-gray-900 hidden lg:block">Aksi Cepat</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('customer.payments.index') }}" class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 group-hover:text-brand-600 transition-colors">Upload Bukti Bayar</h4>
                            <p class="text-xs text-gray-500 mt-1">Konfirmasi pembayaran Anda</p>
                        </div>
                    </a>

                    <a href="{{ route('customer.reviews.index') }}" class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
                        <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 group-hover:text-brand-600 transition-colors">Tulis Review</h4>
                            <p class="text-xs text-gray-500 mt-1">Beri ulasan pesanan Anda</p>
                        </div>
                    </a>

                    <a href="{{ url('/') }}" class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 group-hover:text-brand-600 transition-colors">Belanja Lagi</h4>
                            <p class="text-xs text-gray-500 mt-1">Lihat katalog produk terbaru</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>