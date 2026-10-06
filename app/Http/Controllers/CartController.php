<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
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
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $availableStock = $product->productStocks()->where('status', 'available')->count();
        if ($availableStock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok produk ini baru saja habis!');
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        if ($request->has('buy_now') && $request->buy_now == '1') {
            // Clear existing cart items for buy now action
            $cart->items()->delete();
        }

        // Cek apakah produk sudah ada di keranjang
        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            // Jika sudah ada, tambah quantity
            $cartItem->increment('quantity');
        } else {
            // Jika belum ada, buat item baru
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => 1,
            ]);
        }

        if ($request->has('buy_now') && $request->buy_now == '1') {
            return redirect()->route('checkout.index');
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:increase,decrease',
        ]);

        $cartItem = CartItem::where('id', $id)->whereHas('cart', function ($q) {
            $q->where('user_id', auth()->id());
        })->firstOrFail();

        if ($request->action === 'increase') {
            $cartItem->increment('quantity');
        } elseif ($request->action === 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                $cartItem->delete();
            }
        }

        return back()->with('success', 'Kuantitas keranjang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Pastikan item yang dihapus milik user yang sedang login
        $cartItem = CartItem::where('id', $id)->whereHas('cart', function ($q) {
            $q->where('user_id', auth()->id());
        })->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
