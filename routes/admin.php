<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VariantController;
use App\Http\Middleware\AdminMiddleware;

// login logout cho admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


    // Các route cần bảo vệ bằng guard admin
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'showAll'])->name('view');
            Route::get('/new', [ProductController::class, 'showNewProduct'])->name('newProduct');
            Route::post('/new', [ProductController::class, 'newProduct'])->name('store');
            Route::prefix('/{id}')->group(function () {
                Route::get('/', [ProductController::class, 'getProductWithVariant'])->name('variants');
                Route::delete('/', [ProductController::class, 'deleteProduct'])->name('delete');
                Route::get('/edit', [ProductController::class, 'showUpdateProduct'])->name('updateProduct');
                Route::post('/edit', [ProductController::class, 'updateProduct'])->name('update');
            });
        });
        Route::prefix('variant')->name('variants.')->group(function () {
            Route::get('/new', [VariantController::class, 'showNewVariant'])->name('newVariant');
            Route::post('/new', [VariantController::class, 'newVariant'])->name('store');
            Route::get('/{id}', [VariantController::class, 'showUpdateVariant'])->name('updateVariant');
            Route::post('/{id}', [VariantController::class, 'updateVariant'])->name('update');
            Route::delete('/{id}', [VariantController::class, 'deleteVariant'])->name('delete');
        });
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'showAll'])->name('view');
            Route::post('/', [OrderController::class, 'updateOrderStatus'])->name('updateStatus');
            Route::get('/{id}', [OrderController::class, 'getOrderDetail'])->name('detail');
        });
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'showAll'])->name('view');
        });
    });
});
