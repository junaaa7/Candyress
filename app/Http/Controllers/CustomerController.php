<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Jika yang mengakses adalah admin, arahkan ke dasbor admin
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Ambil semua pesanan milik user yang sedang login
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        
        // Hitung statistik pesanan
        $totalOrders = $orders->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $completedOrders = $orders->where('status', 'completed')->count();

        // PERUBAHAN DI SINI: tambahkan "customer." sebelum "dashboard"
        return view('customer.dashboard', compact('orders', 'totalOrders', 'pendingOrders', 'completedOrders'));
    }

    public function showOrder($order_number)
    {
        $order = Order::with(['items.product', 'payment'])
            ->where('user_id', auth()->id())
            ->where('order_number', $order_number)
            ->firstOrFail();

        return view('customer.order-detail', compact('order'));
    }
}