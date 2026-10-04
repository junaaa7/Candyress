<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // Form Input Stok Baru & List Stok
    public function index()
    {
        $products = Product::withCount(['productStocks as available_stock' => function ($query) {
            $query->where('status', 'available');
        }])->get();

        $stocks = ProductStock::with('product')->latest()->paginate(20);

        return view('admin.stocks.index', compact('products', 'stocks'));
    }

    // Proses Simpan Multi-Stok
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'credentials' => 'required|string',
        ]);

        // Simpan seluruh teks apa adanya sebagai 1 stok akun tunggal
        $block = trim($request->credentials);
        if (! empty($block)) {
            ProductStock::create([
                'product_id' => $request->product_id,
                'credentials' => $block,
                'status' => 'available',
            ]);

            // Otomatis tambah angka stock di tabel produk
            $product = Product::find($request->product_id);
            if ($product) {
                $product->increment('stock', 1);
            }
        }

        return redirect()->back()->with('success', '1 Akun berhasil ditambahkan ke stok!');
    }

    public function update(Request $request, ProductStock $stock)
    {
        $request->validate([
            'credentials' => 'required|string',
        ]);

        $stock->update([
            'credentials' => trim($request->credentials),
        ]);

        return redirect()->back()->with('success', 'Stok akun berhasil diperbarui!');
    }

    public function destroy(ProductStock $stock)
    {
        if ($stock->status === 'available') {
            $product = $stock->product;
            if ($product && $product->stock > 0) {
                $product->decrement('stock', 1);
            }
        }

        $stock->delete();

        return redirect()->back()->with('success', 'Stok akun berhasil dihapus!');
    }
}
