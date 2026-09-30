<x-admin-layout>
    <div class="mx-auto max-w-7xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-3xl font-bold">Manajemen <span class="text-brand-600">Stok Akun</span> 🔑</h1>
            <a href="{{ route('admin.premium-accounts.create') }}" class="cute-btn cute-btn-primary px-6 py-2.5">
                + Tambah Stok Akun
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
            <table class="cute-table min-w-[46rem]">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kredensial (Email / Pass)</th>
                        <th>Masa Berlaku</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                    <tr>
                        <td>
                            <span class="font-bold">{{ $account->product->name ?? 'Produk Dihapus' }}</span>
                        </td>
                        <td>
                            <div class="font-mono text-sm">{{ $account->email }}</div>
                            <div class="mt-1 inline-block rounded-lg bg-brand-100 px-2.5 py-0.5 font-mono text-xs text-mauve">P: {{ $account->password }}</div>
                        </td>
                        <td>
                            {{ $account->expired_at ? $account->expired_at->format('d M Y') : 'Tanpa batas' }}
                        </td>
                        <td>
                            @if($account->status == 'tersedia')
                                <span class="inline-block rounded-full border-2 border-emerald-200 bg-mint px-3.5 py-0.5 text-xs font-bold text-emerald-700">Tersedia</span>
                            @else
                                <span class="inline-block rounded-full border-2 border-brand-300 bg-brand-100 px-3.5 py-0.5 text-xs font-bold text-rose-600">Terjual</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2.5">
                                <a href="{{ route('admin.premium-accounts.edit', $account->id) }}" class="cute-act cute-act-edit">Edit</a>
                                <form action="{{ route('admin.premium-accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini dari stok?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cute-act cute-act-del">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center font-semibold text-mauve">Belum ada stok akun yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>