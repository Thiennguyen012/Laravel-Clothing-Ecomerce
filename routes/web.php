<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'showAll'])->name('products');
    Route::get('/test', [ProductController::class, 'test'])->name('test');
    Route::get('/{id}', [ProductController::class, 'showProductByCategoryId'])->name('products.category')->where('id', '[0-9]+');
    // amout product Route
    Route::get('/{minPrice}-{maxPrice}', [ProductController::class, 'getProductInAmount']);
    Route::get('/{id}/{minPrice}-{maxPrice}', [ProductController::class, 'getProductInAmount']);
});
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
require __DIR__ . '/auth.php';
