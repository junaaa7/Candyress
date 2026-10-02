<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderFulfillmentService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. Melihat semua pesanan
    public function index()
    {
        // Mengambil pesanan terbaru beserta data user pelanggannya
        $orders = Order::with('user')->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    // 2. Melihat detail pesanan (Pelanggan & Produk)
    public function show(Order $order)
    {
        // Memuat relasi pelanggan dan produk yang ada di dalam pesanan
        $order->load(['user', 'products', 'items.productStock', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    // 3. Mengubah status pesanan
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        if ($validated['status'] === 'completed') {
            app(OrderFulfillmentService::class)->fulfill($order);
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // 4. Force fulfill (Manual assign stock)
    public function fulfill(Order $order)
    {
        try {
            app(OrderFulfillmentService::class)->fulfill($order);

            return redirect()->back()->with('success', 'Stok berhasil dialokasikan ke pesanan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengalokasikan stok: '.$e->getMessage());
        }
    }
}
