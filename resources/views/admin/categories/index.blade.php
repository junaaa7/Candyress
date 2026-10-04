<x-admin-layout>
    <div class="mx-auto max-w-5xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-3xl font-bold">Manajemen <span class="text-brand-600">Kategori</span> 🏷️</h1>
            <a href="{{ route('admin.categories.create') }}" class="cute-btn cute-btn-primary px-6 py-2.5">
                + Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="mb-5 flex items-center gap-3 rounded-2xl border-2 border-dashed border-emerald-300 bg-mint px-5 py-3.5 font-bold text-emerald-700" role="status">
                <svg class="h-6 w-6 flex-none" viewBox="0 0 24 24" fill="#fff" stroke="#1F7A57" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6" fill="none"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="cute-card overflow-x-auto p-3">
            <table class="cute-table min-w-[40rem]">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Slug (URL)</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="font-bold">{{ $category->name }}</td>
                        <td class="font-mono text-sm text-mauve">{{ $category->slug }}</td>
                        <td>
                            <span class="cute-pill">{{ $category->products_count }} Produk</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2.5">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="cute-act cute-act-edit">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Menghapus kategori ini juga akan MENGHAPUS SEMUA PRODUK di dalamnya. Yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cute-act cute-act-del">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center font-semibold text-mauve">Belum ada kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
