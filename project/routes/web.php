<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductDiscountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;





Route::get('', [HomeController::class, 'home'])->name('home');
Route::get('/category', [HomeController::class, 'category'])->name('category');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/sort/{sort}', [HomeController::class, 'sort'])->name('sort');
Route::get('/load-more', [HomeController::class, 'loadMore'])->name('load-more');
Route::get('/order', [HomeController::class, 'order'])->name('order');

Route::middleware(
    ['auth', 'is_active']
)->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');
    Route::get('/checkout', [OrderController::class, 'checkOut'])->name('order.checkout')->middleware('order');
    Route::post('/order', [OrderController::class, 'confirm'])->name('order.confirm');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('', [HomeController::class, 'cart'])->name('index');
        Route::post('apply-discount', [CartController::class, 'applyDiscount'])->name('apply-discount');
        Route::post('add', [CartController::class, 'add'])->name('add');
        Route::delete('remove', [CartController::class, 'remove'])->name('remove');
        Route::put('update', [CartController::class, 'update'])->name('update');
    });
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
            Route::delete('delete/{id}', [DiscountController::class, 'destroy'])->name('delete');
        });

        Route::prefix('product')->name('product.')->group(function () {
            Route::get('', [ProductController::class, 'index'])->name('index');
            Route::post('add', [ProductController::class, 'store'])->name('add');
            Route::post('{id}/upload-images', [ProductController::class, 'storeImages'])->name('store-images');
            Route::put('update/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [ProductController::class, 'destroy'])->name('delete');
            Route::post('add-discount', [ProductDiscountController::class, 'store'])->name('discount-add');
            Route::delete('remove-discount/product/{productId}/discount/{discountId}', [ProductDiscountController::class, 'removeDiscount'])->name('discount-remove');
            Route::put('update-predefine/product/{productId}/discount/{discountId}', [ProductDiscountController::class, 'updateIsPredefined'])->name('update-predefine');
            Route::delete('/{productId}/pictures/delete', [ProductController::class, 'deleteImages'])->name('deleteImages');
            Route::get('/{productId}/discounted-price', [ProductDiscountController::class, 'getDiscountedPrice'])->name('getDiscountedPrice');
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
            Route::put('active/{id}', [AccountController::class, 'active'])->name('active');
            Route::put('update-role', [AccountController::class, 'updateRole'])->name('update-role');
        });
    });
});
