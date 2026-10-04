<x-admin-layout>
    <div class="mx-auto max-w-7xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <h1 class="mb-6 text-3xl font-bold">Daftar <span class="text-brand-600">Customer</span> 👥</h1>

        @if(session('success'))
            <div class="mb-5 flex items-center gap-3 rounded-2xl border-2 border-dashed border-emerald-300 bg-mint px-5 py-3.5 font-bold text-emerald-700" role="status">
                <svg class="h-6 w-6 flex-none" viewBox="0 0 24 24" fill="#fff" stroke="#1F7A57" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6" fill="none"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="cute-card overflow-x-auto p-3">
            <table class="cute-table min-w-[48rem]">
                <thead>
                    <tr>
                        <th>Nama & Email</th>
                        <th>No. HP</th>
                        <th>Bergabung</th>
                        <th>Status Akun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td class="whitespace-nowrap">
                            <div class="font-bold">{{ $customer->name }}</div>
                            <div class="text-sm text-mauve">{{ $customer->email }}</div>
                        </td>
                        <td class="whitespace-nowrap">
                            {{ $customer->phone ?? '-' }}
                        </td>
                        <td class="whitespace-nowrap text-mauve">
                            {{ $customer->created_at->format('d M Y') }}
                        </td>
                        <td class="whitespace-nowrap">
                            @if($customer->is_active)
                                <span class="inline-block rounded-full border-2 border-emerald-200 bg-mint px-3.5 py-0.5 text-xs font-bold text-emerald-700">Aktif</span>
                            @else
                                <span class="inline-block rounded-full border-2 border-brand-300 bg-brand-100 px-3.5 py-0.5 text-xs font-bold text-rose-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap">
                            <div class="flex items-center gap-2.5">
                                <a href="{{ route('admin.customers.show', $customer->id) }}" class="cute-act cute-act-edit">Lihat Detail</a>

                                <form action="{{ route('admin.customers.toggle-status', $customer->id) }}" method="POST" onsubmit="return confirm('Yakin ingin {{ $customer->is_active ? 'menonaktifkan' : 'mengaktifkan' }} akun ini?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="cute-act {{ $customer->is_active ? 'cute-act-del' : 'border-emerald-200 bg-mint text-emerald-700 hover:bg-emerald-100' }}">
                                        {{ $customer->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center font-semibold text-mauve">Belum ada pelanggan yang terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
