<x-admin-layout>
    <div class="mx-auto max-w-4xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('admin.products.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">&larr; Kembali</a>
            <h1 class="text-3xl font-bold">Tambah <span class="text-brand-600">Produk Baru</span> 🛍️</h1>
        </div>

        <div class="cute-card p-7">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-7 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Nama Produk -->
                    <div>
                        <label class="cute-label">Nama Paket (Contoh: Netflix Premium)</label>
                        <input type="text" name="name" required class="cute-input">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="cute-label">Kategori</label>
                        <select name="category_id" required class="cute-select">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="cute-label">Harga (Rp)</label>
                        <input type="number" name="price" required class="cute-input">
                    </div>

                    <!-- Durasi -->
                    <div>
                        <label class="cute-label">Durasi (Contoh: 1 Bulan, 1 Tahun)</label>
                        <input type="text" name="duration_label" required class="cute-input">
                    </div>

                    <!-- Tipe Produk -->
                    <div>
                        <label class="cute-label">Tipe Akun</label>
                        <select name="product_type" required class="cute-select">
                            <option value="Shared Account">Shared Account</option>
                            <option value="Private Account">Private Account</option>
                            <option value="License Key">License Key</option>
                        </select>
                    </div>

                    <!-- Upload Gambar / Thumbnail -->
                    <div>
                        <label class="cute-label">Gambar Produk (Opsional)</label>
                        <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-mauve file:mr-4 file:cursor-pointer file:rounded-full file:border-0 file:bg-brand-100 file:px-5 file:py-2.5 file:text-sm file:font-bold file:text-brand-600 hover:file:bg-brand-200">
                    </div>

                    <!-- Status Aktif -->
                    <div class="flex h-full items-center pt-2 md:col-span-2">
                        <label class="flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" checked class="h-[1.15rem] w-[1.15rem] cursor-pointer rounded border-2 border-brand-200 text-brand-300 focus:ring-brand-300">
                            <span class="text-sm font-semibold">Aktifkan Produk Ini (Bisa dibeli)</span>
                        </label>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-5">
                    <label class="cute-label">Deskripsi Produk</label>
                    <textarea name="description" rows="3" required class="cute-input resize-y"></textarea>
                </div>

                <!-- Petunjuk Login -->
                <div class="mb-5">
                    <label class="cute-label">Petunjuk Login (Login Instructions)</label>
                    <textarea name="login_instructions" rows="3" class="cute-input resize-y" placeholder="Langkah-langkah login bagi pelanggan..."></textarea>
                </div>

                <!-- Syarat & Ketentuan Spesifik (Opsional) -->
                <div class="mb-7">
                    <label class="cute-label">S&K Khusus Produk (Kosongkan jika ikut Kategori)</label>
                    <textarea name="terms_and_conditions" rows="3" class="cute-input resize-y" placeholder="Tambahan larangan / aturan untuk produk ini..."></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="cute-btn cute-btn-primary px-8 py-3">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>