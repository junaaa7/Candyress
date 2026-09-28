<x-admin-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Stok Akun</h1>
            <a href="{{ route('admin.premium-accounts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                + Tambah Stok Akun
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kredensial (Email / Pass)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masa Berlaku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($accounts as $account)
                    <tr>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900">{{ $account->product->name ?? 'Produk Dihapus' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 font-mono">{{ $account->email }}</div>
                            <div class="text-xs text-gray-500 font-mono">P: {{ $account->password }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $account->expired_at ? $account->expired_at->format('d M Y') : 'Tanpa batas' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($account->status == 'tersedia')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Terjual</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium flex gap-3">
                            <a href="{{ route('admin.premium-accounts.edit', $account->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('admin.premium-accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini dari stok?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada stok akun yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>