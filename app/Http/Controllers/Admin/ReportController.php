<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Atur Filter Periode (Default: Bulan Ini)
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        // 2. Hitung Total Penjualan & Pendapatan (Hanya dari pesanan berstatus 'completed')
        $summary = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('COUNT(id) as total_orders, SUM(total_price) as total_revenue')
            ->first();

        // 3. Ambil Produk Terlaris berdasarkan kuantitas yang terjual
        $topProducts = DB::table('order_items') // <-- Ubah di sini
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->selectRaw('products.name, SUM(order_items.quantity) as total_sold, SUM(order_items.price * order_items.quantity) as total_revenue') // <-- Ubah di sini
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        // 4. Rekap Pesanan Harian berdasarkan periode yang dipilih
        $dailySales = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(id) as total_orders, SUM(total_price) as daily_revenue')
            ->groupBy('date')
            ->orderByDesc('date')
            ->get();

        return view('admin.reports.index', compact('startDate', 'endDate', 'summary', 'topProducts', 'dailySales'));
    }
}
