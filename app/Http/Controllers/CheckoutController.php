<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', auth()->id())->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        return view('store.checkout', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string'
        ]);

        $cart = Cart::with('items.product')->where('user_id', auth()->id())->first();
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        try {
            DB::beginTransaction();

            // Hitung Total
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                $price = $item->product->discount_price ?? $item->product->price;
                $totalAmount += $price * $item->quantity;
            }

            // 1. Buat Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'total_price' => $totalAmount,
                'status' => 'pending'
            ]);

            // 2. Buat Order Items
            foreach ($cart->items as $item) {
                $price = $item->product->discount_price ?? $item->product->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price
                ]);
            }

            // 3. Buat Data Pembayaran
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $totalAmount,
                'status' => 'pending'
            ]);

            // 4. Hapus isi keranjang setelah checkout sukses
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem saat memproses pesanan Anda.');
        }
    }

    public function success($order_number)
    {
        $order = Order::with(['items.product', 'payment'])->where('order_number', $order_number)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        return view('store.success', compact('order'));
    }
}