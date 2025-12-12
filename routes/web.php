<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Group Middleware Auth (Hanya bisa diakses jika login)
Route::middleware('auth')->group(function () {
    
    // --- 1. LOGIKA UTAMA (HOME) ---
    Route::get('/', function () {
        // Jika Admin, ke Dashboard Admin
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Nanti dibuat
        }
        // Jika Member/Seller, ke Halaman Belanja
        return app(FrontendController::class)->index(request());
    })->name('home');

    // --- 2. FITUR PEMBELI (BUYER) ---
    
    // Produk & Checkout
    Route::get('/product/{slug}', [FrontendController::class, 'details'])->name('product.detail');
    Route::get('/checkout/{slug}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Sistem Pembayaran & Wallet
    Route::get('/payment-gate', [PaymentController::class, 'index'])->name('payment.gate');
    Route::post('/payment-check', [PaymentController::class, 'check'])->name('payment.check');
    Route::post('/payment-pay', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payment/{transaction}', [CheckoutController::class, 'payment'])->name('payment.show'); // Halaman Menunggu Pembayaran
    
    // Wallet & History
    Route::get('/wallet/topup', [WalletController::class, 'showTopup'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'processTopup'])->name('wallet.topup.process');
    Route::get('/history', [HistoryController::class, 'index'])->name('history');

    // --- 3. FITUR PENJUAL (SELLER) ---
    
    // Pendaftaran Toko (Bisa diakses member yang belum punya toko)
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');
    Route::post('/store/register', [StoreController::class, 'store'])->name('store.store');

    // Dashboard Toko (Hanya bisa diakses jika sudah daftar toko)
    Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');
        
        // Nanti tambah route produk di sini...
    });

    // --- 4. PROFILE USER (BAWAAN BREEZE) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');
        
        // 1. Manajemen Profil Toko
        Route::get('/profile', [StoreController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [StoreController::class, 'updateProfile'])->name('profile.update');

        // 2. Manajemen Produk (CRUD Lengkap)
        Route::resource('products', ProductController::class);
    });

// --- 5. ROUTE ADMIN (PLACEHOLDER) ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return "Halo Admin! Ini Dashboard Kamu. (Fitur Admin Belum Dibuat)";
    })->name('admin.dashboard');
});

// Load Rute Auth Bawaan (Login, Register, Logout)
require __DIR__.'/auth.php';