<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/export', [DashboardController::class, 'export'])
    ->middleware(['auth'])
    ->name('dashboard.export');

Route::get('/transactions/{transaction}/receipt', [TransactionController::class, 'receipt'])
    ->name('transactions.receipt');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('products', ProductController::class)->middleware('auth');
    Route::post('products', [ProductController::class, 'store'])
    ->middleware(['auth', 'trial.limit'])
    ->name('products.store');
    Route::resource('transactions', TransactionController::class);
});

require __DIR__.'/auth.php';
