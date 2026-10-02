<x-admin-layout>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Stok</h1>
            <p class="text-gray-500">Input stok akun premium secara satuan atau masal.</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Form Input Stok -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold mb-4">Input Stok Baru</h2>
                <form action="{{ route('admin.stocks.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-2">Pilih Produk</label>
                        <select name="product_id" required class="w-full rounded-lg border-gray-200 focus:ring-pink-500 focus:border-pink-500 text-sm">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->available_stock ?? 0 }} tersedia)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-2">Data Kredensial</label>
                        <textarea name="credentials" rows="8" required class="w-full rounded-lg border-gray-200 focus:ring-pink-500 focus:border-pink-500 text-sm font-mono text-xs" placeholder="Format:
email,password,pin,info

Contoh:
user1@gmail.com,pass123,1234,Profile 1
user2@gmail.com,pass456,,Profile 2
(Satu baris untuk satu akun)"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        Simpan Stok
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Stok -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold">Daftar Stok Terakhir</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-4 font-semibold text-gray-600">Produk</th>
                                <th class="p-4 font-semibold text-gray-600">Email</th>
                                <th class="p-4 font-semibold text-gray-600">Status</th>
                                <th class="p-4 font-semibold text-gray-600">Tgl Input</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($stocks as $stock)
                            <tr class="hover:bg-gray-50/50">
                                <td class="p-4">
                                    <span class="font-medium text-gray-800">{{ $stock->product->name }}</span>
                                </td>
                                <td class="p-4 font-mono text-xs text-gray-600">{{ $stock->email }}</td>
                                <td class="p-4">
                                    @if($stock->status === 'available')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Terjual</span>
                                    @endif
                                </td>
                                <td class="p-4 text-gray-500">{{ $stock->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-500">Belum ada data stok.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100">
                    {{ $stocks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
