<x-admin-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Kembali</a>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan #{{ $order->order_number }}</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kiri: Detail Produk yang Dibeli & Info Pelanggan -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Daftar Produk -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Produk yang Dibeli</h2>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->products as $product)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $product->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">Rp {{ number_format($product->pivot->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $product->pivot->quantity }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 font-medium">
                                    Rp {{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right text-sm font-bold text-gray-700">TOTAL PEMBAYARAN:</td>
                                <td class="px-4 py-3 text-sm font-bold text-blue-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Info Pelanggan -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Pelanggan</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-medium text-gray-900">{{ $order->user->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Alamat Email</p>
                            <p class="font-medium text-gray-900">{{ $order->user->email ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">No. HP / WhatsApp</p>
                            <p class="font-medium text-gray-900">{{ $order->user->phone ?? 'Tidak dicantumkan' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kanan: Status & Aksi -->
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Ubah Status Pesanan</h2>
                    
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Saat Ini:</label>
                            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran)</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses (Sudah Dibayar)</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai (Akun Dikirim)</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 font-medium transition">
                            Perbarui Status
                        </button>
                    </form>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h3 class="text-sm font-bold text-gray-700 mb-2">Informasi Penting</h3>
                    <ul class="text-xs text-gray-600 space-y-2 list-disc pl-4">
                        <li>Ubah status ke <b>"Diproses"</b> setelah pelanggan melakukan pembayaran.</li>
                        <li>Pastikan Anda sudah menyiapkan / mengirimkan akun Premium sebelum mengubah status ke <b>"Selesai"</b>.</li>
                        <li>Pesanan yang statusnya <b>"Dibatalkan"</b> tidak akan masuk ke hitungan total pendapatan dashboard.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>