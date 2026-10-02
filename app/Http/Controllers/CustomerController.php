<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Services\OrderFulfillmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    // Dashboard — show stats and recent orders
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $orders = Order::where('user_id', auth()->id())->latest()->get();
        $totalOrders = $orders->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $processingOrders = $orders->where('status', 'processing')->count();
        $recentOrders = Order::with(['items.product', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact(
            'totalOrders', 'pendingOrders', 'completedOrders', 'processingOrders', 'recentOrders'
        ));
    }

    // Browse product catalog with search & category filter
    public function products(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with('category')
            ->withCount(['productStocks as available_stock_count' => function ($query) {
                $query->where('status', 'available');
            }]);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('customer.products', compact('products', 'categories'));
    }

    // Show all orders with filtering
    public function orders(Request $request)
    {
        $query = Order::with(['items.product', 'payment'])
            ->where('user_id', auth()->id());

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    // Show single order detail
    public function showOrder($order_number)
    {
        $order = Order::with(['items.product.category', 'items.productStock', 'payment'])
            ->where('user_id', auth()->id())
            ->where('order_number', $order_number)
            ->firstOrFail();

        // Auto fallback: if completed but items missing stock, try fulfilling again
        if ($order->status === 'completed') {
            $hasUnfulfilled = $order->items->whereNull('product_stock_id')->isNotEmpty();
            if ($hasUnfulfilled) {
                try {
                    app(OrderFulfillmentService::class)->fulfill($order);
                    // Reload order to fetch new productStock relations
                    $order->load(['items.productStock']);
                } catch (\Exception $e) {
                    // Silently fail if still out of stock, view will handle it
                }
            }
        }

        return view('customer.order-detail', compact('order'));
    }

    // Show payments list
    public function payments()
    {
        $orders = Order::with('payment')
            ->where('user_id', auth()->id())
            ->whereHas('payment')
            ->latest()
            ->paginate(10);

        return view('customer.payments', compact('orders'));
    }

    // Upload payment proof
    public function uploadPayment(Request $request, $order_number)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $order = Order::where('user_id', auth()->id())
            ->where('order_number', $order_number)
            ->firstOrFail();

        // Pastikan pesanan belum selesai atau dibatalkan
        if (in_array($order->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Status pesanan tidak mengizinkan pembayaran.');
        }

        $payment = $order->payment;

        // Delete old proof if exists
        if ($payment && $payment->payment_proof) {
            Storage::disk('public')->delete($payment->payment_proof);
        }

        // Store new proof
        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        // Gunakan updateOrCreate agar data payment dibuat jika belum ada
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => $order->payment_method ?? 'Transfer Bank',
                'payment_proof' => $path,
                'status' => 'pending', // Reset to pending for re-review
                'amount' => $order->total_price,
            ]
        );

        // Ubah status order menjadi processing setelah bukti dikirim
        $order->update(['status' => 'processing']);

        return back()->with('success', 'Bukti pembayaran berhasil diupload! Admin akan memverifikasi segera.');
    }

    // Show customer reviews list
    public function reviews()
    {
        $reviews = Review::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        // Get products that customer has purchased and completed but not reviewed yet
        $reviewableProducts = Order::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->with('items.product')
            ->get()
            ->pluck('items')
            ->flatten()
            ->pluck('product')
            ->unique('id')
            ->filter(function ($product) {
                return ! Review::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->exists();
            });

        return view('customer.reviews', compact('reviews', 'reviewableProducts'));
    }

    // Store a new review
    public function storeReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        // Verify the user has purchased this product and order is completed
        $hasPurchased = Order::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->whereHas('items', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            })
            ->exists();

        if (! $hasPurchased) {
            return back()->with('error', 'Anda hanya bisa mereview produk yang sudah dibeli dan selesai.');
        }

        // Check if already reviewed
        $alreadyReviewed = Review::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Anda sudah pernah mereview produk ini.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Review berhasil dikirim! Terima kasih atas ulasan Anda.');
    }

    // Update customer profile (enhanced)
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
