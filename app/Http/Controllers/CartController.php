<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Ambil atau buat keranjang untuk user yang sedang login
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        
        // Ambil item di dalam keranjang beserta data produknya
        $cartItems = $cart->items()->with('product')->latest()->get();
        
        return view('store.cart', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        
        // Cek apakah produk sudah ada di keranjang
        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            // Jika sudah ada, tambah quantity
            $cartItem->increment('quantity');
        } else {
            // Jika belum ada, buat item baru
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => 1
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function destroy($id)
    {
        // Pastikan item yang dihapus milik user yang sedang login
        $cartItem = CartItem::where('id', $id)->whereHas('cart', function($q) {
            $q->where('user_id', auth()->id());
        })->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}