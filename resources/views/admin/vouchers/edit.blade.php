<x-admin-layout>
    <div class="mx-auto max-w-3xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('admin.vouchers.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">&larr; Kembali</a>
            <h1 class="text-3xl font-bold">Edit Voucher: <span class="text-brand-600">{{ $voucher->code }}</span> 🎟️</h1>
        </div>

        <div class="cute-card p-7">
            <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-7 grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div class="md:col-span-2">
                        <label class="cute-label">Kode Voucher</label>
                        <input type="text" name="code" value="{{ old('code', $voucher->code) }}" required class="cute-input uppercase">
                    </div>

                    <div>
                        <label class="cute-label">Tipe Diskon</label>
                        <select name="discount_type" required class="cute-select">
                            <option value="nominal" {{ $voucher->discount_type == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                            <option value="persen" {{ $voucher->discount_type == 'persen' ? 'selected' : '' }}>Persentase (%)</option>
                        </select>
                    </div>

                    <div>
                        <label class="cute-label">Nilai Diskon</label>
                        <input type="number" name="discount_value" value="{{ old('discount_value', $voucher->discount_value) }}" required min="1" class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Batas Berlaku (Expired Date)</label>
                        <input type="date" name="valid_until" value="{{ old('valid_until', $voucher->valid_until ? $voucher->valid_until->format('Y-m-d') : '') }}" class="cute-input">
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" {{ $voucher->is_active ? 'checked' : '' }} class="h-[1.15rem] w-[1.15rem] cursor-pointer rounded border-2 border-brand-200 text-brand-300 focus:ring-brand-300">
                            <span class="text-sm font-semibold">Aktifkan Voucher Ini</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="cute-btn cute-btn-primary px-8 py-3">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>