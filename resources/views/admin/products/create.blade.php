@extends('layouts.admin.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Produk Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Tambahkan layanan akun premium ke katalog Candyress.</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="text-brand-600 hover:text-brand-800 font-medium text-sm">&larr; Kembali</a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
    @csrf

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
            <div class="flex items-center gap-2 text-red-700 font-semibold mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Terdapat kesalahan pada input Anda:
            </div>
            <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nama Produk -->
        <div class="md:col-span-2">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Netflix Premium 1 Bulan UHD" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm transition">
        </div>

        <!-- Kategori -->
        <div>
            <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
            <select name="category_id" id="category_id" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm transition">
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tipe Produk -->
        <div>
            <label for="product_type" class="block text-sm font-semibold text-gray-700 mb-2">Tipe Produk <span class="text-red-500">*</span></label>
            <select name="product_type" id="product_type" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm transition">
                <option value="Shared Account" {{ old('product_type') == 'Shared Account' ? 'selected' : '' }}>Shared Account</option>
                <option value="Private Account" {{ old('product_type') == 'Private Account' ? 'selected' : '' }}>Private Account</option>
                <option value="License Key" {{ old('product_type') == 'License Key' ? 'selected' : '' }}>License Key / Invite Link</option>
            </select>
        </div>

        <!-- Harga -->
        <div>
            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Normal (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="Contoh: 50000" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm transition">
        </div>

        <!-- Harga Diskon -->
        <div>
            <label for="discount_price" class="block text-sm font-semibold text-gray-700 mb-2">Harga Diskon (Rp)</label>
            <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price') }}" placeholder="Kosongkan jika tidak ada diskon" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm transition">
            <p class="text-xs text-gray-500 mt-1">Isi jika sedang mengadakan promo harga coret.</p>
        </div>

        <!-- Thumbnail Upload -->
        <div class="md:col-span-2">
            <label for="thumbnail" class="block text-sm font-semibold text-gray-700 mb-2">Thumbnail Produk (Opsional)</label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition">
        </div>

        <!-- Deskripsi -->
        <div class="md:col-span-2">
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Produk <span class="text-red-500">*</span></label>
            <textarea name="description" id="description" rows="5" class="w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm transition" placeholder="Jelaskan fitur, durasi, syarat & ketentuan...">{{ old('description') }}</textarea>
        </div>

        <!-- Status Aktif -->
        <div class="md:col-span-2 flex items-center mt-2">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500 w-5 h-5">
            <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">Tampilkan produk ini di toko (Aktif)</label>
        </div>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
        <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition shadow-sm">Batal</a>
        <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold transition shadow-sm">Simpan Produk</button>
    </div>
</form>
@endsection