<x-admin-layout>
    <div class="mx-auto max-w-3xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('admin.vouchers.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">&larr; Kembali</a>
            <h1 class="text-3xl font-bold">Buat <span class="text-brand-600">Voucher Baru</span> 🎟️</h1>
        </div>

        <div class="cute-card p-7">
            <form action="{{ route('admin.vouchers.store') }}" method="POST">
                @csrf
                <div class="mb-7 grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div class="md:col-span-2">
                        <label class="cute-label">Kode Voucher</label>
                        <input type="text" name="code" placeholder="Contoh: PROMOAI2026" required class="cute-input uppercase">
                    </div>

                    <div>
                        <label class="cute-label">Tipe Diskon</label>
                        <select name="discount_type" required class="cute-select">
                            <option value="nominal">Nominal (Rp)</option>
                            <option value="persen">Persentase (%)</option>
                        </select>
                    </div>

                    <div>
                        <label class="cute-label">Nilai Diskon</label>
                        <input type="number" name="discount_value" required min="1" class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Batas Berlaku (Expired Date)</label>
                        <input type="date" name="valid_until" class="cute-input">
                        <p class="cute-hint">Kosongkan jika voucher berlaku selamanya.</p>
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" checked class="h-[1.15rem] w-[1.15rem] cursor-pointer rounded border-2 border-brand-200 text-brand-300 focus:ring-brand-300">
                            <span class="text-sm font-semibold">Langsung Aktifkan Voucher Ini</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="cute-btn cute-btn-primary px-8 py-3">
                        Simpan Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
