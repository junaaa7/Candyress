<x-admin-layout>
    <div class="mx-auto max-w-4xl rounded-4xl bg-gradient-to-b from-brand-100/60 to-brand-50 p-6">
        <div class="mb-6 flex flex-wrap items-center gap-4">
            <a href="{{ route('admin.premium-accounts.index') }}" class="cute-btn cute-btn-ghost px-4 py-1.5 text-sm">&larr; Kembali</a>
            <h1 class="text-3xl font-bold">Edit <span class="text-brand-600">Stok Akun</span> 🔑</h1>
        </div>

        <div class="cute-card p-7">
            <form action="{{ route('admin.premium-accounts.update', $premium_account->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-7 grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div class="md:col-span-2">
                        <label class="cute-label">Pilih Produk</label>
                        <select name="product_id" required class="cute-select">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $premium_account->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="cute-label">Email / Username Akun</label>
                        <input type="text" name="email" value="{{ old('email', $premium_account->email) }}" required class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Password Akun</label>
                        <input type="text" name="password" value="{{ old('password', $premium_account->password) }}" required class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Masa Berlaku (Expired At)</label>
                        <input type="date" name="expired_at" value="{{ old('expired_at', $premium_account->expired_at ? $premium_account->expired_at->format('Y-m-d') : '') }}" class="cute-input">
                    </div>

                    <div>
                        <label class="cute-label">Status Ketersediaan</label>
                        <select name="status" required class="cute-select">
                            <option value="tersedia" {{ $premium_account->status == 'tersedia' ? 'selected' : '' }}>Tersedia (Siap Jual)</option>
                            <option value="terjual" {{ $premium_account->status == 'terjual' ? 'selected' : '' }}>Terjual</option>
                        </select>
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