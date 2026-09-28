<x-admin-layout>
    <div class="p-6 max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Manajemen Review Pelanggan</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan & Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Komentar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviews as $review)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $review->user->name ?? 'User Dihapus' }}</div>
                            <div class="text-xs text-blue-600 font-medium">{{ $review->product->name ?? 'Produk Dihapus' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        ★
                                    @else
                                        <span class="text-gray-300">★</span>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate" title="{{ $review->comment }}">
                            {{ $review->comment ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($review->is_visible)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tampil</span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">Disembunyikan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium flex gap-3 items-center mt-2">
                            <!-- Tombol Sembunyikan/Tampilkan -->
                            <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="{{ $review->is_visible ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }}">
                                    {{ $review->is_visible ? 'Sembunyikan' : 'Tampilkan' }}
                                </button>
                            </form>
                            
                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus review ini permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada ulasan dari pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>