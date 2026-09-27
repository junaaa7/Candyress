<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'payment')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'payment', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:pending,verified,failed',
            'account_credentials' => 'nullable|string'
        ]);

        // Update status order dan detail akun
        $order->update([
            'status' => $request->status,
            'account_credentials' => $request->account_credentials
        ]);

        // Update status pembayaran
        $order->payment->update([
            'status' => $request->payment_status
        ]);

        return back()->with('success', 'Pesanan berhasil diperbarui!');
    }
}