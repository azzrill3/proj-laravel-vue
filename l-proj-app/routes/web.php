<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('cart', function () {
    return Inertia::render('Cart');
})->middleware(['auth', 'verified'])->name('cart');

Route::get('/item-data', [ItemController::class, 'index']);
Route::get('/cart-data', [CartController::class, 'get_cart']);
Route::get('/cart-amount/{ID}', [CartController::class, 'get_cart_amount']);
Route::post('/cart-add', [CartController::class, 'add_to_cart']);
Route::post('/cart-remove', [CartController::class, 'remove_from_cart']);
Route::post('/cart-delete', [CartController::class, 'delete_from_cart']);
Route::get('/order-data', [OrderController::class, 'get_orders']);
Route::post('/order-place', [OrderController::class, 'place_order']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
