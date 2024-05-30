<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductDiscountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('', [HomeController::class, 'home'])->name('home');
Route::get('/category', [HomeController::class, 'category'])->name('category');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/sort/{sort}', [HomeController::class, 'sort'])->name('sort');

Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::get('/order', [HomeController::class, 'order'])->name('order');

Route::middleware(
    ['auth', 'is_active']
)->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('', [OrderController::class, 'index'])->name('home');

        Route::prefix('category')->name('category.')->group(function () {
            Route::get('', [CategoryController::class, 'index'])->name('index');
            Route::post('add', [CategoryController::class, 'store'])->name('add');
            Route::put('update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
        });

        Route::prefix('discount')->name('discount.')->group(function () {
            Route::get('', [DiscountController::class, 'index'])->name('index');
            Route::post('add', [DiscountController::class, 'store'])->name('add');
            Route::put('update/{id}', [DiscountController::class, 'update'])->name('update');
            Route::delete('delete/{discount}', [DiscountController::class, 'destroy'])->name('delete');
        });

        Route::prefix('product')->name('product.')->group(function () {
            Route::get('', [ProductController::class, 'index'])->name('index');
            Route::post('add', [ProductController::class, 'store'])->name('add');
            Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('delete/{product}', [ProductController::class, 'destroy'])->name('delete');
            Route::post('add-discount', [ProductDiscountController::class, 'store'])->name('discount-add');
            Route::delete('remove-discount/product/{productId}/discount/{discountId}', [ProductDiscountController::class, 'removeDiscount'])->name('discount-remove');
            Route::put('update-predefine/product/{productId}/discount/{discountId}', [ProductDiscountController::class, 'updateIsPredefined'])->name('update-predefine');
            Route::delete('product/{productId}/pictures/delete', [ProductController::class, 'deleteImages'])->name('deleteImages');
        });
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('', [OrderController::class, 'index'])->name('index');
            Route::post('add', [OrderController::class, 'store'])->name('add');
            Route::post('update', [OrderController::class, 'update'])->name('update');
            Route::post('update-type', [OrderController::class, 'updateType'])->name('update-type');
            Route::delete('delete/{order}', [OrderController::class, 'destroy'])->name('delete');
        });

        Route::prefix('account')->name('account.')->group(function () {
            Route::get('', [AccountController::class, 'index'])->name('index');
            Route::post('add', [AccountController::class, 'store'])->name('add');
            // Route::post('update/{id}', [AccountController::class, 'update'])->name('update');
            // Route::delete('delete/{user}', [AccountController::class, 'destroy'])->name('delete');
            Route::put('active/{user}', [AccountController::class, 'active'])->name('active');
            Route::put('update-role', [AccountController::class, 'updateRole'])->name('update-role');
        });
    });
});
