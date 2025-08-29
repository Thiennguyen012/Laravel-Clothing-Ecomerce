<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RatingController;
use App\Http\Middleware\AdminMiddleware;
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

Route::get('/search', [ProductController::class, 'showAll'])->name('products.search');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'showAll'])->name('products');
    Route::get('/{id}', [ProductController::class, 'getProductDetail'])->name('product.show')->where('id', '[0-9]+');
});

// Rating routes - ensure named routes exist for different usages
Route::prefix('rating')->name('rating.')->group(function () {
    // POST /rating/new -> named route rating.new
    Route::post('/new', [RatingController::class, 'newRating'])->name('new');

    // POST /rating -> named route rating.store (used by forms expecting rating.store)
    Route::post('/', [RatingController::class, 'newRating'])->name('store');
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

// checkout routes
Route::get('/checkout', [OrderController::class, 'getOrderList'])->name('checkout.list');
Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('checkout');
require __DIR__ . '/auth.php';

require __DIR__ . '/admin.php';
