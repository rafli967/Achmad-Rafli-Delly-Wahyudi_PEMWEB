<?php
use App\Http\Controllers\AdminController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HistoryController;

use App\Http\Controllers\Seller\StoreController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\BalanceController;
use App\Http\Controllers\Seller\WithdrawalController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    Route::get('/', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return app(FrontendController::class)->index(request());
    })->name('home');

    // --- Route Frontend User (Pembeli) ---
    Route::get('/product/{slug}', [FrontendController::class, 'details'])->name('product.detail');
    Route::get('/checkout/{slug}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
    
    Route::get('/payment-gate', [PaymentController::class, 'index'])->name('payment.gate');
    Route::post('/payment-check', [PaymentController::class, 'check'])->name('payment.check');
    Route::post('/payment-pay', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/payment/{transaction}', [CheckoutController::class, 'payment'])->name('payment.show');

    Route::get('/wallet/topup', [WalletController::class, 'showTopup'])->name('wallet.topup');
    Route::post('/wallet/topup', [WalletController::class, 'processTopup'])->name('wallet.topup.process');
    Route::get('/history', [HistoryController::class, 'index'])->name('history');


    // --- Route Seller (Penjual) ---
    
    Route::get('/store/register', [StoreController::class, 'create'])->name('store.register');
    Route::post('/store/register', [StoreController::class, 'store'])->name('store.store');

    Route::get('/store/pending', [StoreController::class, 'pending'])->name('store.pending');

    Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/profile', [StoreController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [StoreController::class, 'updateProfile'])->name('profile.update');

        Route::resource('products', ProductController::class);

        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');

        Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');

        Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- Route Admin ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/verification', [AdminController::class, 'verification'])->name('verification');
    Route::post('/verification/{id}/approve', [AdminController::class, 'approveStore'])->name('verification.approve');
    Route::post('/verification/{id}/reject', [AdminController::class, 'rejectStore'])->name('verification.reject');

    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('withdrawals.index');
    Route::put('/withdrawals/{id}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
    Route::put('/withdrawals/{id}/reject', [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
});

require __DIR__.'/auth.php';