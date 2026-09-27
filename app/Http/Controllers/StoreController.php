<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        // Ambil produk yang statusnya aktif, terbaru, maksimal 8 produk untuk homepage
        $products = Product::where('is_active', true)->with('category')->latest()->take(8)->get();
        return view('welcome', compact('products'));
    }

    public function show($slug)
    {
        // Cari produk berdasarkan slug
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('store.show', compact('product'));
    }
}