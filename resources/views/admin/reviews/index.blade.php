<x-admin-layout>
    <div class="mx-auto max-w-7xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <h1 class="mb-6 text-3xl font-bold">Manajemen <span class="text-brand-600">Review Pelanggan</span> ⭐</h1>

        @if(session('success'))
            <div class="mb-5 flex items-center gap-3 rounded-2xl border-2 border-dashed border-emerald-300 bg-mint px-5 py-3.5 font-bold text-emerald-700" role="status">
                <svg class="h-6 w-6 flex-none" viewBox="0 0 24 24" fill="#fff" stroke="#1F7A57" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6" fill="none"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="cute-card overflow-x-auto p-3">
            <table class="cute-table min-w-[52rem]">
                <thead>
                    <tr>
                        <th>Pelanggan & Produk</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                    <tr>
                        <td>
                            <div class="font-bold">{{ $review->user->name ?? 'User Dihapus' }}</div>
                            <div class="text-xs font-bold text-brand-600">{{ $review->product->name ?? 'Produk Dihapus' }}</div>
                        </td>
                        <td>
                            <div class="flex text-base text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        ★
                                    @else
                                        <span class="text-brand-200">★</span>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td class="max-w-xs truncate" title="{{ $review->comment }}">
                            {{ $review->comment ?? '-' }}
                        </td>
                        <td>
                            @if($review->is_visible)
                                <span class="inline-block rounded-full border-2 border-emerald-200 bg-mint px-3.5 py-0.5 text-xs font-bold text-emerald-700">Tampil</span>
                            @else
                                <span class="inline-block rounded-full border-2 border-brand-200 bg-brand-50 px-3.5 py-0.5 text-xs font-bold text-mauve">Disembunyikan</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2.5">
                                <!-- Tombol Sembunyikan/Tampilkan -->
                                <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="cute-act {{ $review->is_visible ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100' : 'border-emerald-200 bg-mint text-emerald-700 hover:bg-emerald-100' }}">
                                        {{ $review->is_visible ? 'Sembunyikan' : 'Tampilkan' }}
                                    </button>
                                </form>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus review ini permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cute-act cute-act-del">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center font-semibold text-mauve">Belum ada ulasan dari pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
