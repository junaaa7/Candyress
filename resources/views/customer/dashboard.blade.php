<x-customer-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="space-y-6">
        <!-- Welcome Banner -->
        <div class="rounded-4xl bg-gradient-to-r from-brand-300 to-brand-500 p-6 text-white shadow-xl shadow-brand-600/20 sm:p-8">
            <div class="flex items-center gap-6">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full border-2 border-white bg-white/30 font-display text-2xl font-bold backdrop-blur-sm overflow-hidden">
                    @if(Auth::user()->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists(Auth::user()->avatar))
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    @elseif(Auth::user()->avatar)
                        <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>
                <div>
                    <h2 class="mb-1 text-2xl font-bold">Halo, {{ Auth::user()->name }}! 💕</h2>
                    <p class="text-sm text-white/90 sm:text-base">Selamat datang kembali di Candyress. {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Wallet Balance Card -->
        <div class="cute-card overflow-hidden">
            <div class="flex flex-col items-stretch sm:flex-row">
                <div class="flex flex-1 items-center gap-4 p-6">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-300 to-accent-500 shadow-md">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-mauve">Saldo Anda</p>
                        <p class="font-display text-2xl font-bold sm:text-3xl">Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="flex items-center border-t-2 border-dashed border-brand-100 px-6 py-4 sm:border-l-2 sm:border-t-0 sm:py-0">
                    <a href="{{ route('customer.topup.index') }}" class="cute-btn cute-btn-primary px-5 py-2.5 text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        Top-Up Saldo
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Orders -->
            <div class="cute-card cute-lift flex items-center gap-4 p-6">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-brand-100 text-brand-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-mauve">Total Pesanan</p>
                    <p class="font-display text-2xl font-bold">{{ $totalOrders ?? 0 }}</p>
                </div>
            </div>

            <!-- Menunggu Pembayaran -->
            <div class="cute-card cute-lift flex items-center gap-4 p-6">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-mauve">Menunggu Pembayaran</p>
                    <p class="font-display text-2xl font-bold">{{ $pendingOrders ?? 0 }}</p>
                </div>
            </div>

            <!-- Sedang Diproses -->
            <div class="cute-card cute-lift flex items-center gap-4 p-6">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-accent-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-mauve">Sedang Diproses</p>
                    <p class="font-display text-2xl font-bold">{{ $processingOrders ?? 0 }}</p>
                </div>
            </div>

            <!-- Pesanan Selesai -->
            <div class="cute-card cute-lift flex items-center gap-4 p-6">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-mint text-emerald-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-mauve">Pesanan Selesai</p>
                    <p class="font-display text-2xl font-bold">{{ $completedOrders ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Recent Orders -->
            <div class="cute-card overflow-hidden lg:col-span-2">
                <div class="flex items-center justify-between border-b-2 border-dashed border-brand-100 bg-brand-100/60 p-6">
                    <h3 class="text-xl font-semibold">Pesanan Terbaru 🧾</h3>
                    <a href="{{ route('customer.orders.index') }}" class="cute-link text-sm">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto w-full p-3">
                    <table class="cute-table min-w-[44rem]">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Produk</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td>
                                        <span class="font-bold text-brand-600">#{{ $order->order_number }}</span>
                                    </td>
                                    <td>
                                        @if($order->items && $order->items->count() > 0)
                                            <p class="line-clamp-1 text-sm">
                                                {{ $order->items->first()->product->name ?? 'Produk' }}
                                                @if($order->items->count() > 1)
                                                    <span class="text-xs text-mauve">+{{ $order->items->count() - 1 }} lainnya</span>
                                                @endif
                                            </p>
                                        @else
                                            <span class="text-sm text-mauve">-</span>
                                        @endif
                                    </td>
                                    <td class="font-bold">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'border-amber-200 bg-amber-50 text-amber-700',
                                                'processing' => 'border-accent-200 bg-accent-100 text-purple-600',
                                                'completed' => 'border-emerald-200 bg-mint text-emerald-700',
                                                'cancelled' => 'border-brand-300 bg-brand-100 text-rose-600',
                                            ];
                                            $statusText = [
                                                'pending' => 'Menunggu',
                                                'processing' => 'Diproses',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Dibatalkan',
                                            ];
                                            $statusColor = $statusColors[$order->status] ?? 'border-brand-200 bg-brand-50 text-mauve';
                                            $statusLabel = $statusText[$order->status] ?? ucfirst($order->status);
                                        @endphp
                                        <span class="inline-flex items-center rounded-full border-2 px-3 py-0.5 text-xs font-bold {{ $statusColor }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $paymentStatus = $order->payment ? $order->payment->status : 'pending';
                                            $paymentColors = [
                                                'pending' => 'border-amber-200 bg-amber-50 text-amber-700',
                                                'approved' => 'border-emerald-200 bg-mint text-emerald-700',
                                                'rejected' => 'border-brand-300 bg-brand-100 text-rose-600',
                                            ];
                                            $paymentText = [
                                                'pending' => 'Belum Lunas',
                                                'approved' => 'Lunas',
                                                'rejected' => 'Ditolak',
                                            ];
                                            $payColor = $paymentColors[$paymentStatus] ?? 'border-brand-200 bg-brand-50 text-mauve';
                                            $payLabel = $paymentText[$paymentStatus] ?? ucfirst($paymentStatus);
                                        @endphp
                                        <span class="inline-flex items-center rounded-full border-2 px-3 py-0.5 text-xs font-bold {{ $payColor }}">
                                            {{ $payLabel }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('customer.order.show', $order->order_number) }}" class="cute-act cute-act-edit">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-brand-100">
                                                <svg class="w-8 h-8 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            </div>
                                            <p class="mb-4 font-semibold text-mauve">Belum ada pesanan. Yuk mulai belanja!</p>
                                            <a href="{{ url('/') }}" class="cute-btn cute-btn-primary px-5 py-2 text-sm">
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
            <div class="space-y-6 lg:col-span-1">
                <h3 class="hidden text-xl font-semibold lg:block">Aksi Cepat ✨</h3>

                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('customer.payments.index') }}" class="cute-card cute-lift group flex items-center gap-4 p-5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-accent-100 text-purple-600 transition-transform group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold transition-colors group-hover:text-brand-600">Upload Bukti Bayar</h4>
                            <p class="mt-1 text-xs text-mauve">Konfirmasi pembayaran Anda</p>
                        </div>
                    </a>

                    <a href="{{ route('customer.reviews.index') }}" class="cute-card cute-lift group flex items-center gap-4 p-5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-500 transition-transform group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold transition-colors group-hover:text-brand-600">Tulis Review</h4>
                            <p class="mt-1 text-xs text-mauve">Beri ulasan pesanan Anda</p>
                        </div>
                    </a>

                    <a href="{{ route('customer.products.index') }}" class="cute-card cute-lift group flex items-center gap-4 p-5">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-mint text-emerald-700 transition-transform group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold transition-colors group-hover:text-brand-600">Belanja Lagi</h4>
                            <p class="mt-1 text-xs text-mauve">Lihat katalog produk terbaru</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
