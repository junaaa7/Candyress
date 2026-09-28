<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\PremiumAccount;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Pendapatan (dari pesanan yang sudah selesai/completed)
        $totalPendapatan = Order::where('status', 'completed')->sum('total_price');

        // 2. Total Pesanan (keseluruhan)
        $totalPesanan = Order::count();

        // 3. Pesanan Pending
        $pesananPending = Order::where('status', 'pending')->count();

        // 4. Pesanan Selesai
        $pesananSelesai = Order::where('status', 'completed')->count();

        // 5. Total Customer (menghitung user dengan role 'customer')
        $totalCustomer = User::where('role', 'customer')->count();

        // 6. Produk Terlaris (mengambil 5 produk dengan jumlah pesanan terbanyak)
        $produkTerlaris = Product::withCount(['orders' => function ($query) {
            // Gunakan table.column untuk menghindari ambigu di relasi many-to-many
            $query->where('orders.status', 'completed'); 
        }])
        ->orderBy('orders_count', 'desc')
        ->take(5)
        ->get();

        // 7. Akun Premium Tersedia (stok yang belum terjual)
        $akunTersedia = PremiumAccount::where('status', 'tersedia')->count();

        return view('admin.dashboard', compact(
            'totalPendapatan',
            'totalPesanan',
            'pesananPending',
            'pesananSelesai',
            'totalCustomer',
            'produkTerlaris',
            'akunTersedia'
        ));
    }
}