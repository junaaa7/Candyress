<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientBalanceException;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Voucher;
use App\Services\OrderFulfillmentService;
use App\Services\PaymentGatewayService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        $subtotal = 0;
        foreach ($cart->items as $item) {
            $price = $item->product->discount_price ?? $item->product->price;
            $subtotal += $price * $item->quantity;
        }

        $discount = 0;
        $activeVoucher = null;
        if (session()->has('voucher_code')) {
            $voucher = Voucher::where('code', session('voucher_code'))->where('is_active', true)->first();
            if ($voucher && ! $voucher->isExpired()) {
                $activeVoucher = $voucher;
                if ($voucher->discount_type === 'nominal') {
                    $discount = $voucher->discount_value;
                } else {
                    $discount = $subtotal * ($voucher->discount_value / 100);
                }
            } else {
                session()->forget(['voucher_code', 'voucher_discount']);
            }
        }

        $totalAmount = max(0, $subtotal - $discount);

        $user = auth()->user()->fresh();
        $userBalance = $user->balance ?? 0;

        return view('store.checkout', compact('cart', 'subtotal', 'discount', 'totalAmount', 'userBalance', 'activeVoucher'));
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

            // Terapkan Voucher Jika Ada
            $discount = 0;
            if (session()->has('voucher_code')) {
                $voucher = Voucher::where('code', session('voucher_code'))->where('is_active', true)->first();
                if ($voucher && ! $voucher->isExpired()) {
                    if ($voucher->discount_type === 'nominal') {
                        $discount = $voucher->discount_value;
                    } else {
                        $discount = $totalAmount * ($voucher->discount_value / 100);
                    }
                    $totalAmount = max(0, $totalAmount - $discount);
                } else {
                    session()->forget(['voucher_code', 'voucher_discount']);
                }
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
                    'payment_method' => 'SALDO',
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

                // 6. Hapus isi keranjang & voucher session
                $cart->items()->delete();
                session()->forget(['voucher_code', 'voucher_discount']);

                DB::commit();

                return redirect()->route('checkout.success', $order->order_number);
            }

            // === STANDARD PAYMENT (Midtrans / Transfer) ===
            // 1. Buat Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-'.strtoupper(Str::random(8)),
                'total_price' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
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

            // 3. Generate Midtrans Snap Token
            $snapToken = null;
            if (in_array(strtoupper($request->payment_method), ['MIDTRANS', 'QRIS'])) {
                try {
                    $snapToken = app(PaymentGatewayService::class)->generateSnapToken($order);
                    if ($snapToken) {
                        $order->snap_token = $snapToken;
                        $order->save();
                    }
                } catch (\Exception $e) {
                    Log::error('Checkout Midtrans Error: '.$e->getMessage());
                    // Biarkan kosong, akan digenerate ulang di success page
                }
            }

            // 4. Buat Data Pembayaran
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $totalAmount,
                'status' => 'pending',
                'snap_token' => $snapToken,
            ]);

            // 5. Hapus isi keranjang & voucher session setelah checkout sukses
            $cart->items()->delete();
            session()->forget(['voucher_code', 'voucher_discount']);

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

    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string',
        ]);

        $voucher = Voucher::where('code', $request->voucher_code)
            ->where('is_active', true)
            ->first();

        if (! $voucher) {
            return back()->with('error', 'Voucher tidak ditemukan atau sudah tidak aktif.');
        }

        if ($voucher->isExpired()) {
            return back()->with('error', 'Masa berlaku voucher sudah habis.');
        }

        session(['voucher_code' => $voucher->code]);

        return back()->with('success', 'Voucher berhasil diterapkan!');
    }

    public function removeVoucher()
    {
        session()->forget(['voucher_code', 'voucher_discount']);

        return back()->with('success', 'Voucher berhasil dihapus.');
    }

    public function success($order_number)
    {
        $order = Order::with(['items.product', 'payment'])->where('order_number', $order_number)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Generate Snap Token jika belum ada
        if (
            (empty($order->snap_token) || ! str_contains($order->snap_token, '-'))
            && in_array(strtoupper($order->payment_method ?? $order->payment?->payment_method), ['MIDTRANS', 'QRIS'])
        ) {
            try {
                $snapToken = app(PaymentGatewayService::class)->generateSnapToken($order);
                if ($snapToken) {
                    $order->snap_token = $snapToken;
                    $order->save();
                } else {
                    session()->flash('midtrans_error', 'Gagal mendapatkan token dari Midtrans.');
                }
            } catch (\Exception $e) {
                Log::error('Midtrans Token Error: '.$e->getMessage());
                session()->flash('midtrans_error', $e->getMessage());
            }
        }

        return view('store.success', [
            'order' => $order,
            'snapToken' => $order->snap_token,
        ]);
    }
}
