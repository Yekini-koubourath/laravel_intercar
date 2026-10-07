<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


// =============================================================
// PAGES ACCESSIBLES AUX VISITEURS NON CONNECTES
// =============================================================

Route::middleware('guest')->group(function () {

    // Adresse racine
    Route::get('/', fn () => redirect()->route('login'));

    // Connexion
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.attempt');

    // =========================================================
    // MOT DE PASSE OUBLIE
    // =========================================================

    Route::get('/forgot-password', [
        PasswordResetController::class,
        'showForgotForm'
    ])->name('password.request');

    Route::post('/forgot-password', [
        PasswordResetController::class,
        'sendResetLink'
    ])->name('password.email');

    Route::get('/reset-password/{token}', [
        PasswordResetController::class,
        'showResetForm'
    ])->name('password.reset');

    Route::post('/reset-password', [
        PasswordResetController::class,
        'reset'
    ])->name('password.update');
});


// =============================================================
// PAGES RESERVEES AUX UTILISATEURS CONNECTES
// =============================================================

Route::middleware('auth')->group(function () {

    // =========================================================
    // DASHBOARD
    // =========================================================

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // =========================================================
    // PRODUITS
    // =========================================================

    Route::get('/products', [
        ProductController::class,
        'index'
    ])->name('products.index');

    Route::post('/products', [
        ProductController::class,
        'store'
    ])->name('products.store');


    // =========================================================
    // STOCK
    // =========================================================

    Route::get('/stock', [
        StockController::class,
        'index'
    ])->name('stock.index');

    Route::post('/stock/mouvements', [
        StockController::class,
        'store'
    ])->name('stock.movements.store');


    // =========================================================
    // DECONNEXION
    // =========================================================

    Route::post('/logout', [
        AuthController::class,
        'logout'
    ])->name('logout');

    Route::get('/product-image/{path}', function ($path) {

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    return Storage::disk('public')->response($path);

})->where('path', '.*')->name('product.image');
});