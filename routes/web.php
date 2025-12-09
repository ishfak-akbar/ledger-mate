<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request; // Add this
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Use Request object to get user ID
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
});

require __DIR__.'/auth.php';
