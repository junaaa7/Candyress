<x-admin-layout>
    <div class="mx-auto max-w-4xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('admin.premium-accounts.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">&larr; Kembali</a>
            <h1 class="text-3xl font-bold">Tambah <span class="text-brand-600">Stok Akun</span> 🔑</h1>
        </div>

        <div class="cute-card p-7">
            <form action="{{ route('admin.premium-accounts.store') }}" method="POST">
                @csrf
                <div class="mb-7 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Pilih Produk -->
                    <div class="md:col-span-2">
                        <label class="cute-label">Pilih Produk</label>
                        <select name="product_id" required class="cute-select">
                            <option value="">-- Pilih Paket Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Email & Password -->
                    <div>
                        <label class="cute-label">Email / Username Akun</label>
                        <input type="text" name="email" required class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Password Akun</label>
                        <input type="text" name="password" required class="cute-input">
                    </div>

                    <!-- Masa Berlaku & Status -->
                    <div>
                        <label class="cute-label">Masa Berlaku (Expired At)</label>
                        <input type="date" name="expired_at" class="cute-input">
                        <span class="cute-hint">Kosongkan jika tidak ada batas waktu.</span>
                    </div>

                    <div>
                        <label class="cute-label">Status Ketersediaan</label>
                        <select name="status" required class="cute-select">
                            <option value="tersedia">Tersedia (Siap Jual)</option>
                            <option value="terjual">Terjual</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="cute-btn cute-btn-primary px-8 py-3">
                        Simpan Stok Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>