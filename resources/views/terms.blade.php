@extends('layouts.store')

@section('title', 'Syarat dan Ketentuan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl shadow-sm border border-brand-100 p-8 sm:p-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 font-display">Syarat dan Ketentuan</h1>
        
        <div class="prose prose-pink max-w-none text-gray-600 space-y-6">
            <p>Selamat datang di Candyress. Sebelum mendaftar atau menggunakan layanan kami, harap baca Syarat dan Ketentuan ini dengan saksama.</p>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">1. Layanan Kami</h3>
            <p>Candyress adalah platform penjualan akun premium digital. Semua produk yang kami sediakan adalah resmi dan mematuhi ketentuan dari penyedia layanan aslinya.</p>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">2. Akun Pengguna</h3>
            <p>Anda bertanggung jawab untuk menjaga kerahasiaan kata sandi dan informasi akun Anda. Candyress tidak bertanggung jawab atas kerugian yang ditimbulkan akibat kelalaian Anda dalam menjaga akun.</p>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">3. Kebijakan Pembelian</h3>
            <p>Setiap pembelian bersifat final (non-refundable) kecuali apabila terdapat kendala dari sisi Candyress yang menyebabkan akun tidak dapat digunakan sesuai dengan waktu garansi yang dijanjikan.</p>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">4. Larangan</h3>
            <ul class="list-disc pl-5 space-y-2">
                <li>Mengubah kata sandi, email, atau profil pada akun _shared_ (berbagi) yang kami sediakan, kecuali akun berstatus _private_.</li>
                <li>Menjual kembali produk dari Candyress tanpa izin resmi.</li>
                <li>Menggunakan bug atau eksploitasi pada website Candyress.</li>
            </ul>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-4">5. Pelanggaran Ketentuan</h3>
            <p>Kami berhak memblokir akun pelanggan atau mencabut akses premium yang telah dibeli apabila terbukti melanggar Syarat dan Ketentuan ini, tanpa adanya pengembalian dana.</p>

            <p class="mt-8 text-sm italic">Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p>
        </div>
    </div>
</div>
@endsection
