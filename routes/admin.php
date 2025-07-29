<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\AdminMiddleware;

// admin routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'showAll'])->name('view');
        Route::get('/new', [ProductController::class, 'showNewProduct'])->name('newProduct');
        Route::post('/new', [ProductController::class, 'newProduct'])->name('store');
        Route::prefix('/{id}')->group(function () {
            Route::get('/', [ProductController::class, 'getProductWithVariant'])->name('variants');
            Route::get('/edit', [ProductController::class, 'showUpdateProduct'])->name('updateProduct');
            Route::post('/edit', [ProductController::class, 'updateProduct'])->name('update');
        });
    });
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', function () {
            return view('Admin.adminOrders');
        })->name('view');
    });
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', function () {
            return view('Admin.adminUsers');
        })->name('view');
    });
});
