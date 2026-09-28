<x-admin-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.customers.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Kembali</a>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pelanggan: {{ $customer->name }}</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Kiri: Profil Pelanggan -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 text-center">
                    <div class="h-20 w-20 rounded-full bg-blue-100 text-blue-600 mx-auto flex items-center justify-center text-2xl font-bold mb-4">
                        {{ substr($customer->name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h2>
                    <p class="text-gray-500 text-sm mb-4">{{ $customer->email }}</p>
                    
                    @if($customer->is_active)
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 mb-4">Akun Aktif</span>
                    @else
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 mb-4">Akun Nonaktif</span>
                    @endif

                    <div class="border-t pt-4 text-left">
                        <p class="text-sm text-gray-500 mb-1">No. Handphone / WA</p>
                        <p class="font-medium text-gray-900 mb-3">{{ $customer->phone ?? 'Belum ditambahkan' }}</p>
                        
                        <p class="text-sm text-gray-500 mb-1">Bergabung Sejak</p>
                        <p class="font-medium text-gray-900">{{ $customer->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Kanan: Riwayat Pembelian -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Riwayat Pembelian</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($customer->orders->sortByDesc('created_at') as $order)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-blue-600 font-medium">
                                        <a href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->order_number }}</a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($order->status == 'pending')
                                            <span class="text-yellow-600 font-semibold">Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="text-blue-600 font-semibold">Diproses</span>
                                        @elseif($order->status == 'completed')
                                            <span class="text-green-600 font-semibold">Selesai</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">Pelanggan ini belum pernah melakukan pembelian.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>