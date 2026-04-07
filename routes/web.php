<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminOrderController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// ===== PRODUCT (SEMUA BISA AKSES) =====
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// ===== AUTH =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('/admin/dashboard', [ProductController::class, 'adminDashboard'])->name('admin.dashboard');


/*
|--------------------------------------------------------------------------
| USER (PEMBELI)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ===== CART =====
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

    // ===== CHECKOUT =====
    // tampilkan halaman checkout (HARUS GET)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

    // proses checkout → simpan ke orders
    Route::post('/checkout/process', [CheckoutController::class, 'process'])
        ->name('checkout.process');

    // ===== PESANAN USER =====
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/riwayat-pesanan', [App\Http\Controllers\OrderController::class, 'history'])
        ->name('orders.history');// ===== PROFILE =====

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
});


/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', function () {
        $products = \App\Models\Product::all();
        return view('admin.dashboard', compact('products'));
    })->name('admin.dashboard');

    // CRUD PRODUCT
    Route::resource('products', ProductController::class)
        ->except(['index', 'show']);

    // ===== PESANAN MASUK (ADMIN) =====
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders');

    Route::put('/admin/orders/{id}', [AdminOrderController::class, 'update'])
        ->name('admin.orders.update');
});
