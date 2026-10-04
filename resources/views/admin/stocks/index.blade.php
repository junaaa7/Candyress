<x-admin-layout>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Stok</h1>
            <p class="text-gray-500">Input stok akun premium secara satuan atau masal.</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- Form Input Stok -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold mb-4">Input Stok Baru</h2>
                <form action="{{ route('admin.stocks.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-2">Pilih Produk</label>
                        <select name="product_id" required class="w-full rounded-lg border-gray-200 focus:ring-pink-500 focus:border-pink-500 text-sm">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->available_stock ?? 0 }} tersedia)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-2">Data Kredensial</label>
                        <textarea name="credentials" rows="8" required class="w-full rounded-lg border-gray-200 focus:ring-pink-500 focus:border-pink-500 text-sm font-mono text-xs" placeholder="Ketik atau tempel data akun secara bebas (Email, Password, Token, Link, PIN, dll). 
Seluruh teks yang Anda masukkan di sini akan disimpan sebagai 1 (satu) akun stok.

Contoh:
Email: user1@gmail.com
Pass: 12345
PIN: 199312
Link: https://invite.link/abc"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        Simpan Stok
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Stok -->
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold">Daftar Stok Terakhir</h2>
                </div>
                <div class="overflow-x-auto w-full -mx-4 sm:mx-0">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-4 font-semibold text-gray-600">Produk</th>
                                <th class="p-4 font-semibold text-gray-600">Data Akun / Kredensial</th>
                                <th class="p-4 font-semibold text-gray-600">Status</th>
                                <th class="p-4 font-semibold text-gray-600">Tgl Input</th>
                                <th class="p-4 font-semibold text-gray-600 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($stocks as $stock)
                            <tr class="hover:bg-gray-50/50">
                                <td class="p-4">
                                    <span class="font-medium text-gray-800">{{ $stock->product->name }}</span>
                                </td>
                                <td class="p-4 font-mono text-xs text-gray-600 whitespace-pre-wrap max-w-xs">{{ \Illuminate\Support\Str::limit($stock->credentials ?? $stock->email, 50) }}</td>
                                <td class="p-4">
                                    @if($stock->status === 'available')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Terjual</span>
                                    @endif
                                </td>
                                <td class="p-4 text-gray-500">{{ $stock->created_at->format('d M Y') }}</td>
                                <td class="p-4 text-right space-x-2">
                                    <button type="button" onclick="editStock({{ $stock->id }}, {{ json_encode($stock->credentials ?? $stock->email) }})" class="text-blue-500 hover:text-blue-700 text-xs font-bold bg-blue-50 px-2 py-1 rounded">Edit</button>
                                    <form action="{{ route('admin.stocks.destroy', $stock->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus stok ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold bg-red-50 px-2 py-1 rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">Belum ada data stok.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100">
                    {{ $stocks->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/50 items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-lg mx-4 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold">Edit Kredensial</h3>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <label class="block text-sm font-semibold mb-2">Data Kredensial</label>
                    <textarea id="editCredentials" name="credentials" rows="8" required class="w-full rounded-lg border-gray-200 focus:ring-pink-500 focus:border-pink-500 text-sm font-mono text-xs"></textarea>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-pink-500 rounded-lg hover:bg-pink-600">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editStock(id, credentials) {
            document.getElementById('editCredentials').value = credentials || '';
            document.getElementById('editForm').action = '/admin/stocks/' + id;
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
    </script>
</x-admin-layout>
