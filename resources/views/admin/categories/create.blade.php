<x-admin-layout>
    <div class="mx-auto max-w-2xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('admin.categories.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">&larr; Kembali</a>
            <h1 class="text-3xl font-bold">Tambah <span class="text-brand-600">Kategori</span> 🏷️</h1>
        </div>

        <div class="cute-card p-7">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="cute-label">Nama Kategori (Contoh: Streaming, AI, Design)</label>
                    <input type="text" name="name" required class="cute-input @error('name') border-rose-400 @enderror">
                    @error('name')
                        <p class="mt-1.5 text-xs font-bold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label class="cute-label">Default Syarat & Ketentuan (S&K)</label>
                    <textarea name="default_snk" rows="4" class="cute-input resize-y" placeholder="Contoh: Dilarang mengubah password & profil..."></textarea>
                    <p class="mt-1 text-xs text-gray-500">S&K ini akan otomatis berlaku untuk semua produk dalam kategori ini (kecuali dioverride di produk).</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="cute-btn cute-btn-primary px-8 py-3">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>