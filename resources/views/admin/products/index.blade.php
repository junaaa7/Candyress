@extends('layouts.admin.app')

@section('title', 'Kelola Produk')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm">
            + Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-sm text-gray-500">
                        <th class="p-4 font-semibold">Nama Produk</th>
                        <th class="p-4 font-semibold">Kategori</th>
                        <th class="p-4 font-semibold">Harga</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($products as $product)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                            <td class="p-4 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="p-4 text-gray-500">{{ $product->category->name ?? '-' }}</td>
                            <td class="p-4 text-brand-600 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <span class="text-gray-300">|</span>
                                <a href="#" class="text-red-600 hover:text-red-800 font-medium">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">Belum ada produk. Silakan tambah produk baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    </div>
@endsection