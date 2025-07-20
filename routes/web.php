<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Public\StoreController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\SalesController;

Route::get('/', fn () => view('welcome'));
Route::get('/pedido/{order}/pagar', [OrderController::class, 'pay'])->name('orders.pay');

Route::prefix('loja')->name('public.')->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('products.index');
    Route::get('/produto/{product}', [StoreController::class, 'show'])->name('product.show');
    Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
});

Route::middleware('guest.to.register')->prefix('carrinho')->name('public.')->group(function () {
    Route::post('/{product}', [CartController::class, 'store'])->name('store.cart');
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/pedido/finalizar', [OrderController::class, 'store'])->name('orders.store');

    Route::prefix('meus-pedidos')->name('orders.')->group(function () {
        Route::get('/', [UserOrderController::class, 'index'])->name('index');
        Route::post('/{order}/cancelar', [UserOrderController::class, 'cancel'])->name('cancel');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/vendas', [SalesController::class, 'index'])->name('sales.index');

    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/{user}/promote', [UserController::class, 'promote'])->name('users.promote');

    Route::resource('products', ProductController::class);
    Route::delete('products/{product}/images/{image}', [ProductImageController::class, 'destroy'])
        ->name('products.images.destroy');

    Route::resource('coupons', CouponController::class)->only(['index', 'create', 'store', 'destroy']);
});

require __DIR__.'/auth.php';
