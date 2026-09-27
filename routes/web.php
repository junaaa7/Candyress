<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController; // <-- Import Admin OrderController
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;

// Route Publik
Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/produk/{slug}', [StoreController::class, 'show'])->name('product.show');

// Route khusus user login (Customer / Global Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Customer & Riwayat Pesanan
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
    Route::get('/pesanan/{order_number}', [CustomerController::class, 'showOrder'])->name('customer.order.show');

    // Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Keranjang (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Route khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Produk
    Route::resource('products', ProductController::class);
    
    // Kelola Pesanan (Admin Order Management)
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
});

require __DIR__.'/auth.php';