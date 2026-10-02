<x-admin-layout>
    <div class="mx-auto max-w-4xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('admin.products.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">&larr; Kembali</a>
            <h1 class="text-3xl font-bold">Edit Produk: <span class="text-brand-600">{{ $product->name }}</span> 🛍️</h1>
        </div>

        <div class="cute-card p-7">
            <!-- Form mengarah ke route update dan menggunakan method PUT -->
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-7 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="cute-label">Nama Paket</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Kategori</label>
                        <select name="category_id" required class="cute-select">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="cute-label">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Durasi</label>
                        <input type="text" name="duration_label" value="{{ old('duration_label', $product->duration_label) }}" required class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Tipe Akun</label>
                        <select name="product_type" required class="cute-select">
                            <option value="Shared Account" {{ $product->product_type == 'Shared Account' ? 'selected' : '' }}>Shared Account</option>
                            <option value="Private Account" {{ $product->product_type == 'Private Account' ? 'selected' : '' }}>Private Account</option>
                            <option value="License Key" {{ $product->product_type == 'License Key' ? 'selected' : '' }}>License Key</option>
                        </select>
                    </div>

                    <!-- Upload & Pratinjau Gambar -->
                    <div>
                        <label class="cute-label">Gambar Produk</label>
                        @if($product->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail" class="h-16 w-16 rounded-2xl border-[3px] border-brand-100 object-cover shadow-sticker-sm">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-mauve file:mr-4 file:cursor-pointer file:rounded-full file:border-0 file:bg-brand-100 file:px-5 file:py-2.5 file:text-sm file:font-bold file:text-brand-600 hover:file:bg-brand-200">
                        <span class="cute-hint">Biarkan kosong jika tidak ingin mengubah gambar.</span>
                    </div>

                    <div class="flex h-full items-center pt-2 md:col-span-2">
                        <label class="flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="h-[1.15rem] w-[1.15rem] cursor-pointer rounded border-2 border-brand-200 text-brand-300 focus:ring-brand-300">
                            <span class="text-sm font-semibold">Aktifkan Produk Ini (Bisa dibeli)</span>
                        </label>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="cute-label">Deskripsi Produk</label>
                    <textarea name="description" rows="3" required class="cute-input resize-y">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mb-5">
                    <label class="cute-label">Petunjuk Login (Login Instructions)</label>
                    <textarea name="login_instructions" rows="3" class="cute-input resize-y" placeholder="Langkah-langkah login bagi pelanggan...">{{ old('login_instructions', $product->login_instructions) }}</textarea>
                </div>

                <div class="mb-7">
                    <label class="cute-label">S&K Khusus Produk (Kosongkan jika ikut Kategori)</label>
                    <textarea name="terms_and_conditions" rows="3" class="cute-input resize-y" placeholder="Tambahan larangan / aturan untuk produk ini...">{{ old('terms_and_conditions', $product->terms_and_conditions) }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="cute-btn cute-btn-primary px-8 py-3">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>