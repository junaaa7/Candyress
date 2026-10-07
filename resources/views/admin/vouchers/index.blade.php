<x-admin-layout>
    <div class="mx-auto max-w-6xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-3xl font-bold">Manajemen <span class="text-brand-600">Voucher Promo</span> 🎟️</h1>
            <a href="{{ route('admin.vouchers.create') }}" class="cute-btn cute-btn-primary px-6 py-2.5">
                + Buat Voucher Baru
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
            <table class="cute-table min-w-[44rem]">
                <thead>
                    <tr>
                        <th>Kode Promo</th>
                        <th>Nilai Diskon</th>
                        <th>Masa Berlaku</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vouchers as $voucher)
                    <tr>
                        <td>
                            <span class="inline-block rounded-lg border-2 border-dashed border-brand-300 bg-brand-100 px-3 py-1 font-bold tracking-widest text-brand-600">{{ $voucher->code }}</span>
                        </td>
                        <td class="font-bold text-brand-600">
                            @if($voucher->discount_type == 'nominal')
                                Rp {{ number_format($voucher->discount_value, 0, ',', '.') }}
                            @else
                                {{ $voucher->discount_value }}%
                            @endif
                        </td>
                        <td class="text-mauve">
                            {{ $voucher->valid_until ? $voucher->valid_until->format('d M Y') : 'Tanpa Batas' }}
                        </td>
                        <td>
                            @if($voucher->isExpired())
                                <span class="inline-block rounded-full border-2 border-gray-300 bg-gray-100 px-3.5 py-0.5 text-xs font-bold text-gray-500">Kedaluwarsa</span>
                            @elseif($voucher->is_active)
                                <span class="inline-block rounded-full border-2 border-emerald-200 bg-mint px-3.5 py-0.5 text-xs font-bold text-emerald-700">Aktif</span>
                            @else
                                <span class="inline-block rounded-full border-2 border-brand-300 bg-brand-100 px-3.5 py-0.5 text-xs font-bold text-rose-600">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2.5">
                                <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="cute-act cute-act-edit">Edit</a>
                                <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus voucher ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cute-act cute-act-del">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center font-semibold text-mauve">Belum ada voucher yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
