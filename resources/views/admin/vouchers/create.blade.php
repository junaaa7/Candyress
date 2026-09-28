<x-admin-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.vouchers.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Kembali</a>
            <h1 class="text-2xl font-bold text-gray-800">Buat Voucher Baru</h1>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admin.vouchers.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Voucher</label>
                        <input type="text" name="code" placeholder="Contoh: PROMOAI2026" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Diskon</label>
                        <select name="discount_type" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="nominal">Nominal (Rp)</option>
                            <option value="persen">Persentase (%)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nilai Diskon</label>
                        <input type="number" name="discount_value" required min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Batas Berlaku (Expired Date)</label>
                        <input type="date" name="valid_until" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika voucher berlaku selamanya.</p>
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Langsung Aktifkan Voucher Ini</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-medium">
                        Simpan Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>