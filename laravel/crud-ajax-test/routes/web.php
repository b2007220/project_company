<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index']);

Route::post('products/store', [ProductController::class, 'store']);

Route::get('products/edit/{id}', [ProductController::class, 'edit']);

Route::get('products/delete/{id}', [ProductController::class, 'destroy']);
