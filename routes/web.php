<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Services\ProductService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home2');
});

Route::get('/home', function () {
    return view('home2');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'showAll'])->name('products');
    Route::get('/{id}', [ProductController::class, 'getProductDetail'])->name('product.show')->where('id', '[0-9]+');
    // Route::get('/test', [ProductController::class, 'test'])->name('test');
    // Route::prefix('/{id}')->group(function () {
    //     Route::get('/', [ProductController::class, 'showProductByCategoryId'])->name('products.category')->where('id', '[0-9]+');
    //     Route::get('/inStock', [ProductController::class, 'getProductInStock'])->where('id', '[0-9]+');
    //     Route::get('/newest', [ProductController::class, 'sortProductNewest']);
    // });
    // Route::get('/{id}/inStock', [ProductController::class, 'getProductInStock'])->where('id', '[0-9]+');
    // Route::get('/{id}', [ProductController::class, 'showProductByCategoryId'])->name('products.category')->where('id', '[0-9]+');
    // Route::get('/inStock', [ProductController::class, 'getProductInStock']);
    // Route::get('/newest', [ProductController::class, 'sortProductNewest']);
    // Price range routes
    // Route::prefix('/{minPrice}-{maxPrice}')->group(function () {
    //     Route::get('/', [ProductController::class, 'getProductInAmount'])->where(['minPrice' => '[0-9]+', 'maxPrice' => '[0-9]+']);
    //     Route::get('/inStock', [ProductController::class, 'getProductInStock']);
    //     Route::get('/newest', [ProductController::class, 'sortProductNewest']);
    //     Route::prefix('/{id}')->group(function () {
    //         Route::get('/', [ProductController::class, 'getProductInAmount'])->where(['minPrice' => '[0-9]+', 'maxPrice' => '[0-9]+', 'id' => '[0-9]+']);
    //         Route::get('/inStock', [ProductController::class, 'getProductInStock'])->where('id', '[0-9]+');
    //     });
    // Route::get('/{id}', [ProductController::class, 'getProductInAmount'])->where(['minPrice' => '[0-9]+', 'maxPrice' => '[0-9]+', 'id' => '[0-9]+']);
    // Route::get('/{id}/inStock', [ProductController::class, 'getProductInStock'])->where('id', '[0-9]+');
    // });
    // Route::get('/{minPrice}-{maxPrice}', [ProductController::class, 'getProductInAmount'])->where(['minPrice' => '[0-9]+', 'maxPrice' => '[0-9]+']);
    // Route::get('/{minPrice}-{maxPrice}/{id}', [ProductController::class, 'getProductInAmount'])->where(['minPrice' => '[0-9]+', 'maxPrice' => '[0-9]+', 'id' => '[0-9]+']);
    // Route::get('/instock', [ProductController::class, 'getProductInStock']);
});
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Cart routes
Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

require __DIR__ . '/auth.php';
