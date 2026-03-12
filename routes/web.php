<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController; // Make sure this line is added

// 1. Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::redirect('/home', '/dashboard');

// 2. Authenticated Routes (Only for logged-in users)
Route::middleware(['auth'])->group(function () {

    // Handled by DashboardController now to show User/Category tables
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Category and Product Management routes
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    // Route for the Subcategory dependent dropdown logic
    Route::get('/get-subcategories/{parentId}', [ProductController::class, 'getSubcategories']);

});