<x-admin-layout>
    <div class="p-6 max-w-2xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Kembali</a>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Kategori</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori (Contoh: Streaming, AI, Design)</label>
                    <input type="text" name="name" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>