<x-admin-layout>
    <div class="mx-auto max-w-7xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('admin.orders.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">&larr; Kembali</a>
            <h1 class="text-3xl font-bold">Detail Pesanan <span class="text-brand-600">#{{ $order->order_number }}</span> 🧾</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border-2 border-dashed border-emerald-300 bg-mint px-5 py-3.5 font-bold text-emerald-700" role="status">
                <svg class="h-6 w-6 flex-none" viewBox="0 0 24 24" fill="#fff" stroke="#1F7A57" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6" fill="none"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- Kiri: Detail Produk yang Dibeli & Info Pelanggan -->
            <div class="space-y-6 lg:col-span-2">

                <!-- Daftar Produk -->
                <div class="cute-card p-6">
                    <h2 class="mb-4 text-xl font-semibold">Produk yang Dibeli 🛍️</h2>
                    <div class="overflow-x-auto">
                        <table class="cute-table min-w-[30rem]">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->products as $product)
                                <tr>
                                    <td class="font-bold">{{ $product->name }}</td>
                                    <td class="text-mauve">Rp {{ number_format($product->pivot->price, 0, ',', '.') }}</td>
                                    <td class="text-mauve">{{ $product->pivot->quantity }}</td>
                                    <td class="font-bold">
                                        Rp {{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="border-t-2 border-dashed border-brand-300 px-6 py-4 text-right text-sm font-bold">TOTAL PEMBAYARAN:</td>
                                    <td class="border-t-2 border-dashed border-brand-300 px-6 py-4 font-display text-lg font-bold text-brand-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Info Pelanggan -->
                <div class="cute-card p-6">
                    <h2 class="mb-4 text-xl font-semibold">Informasi Pelanggan 👤</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-mauve">Nama Lengkap</p>
                            <p class="font-bold">{{ $order->user->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-mauve">Alamat Email</p>
                            <p class="font-bold">{{ $order->user->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-mauve">No. HP / WhatsApp</p>
                            <p class="font-bold">{{ $order->user->phone ?? 'Tidak dicantumkan' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kanan: Status & Aksi -->
            <div class="space-y-6">
                <div class="cute-card p-6">
                    <h2 class="mb-4 text-xl font-semibold">Ubah Status Pesanan</h2>

                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <label class="cute-label">Status Saat Ini:</label>
                            <select name="status" class="cute-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran)</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses (Sudah Dibayar)</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai (Akun Dikirim)</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <button type="submit" class="cute-btn cute-btn-primary w-full py-2.5">
                            Perbarui Status
                        </button>
                    </form>
                </div>

                @php
                    $unfulfilledItems = $order->items->whereNull('product_stock_id')->count();
                @endphp

                @if($order->status === 'completed' && $unfulfilledItems > 0)
                    <div class="rounded-2xl border-2 border-dashed border-rose-300 bg-rose-50 p-4 shadow-sm text-center">
                        <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 px-3 py-1 font-bold text-rose-600 text-xs mb-3">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Belum Ada Akun Terpasang
                        </span>
                        <p class="text-sm text-rose-700 mb-3 font-medium">Beberapa produk dalam pesanan ini belum dialokasikan stok akunnya.</p>
                        <form action="{{ route('admin.orders.fulfill', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded-xl transition-colors">
                                Kirim / Alokasikan Stok Sekarang
                            </button>
                        </form>
                    </div>
                @endif

                <div class="rounded-2xl border-2 border-dashed border-brand-300 bg-brand-100/60 p-4">
                    <h3 class="mb-2 text-sm font-bold text-brand-600">Informasi Penting 💡</h3>
                    <ul class="list-disc space-y-2 pl-4 text-xs">
                        <li>Ubah status ke <b>"Diproses"</b> setelah pelanggan melakukan pembayaran.</li>
                        <li>Pastikan Anda sudah menyiapkan / mengirimkan akun Premium sebelum mengubah status ke <b>"Selesai"</b>.</li>
                        <li>Pesanan yang statusnya <b>"Dibatalkan"</b> tidak akan masuk ke hitungan total pendapatan dashboard.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>