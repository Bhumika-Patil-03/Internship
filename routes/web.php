<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

// --- PUBLIC STOREFRONT ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'index'])->name('shop.index');
Route::get('/category/{id}', [HomeController::class, 'category'])->name('category.view');
Route::get('/product/{id}', [HomeController::class, 'product_details'])->name('product.details');

// --- AUTHENTICATED USERS ---
Route::middleware(['auth'])->group(function () {
    
    // User Personal Pages
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
    Route::post('/order/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('orders.cancel');

    // FIX: This is the route your button was looking for
    Route::post('/buy-product/{id}', [OrderController::class, 'placeOrder'])->name('product.buy');

    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Admin Dashboard & Tabs
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/products', [DashboardController::class, 'index'])->name('products.index');
    Route::get('/admin/categories', [DashboardController::class, 'index'])->name('categories.index');
    Route::get('/admin/users', [DashboardController::class, 'index'])->name('users.index');
    Route::get('/admin/orders', [DashboardController::class, 'index'])->name('orders.index');
    
    // Admin Actions
    Route::post('/admin/order/{id}/{status}', [OrderController::class, 'updateStatus'])->name('order.update');
    Route::resource('products', ProductController::class)->except(['index']);
    Route::resource('categories', CategoryController::class)->except(['index']);
});

// Safety Redirects
Route::get('/products', function() { return redirect()->route('products.index'); });