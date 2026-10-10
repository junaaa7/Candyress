<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StockController; // <-- Import Admin ReviewController
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\WebhookController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

// Route Publik
Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/produk/{slug}', [StoreController::class, 'show'])->name('product.show');
Route::view('/terms-and-conditions', 'terms')->name('terms.conditions');

// Route khusus user login (Customer / Global Auth)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Customer & Riwayat Pesanan
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');

    // Katalog Produk Customer (browsing + search + filter)
    Route::get('/katalog-produk', [CustomerController::class, 'products'])->name('customer.products.index');

    // Riwayat Pesanan Customer (full list with filter) — harus sebelum route {order_number}
    Route::get('/pesanan', [CustomerController::class, 'orders'])->name('customer.orders.index');
    Route::get('/pesanan/{order_number}', [CustomerController::class, 'showOrder'])->name('customer.order.show');

    // Upload Bukti Pembayaran
    Route::get('/pembayaran', [CustomerController::class, 'payments'])->name('customer.payments.index');
    Route::post('/pesanan/{order_number}/upload-pembayaran', [CustomerController::class, 'uploadPayment'])->name('customer.payment.upload');

    // Review / Ulasan Customer
    Route::get('/ulasan', [CustomerController::class, 'reviews'])->name('customer.reviews.index');
    Route::post('/ulasan', [CustomerController::class, 'storeReview'])->name('customer.reviews.store');

    // Update Profil Customer (enhanced with phone & avatar)
    Route::post('/profile/update-customer', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');

    // Halaman Profil Customer (dedicated view)
    Route::get('/profil', function () {
        return view('customer.profile');
    })->name('customer.profile');

    // Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Keranjang (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/checkout/voucher/apply', [CheckoutController::class, 'applyVoucher'])->name('checkout.voucher.apply');
    Route::post('/checkout/voucher/remove', [CheckoutController::class, 'removeVoucher'])->name('checkout.voucher.remove');

    // Saldo & Top-Up (Wallet)
    Route::get('/saldo', [TopupController::class, 'index'])->name('customer.topup.index');
    Route::post('/saldo/topup', [TopupController::class, 'store'])->name('customer.topup.store');
    Route::get('/saldo/topup/{referenceId}', [TopupController::class, 'show'])->name('customer.topup.show');
    Route::post('/saldo/topup/{referenceId}/upload-proof', [TopupController::class, 'uploadProof'])->name('customer.topup.upload-proof');
});

// Webhook Payment Gateway (QRIS callback — no auth, no CSRF)
Route::post('/webhook/payment', [WebhookController::class, 'handlePayment'])
    ->name('webhook.payment')
    ->withoutMiddleware([VerifyCsrfToken::class]);

// Webhook Midtrans (no auth, no CSRF)
Route::post('/webhook/midtrans', [MidtransWebhookController::class, 'handle'])
    ->name('webhook.midtrans')
    ->withoutMiddleware([VerifyCsrfToken::class]);

// Route khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Kategori Produk
    Route::resource('categories', CategoryController::class)->except(['show']);

    // CRUD Produk
    Route::resource('products', ProductController::class);

    // Kelola Stok Akun (Ganti dari premium-accounts lama)
    Route::resource('stocks', StockController::class)->only(['index', 'store', 'update', 'destroy']);

    // Kelola Pesanan (Admin Order Management)
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
    Route::post('orders/{order}/fulfill', [OrderController::class, 'fulfill'])->name('orders.fulfill');

    // Kelola Pembayaran (Admin Payment Management)
    Route::resource('payments', PaymentController::class)->only(['index', 'show', 'update']);

    // Kelola Customer (Admin Customer Management)
    Route::resource('customers', AdminCustomerController::class)->only(['index', 'show']);
    Route::patch('customers/{customer}/toggle-status', [AdminCustomerController::class, 'toggleStatus'])->name('customers.toggle-status');

    // Kelola Voucher / Promo
    Route::resource('vouchers', VoucherController::class);

    // Kelola Review / Ulasan
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}/toggle', [ReviewController::class, 'toggleVisibility'])->name('reviews.toggle');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Laporan Penjualan
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    // Manajemen Top Up
    Route::get('topups', [App\Http\Controllers\Admin\TopUpController::class, 'index'])->name('topups.index');
    Route::post('topups/{topUp}/approve', [App\Http\Controllers\Admin\TopUpController::class, 'approve'])->name('topups.approve');
    Route::post('topups/{topUp}/reject', [App\Http\Controllers\Admin\TopUpController::class, 'reject'])->name('topups.reject');

    // Pengaturan Toko
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
