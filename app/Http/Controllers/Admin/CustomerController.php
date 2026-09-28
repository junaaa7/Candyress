<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 1. Melihat daftar customer
    public function index()
    {
        $customers = User::where('role', 'customer')->latest()->get();
        return view('admin.customers.index', compact('customers'));
    }

    // 2. Melihat detail customer & riwayat pembelian
    public function show(User $customer)
    {
        // Pastikan admin hanya bisa melihat data dengan role customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        // Memuat riwayat pesanan pelanggan beserta produknya
        $customer->load(['orders.products', 'orders.payment']);
        
        return view('admin.customers.show', compact('customer'));
    }

    // 3. Mengubah status aktif/nonaktif akun
    public function toggleStatus(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->update([
            'is_active' => !$customer->is_active
        ]);

        $status = $customer->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Akun pelanggan berhasil $status!");
    }
}