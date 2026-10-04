<x-admin-layout>
    <div class="mx-auto max-w-4xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <h1 class="mb-6 text-3xl font-bold">Pengaturan <span class="text-brand-600">Toko</span> ⚙️</h1>

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border-2 border-dashed border-emerald-300 bg-mint px-5 py-3.5 font-bold text-emerald-700" role="status">
                <svg class="h-6 w-6 flex-none" viewBox="0 0 24 24" fill="#fff" stroke="#1F7A57" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/><path d="M8 12.5l3 3 5-6" fill="none"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="cute-card p-7">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-7 grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- Informasi Dasar -->
                    <div class="mb-1 border-b-2 border-dashed border-brand-100 pb-3 md:col-span-2">
                        <h2 class="text-xl font-semibold">Informasi Dasar 🏪</h2>
                    </div>

                    <div class="md:col-span-2">
                        <label class="cute-label">Nama Toko</label>
                        <input type="text" name="store_name" value="{{ old('store_name', $setting->store_name) }}" required class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Logo Toko</label>
                        @if($setting->logo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="h-16 w-auto rounded-2xl border-2 border-brand-100 bg-brand-50 object-contain p-1">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-mauve file:mr-4 file:cursor-pointer file:rounded-full file:border-0 file:bg-brand-100 file:px-5 file:py-2.5 file:text-sm file:font-bold file:text-brand-600 hover:file:bg-brand-200">
                    </div>

                    <div>
                        <label class="cute-label">Gambar QRIS (Untuk Pembayaran)</label>
                        @if($setting->qris_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $setting->qris_image) }}" alt="QRIS" class="h-16 w-16 rounded-2xl border-2 border-brand-100 object-cover">
                            </div>
                        @endif
                        <input type="file" name="qris_image" accept="image/*" class="block w-full text-sm text-mauve file:mr-4 file:cursor-pointer file:rounded-full file:border-0 file:bg-brand-100 file:px-5 file:py-2.5 file:text-sm file:font-bold file:text-brand-600 hover:file:bg-brand-200">
                    </div>

                    <!-- Kontak & Pembayaran -->
                    <div class="mb-1 mt-4 border-b-2 border-dashed border-brand-100 pb-3 md:col-span-2">
                        <h2 class="text-xl font-semibold">Kontak & Pembayaran 💳</h2>
                    </div>

                    <div>
                        <label class="cute-label">Nomor WhatsApp (Format: 628xxx)</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $setting->whatsapp) }}" class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Email Toko</label>
                        <input type="email" name="email" value="{{ old('email', $setting->email) }}" class="cute-input">
                    </div>

                    <div class="md:col-span-2">
                        <label class="cute-label">Informasi Rekening Bank</label>
                        <textarea name="bank_account" rows="3" placeholder="BCA: 123456789 a.n. Candyress&#10;Mandiri: 987654321 a.n. Candyress" class="cute-input resize-y">{{ old('bank_account', $setting->bank_account) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="cute-label">Informasi Singkat Toko / Slogan</label>
                        <textarea name="store_info" rows="3" class="cute-input resize-y">{{ old('store_info', $setting->store_info) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end border-t-2 border-dashed border-brand-100 pt-5">
                    <button type="submit" class="cute-btn cute-btn-primary px-8 py-3">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
