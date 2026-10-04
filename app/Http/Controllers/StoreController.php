<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;

class StoreController extends Controller
{
    public function index()
    {
        // Ambil produk yang statusnya aktif, terbaru, maksimal 8 produk untuk homepage
        $products = Product::where('is_active', true)
            ->with('category')
            ->withCount(['productStocks as available_stock_count' => function ($query) {
                $query->where('status', 'available');
            }])
            ->latest()
            ->take(8)
            ->get();

        // Ambil 6 ulasan terbaik dan terbaru untuk seksi testimoni
        $reviews = Review::with(['user', 'product'])
            ->where('is_visible', true)
            ->where('rating', '>=', 4)
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact('products', 'reviews'));
    }

    public function show($slug)
    {
        // Cari produk berdasarkan slug
        $product = Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return view('store.show', compact('product'));
    }
}
