<x-admin-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.premium-accounts.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Kembali</a>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Stok Akun</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admin.premium-accounts.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Pilih Produk -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Produk</label>
                        <select name="product_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Paket Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Email & Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email / Username Akun</label>
                        <input type="text" name="email" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Akun</label>
                        <input type="text" name="password" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Masa Berlaku & Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Masa Berlaku (Expired At)</label>
                        <input type="date" name="expired_at" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <span class="text-xs text-gray-500">Kosongkan jika tidak ada batas waktu.</span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Ketersediaan</label>
                        <select name="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="tersedia">Tersedia (Siap Jual)</option>
                            <option value="terjual">Terjual</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-medium">
                        Simpan Stok Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>