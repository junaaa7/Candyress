<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientBalanceException;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\OrderFulfillmentService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(
        protected WalletService $walletService
    ) {}

    public function index()
    {
        $cart = Cart::with('items.product')->where('user_id', auth()->id())->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $totalAmount = 0;
        foreach ($cart->items as $item) {
            $price = $item->product->discount_price ?? $item->product->price;
            $totalAmount += $price * $item->quantity;
        }

        $user = auth()->user()->fresh();
        $userBalance = $user->balance ?? 0;

        return view('store.checkout', compact('cart', 'totalAmount', 'userBalance'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $cart = Cart::with('items.product')->where('user_id', auth()->id())->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        foreach ($cart->items as $item) {
            $availableStock = $item->product->productStocks()->where('status', 'available')->count();
            if ($availableStock < $item->quantity) {
                return redirect()->route('cart.index')->with('error', "Maaf, stok untuk produk '{$item->product->name}' tidak mencukupi atau habis.");
            }
        }

        try {
            DB::beginTransaction();

            // Hitung Total
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                $price = $item->product->discount_price ?? $item->product->price;
                $totalAmount += $price * $item->quantity;
            }

            // === BALANCE PAYMENT ===
            if ($request->payment_method === 'SALDO') {
                $user = auth()->user();

                // Check sufficient balance
                if (! $this->walletService->hasSufficientBalance($user, $totalAmount)) {
                    DB::rollBack();

                    return redirect()->route('customer.topup.index')
                        ->with('error', 'Saldo tidak mencukupi. Butuh Rp '.number_format($totalAmount, 0, ',', '.').', saldo Anda Rp '.number_format($user->balance, 0, ',', '.').'. Silakan top-up terlebih dahulu.');
                }

                // 1. Buat Order (langsung completed karena bayar pakai saldo)
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => 'ORD-'.strtoupper(Str::random(8)),
                    'total_price' => $totalAmount,
                    'status' => 'processing',
                ]);

                // 2. Buat Order Items
                foreach ($cart->items as $item) {
                    $price = $item->product->discount_price ?? $item->product->price;
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $price,
                    ]);
                }

                // 3. Buat Data Pembayaran (langsung approved)
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => 'SALDO',
                    'amount' => $totalAmount,
                    'status' => 'approved',
                ]);

                // 4. Debit saldo user (atomic, with lockForUpdate inside)
                $this->walletService->debit(
                    $user,
                    $totalAmount,
                    'Pembelian produk #'.$order->order_number,
                    'order',
                    $order->id
                );

                // 5. Fulfillment Stock
                app(OrderFulfillmentService::class)->fulfill($order);

                // 6. Hapus isi keranjang
                $cart->items()->delete();

                DB::commit();

                return redirect()->route('checkout.success', $order->order_number);
            }

            // === STANDARD PAYMENT (QRIS / Transfer) ===
            // 1. Buat Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-'.strtoupper(Str::random(8)),
                'total_price' => $totalAmount,
                'status' => 'pending',
            ]);

            // 2. Buat Order Items
            foreach ($cart->items as $item) {
                $price = $item->product->discount_price ?? $item->product->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                ]);
            }

            // 3. Buat Data Pembayaran
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // 4. Hapus isi keranjang setelah checkout sukses
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('checkout.success', $order->order_number);

        } catch (InsufficientBalanceException $e) {
            DB::rollBack();

            return redirect()->route('customer.topup.index')
                ->with('error', $e->getMessage());
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
