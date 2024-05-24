<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('', [HomeController::class, 'home'])->name('home');
Route::get('/category', [HomeController::class, 'category'])->name('category');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('', [HomeController::class, 'index'])->name('home');

        Route::prefix('category')->name('category.')->group(function () {
            Route::get('', [CategoryController::class, 'index'])->name('index');
            Route::post('add', [CategoryController::class, 'store'])->name('add');
            Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('delete/{category}', [CategoryController::class, 'destroy'])->name('delete');
        });

        Route::prefix('discount')->name('discount.')->group(function () {
            Route::get('', [DiscountController::class, 'index'])->name('index');
            Route::post('add', [DiscountController::class, 'store'])->name('add');
            Route::post('update/{id}', [DiscountController::class, 'update'])->name('update');
            Route::delete('delete/{discount}', [DiscountController::class, 'destroy'])->name('delete');
        });

        Route::prefix('product')->name('product.')->group(function () {
            Route::get('', [ProductController::class, 'index'])->name('index');
            Route::post('add', [ProductController::class, 'store'])->name('add');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('delete/{product}', [ProductController::class, 'destroy'])->name('delete');
        });

        Route::prefix('account')->name('account.')->group(function () {
            Route::get('', [ProfileController::class, 'index'])->name('index');
            Route::post('add', [ProfileController::class, 'store'])->name('add');
            Route::post('update/{id}', [ProfileController::class, 'update'])->name('update');
            Route::delete('delete/{user}', [ProfileController::class, 'destroy'])->name('delete');
        });

        Route::prefix('order')->name('order.')->group(function () {
            Route::get('', [OrderController::class, 'index'])->name('index');
            Route::post('add', [OrderController::class, 'store'])->name('add');
            Route::post('update/{id}', [OrderController::class, 'update'])->name('update');
            Route::delete('delete/{order}', [OrderController::class, 'destroy'])->name('delete');
        });
    });
});
