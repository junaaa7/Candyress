@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Overview</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-2xl">📦</div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Produk</p>
                <h3 class="text-2xl font-bold text-gray-900">0</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-2xl">🛒</div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pesanan Aktif</p>
                <h3 class="text-2xl font-bold text-gray-900">0</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-2xl">💰</div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pendapatan</p>
                <h3 class="text-2xl font-bold text-gray-900">Rp 0</h3>
            </div>
        </div>
    </div>
@endsection