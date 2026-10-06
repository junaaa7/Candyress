<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;

class StoreController extends Controller
{
    public function index()
    {
        // Ambil 3 ulasan terbaik dan terbaru untuk seksi testimoni
        $testimonials = Review::with(['user', 'product'])
            ->where('is_visible', true)
            ->where('rating', '>=', 4)
            ->latest()
            ->take(3)
            ->get();

        return view('welcome', compact('testimonials'));
    }

    public function show($slug)
    {
        // Cari produk berdasarkan slug
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->withCount([
                'productStocks as available_stock_count' => function ($query) {
                    $query->where('status', 'available');
                },
                'productStocks as sold_count' => function ($query) {
                    $query->where('status', 'sold');
                },
            ])
            ->firstOrFail();

        return view('store.show', compact('product'));
    }
}
