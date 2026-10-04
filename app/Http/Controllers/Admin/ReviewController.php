<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    // 1. Melihat semua review
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->get();

        return view('admin.reviews.index', compact('reviews'));
    }

    // 2. Menyembunyikan / Menampilkan review
    public function toggleVisibility(Review $review)
    {
        $review->update([
            'is_visible' => ! $review->is_visible,
        ]);

        $status = $review->is_visible ? 'ditampilkan ke publik' : 'disembunyikan dari publik';

        return redirect()->back()->with('success', "Review berhasil $status!");
    }

    // 3. Menghapus review secara permanen
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->back()->with('success', 'Review berhasil dihapus!');
    }
}
