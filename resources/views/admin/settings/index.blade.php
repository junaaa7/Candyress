<x-admin-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan Toko</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    <!-- Informasi Dasar -->
                    <div class="md:col-span-2 border-b pb-4 mb-2">
                        <h2 class="text-lg font-semibold text-gray-800">Informasi Dasar</h2>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Toko</label>
                        <input type="text" name="store_name" value="{{ old('store_name', $setting->store_name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Logo Toko</label>
                        @if($setting->logo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="h-16 w-auto object-contain bg-gray-50 border rounded p-1">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar QRIS (Untuk Pembayaran)</label>
                        @if($setting->qris_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $setting->qris_image) }}" alt="QRIS" class="h-16 w-16 object-cover border rounded">
                            </div>
                        @endif
                        <input type="file" name="qris_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700">
                    </div>

                    <!-- Kontak & Pembayaran -->
                    <div class="md:col-span-2 border-b pb-4 mb-2 mt-4">
                        <h2 class="text-lg font-semibold text-gray-800">Kontak & Pembayaran</h2>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp (Format: 628xxx)</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $setting->whatsapp) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Toko</label>
                        <input type="email" name="email" value="{{ old('email', $setting->email) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Informasi Rekening Bank</label>
                        <textarea name="bank_account" rows="3" placeholder="BCA: 123456789 a.n. Candyress&#10;Mandiri: 987654321 a.n. Candyress" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('bank_account', $setting->bank_account) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Informasi Singkat Toko / Slogan</label>
                        <textarea name="store_info" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('store_info', $setting->store_info) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-medium">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>