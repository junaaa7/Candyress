<x-admin-layout>
    <div class="p-6 max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Voucher Promo</h1>
            <a href="{{ route('admin.vouchers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                + Buat Voucher Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Promo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai Diskon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Masa Berlaku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vouchers as $voucher)
                    <tr>
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-900 px-2 py-1 bg-gray-100 border rounded tracking-widest">{{ $voucher->code }}</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-blue-600">
                            @if($voucher->discount_type == 'nominal')
                                Rp {{ number_format($voucher->discount_value, 0, ',', '.') }}
                            @else
                                {{ $voucher->discount_value }}%
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $voucher->valid_until ? $voucher->valid_until->format('d M Y') : 'Tanpa Batas' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($voucher->is_active)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium flex gap-3">
                            <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus voucher ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada voucher yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>