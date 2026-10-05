<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

// Pages accessibles uniquement aux visiteurs non connectés
Route::middleware('guest')->group(function () {
    // L'adresse racine redirige vers l'inscription
    Route::get('/', fn () => redirect()->route('login'));

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    // Mot de passe oublié (les noms de routes sont ceux attendus par Laravel)
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Pages réservées aux utilisateurs inscrits et connectés
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    

Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

Route::post('/stock/mouvements', [StockController::class, 'store'])
    ->name('stock.movements.store');
    
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    });