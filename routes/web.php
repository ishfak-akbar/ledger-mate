<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    $shops = \App\Models\Shop::where('user_id', $request->user()->id)->latest()->get();
    return view('dashboard', compact('shops'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/shops/create', [ShopController::class, 'create'])->name('shops.create');
    Route::post('/shops', [ShopController::class, 'store'])->name('shops.store');
    Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
    Route::get('/shops/{shop}', [ShopController::class, 'show'])->name('shops.show');

    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});
Route::prefix('shops/{shop}/transactions')->group(function () {
    Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
});

require __DIR__.'/auth.php';
