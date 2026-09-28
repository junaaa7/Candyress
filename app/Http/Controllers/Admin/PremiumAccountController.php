<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PremiumAccount;
use App\Models\Product;
use Illuminate\Http\Request;

class PremiumAccountController extends Controller
{
    public function index()
    {
        $accounts = PremiumAccount::with('product')->latest()->get();
        return view('admin.premium_accounts.index', compact('accounts'));
    }

    public function create()
    {
        // Hanya ambil produk yang aktif untuk ditambahkan stoknya
        $products = Product::where('is_active', true)->get();
        return view('admin.premium_accounts.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'email' => 'required|email',
            'password' => 'required|string',
            'status' => 'required|in:tersedia,terjual',
            'expired_at' => 'nullable|date',
        ]);

        PremiumAccount::create($validated);

        return redirect()->route('admin.premium-accounts.index')->with('success', 'Stok Akun berhasil ditambahkan!');
    }

    public function edit(PremiumAccount $premium_account)
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.premium_accounts.edit', compact('premium_account', 'products'));
    }

    public function update(Request $request, PremiumAccount $premium_account)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'email' => 'required|email',
            'password' => 'required|string',
            'status' => 'required|in:tersedia,terjual',
            'expired_at' => 'nullable|date',
        ]);

        $premium_account->update($validated);

        return redirect()->route('admin.premium-accounts.index')->with('success', 'Detail stok akun berhasil diperbarui!');
    }

    public function destroy(PremiumAccount $premium_account)
    {
        $premium_account->delete();
        return redirect()->route('admin.premium-accounts.index')->with('success', 'Stok Akun berhasil dihapus!');
    }
}