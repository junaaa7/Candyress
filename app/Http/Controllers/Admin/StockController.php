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
            'credentials' => 'required|string', // Format: email,password,pin,info
        ]);

        // Memecah inputan berdasarkan baris baru (Enter)
        $lines = explode("\n", str_replace("\r", '', $request->credentials));
        $count = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if (! empty($line)) {
                $parts = explode(',', $line);
                ProductStock::create([
                    'product_id' => $request->product_id,
                    'email' => isset($parts[0]) ? trim($parts[0]) : null,
                    'password' => isset($parts[1]) ? trim($parts[1]) : null,
                    'token_or_pin' => isset($parts[2]) ? trim($parts[2]) : null,
                    'additional_info' => isset($parts[3]) ? trim($parts[3]) : null,
                    'status' => 'available',
                ]);
                $count++;
            }
        }

        // Otomatis tambah angka stock di tabel produk
        $product = Product::find($request->product_id);
        $product->increment('stock', $count);

        return redirect()->back()->with('success', "$count Akun berhasil ditambahkan ke stok!");
    }
}
