<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

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
    Route::delete('/shops/{shop}', [ShopController::class, 'destroy'])->name('shops.destroy');

    Route::prefix('shops/{shop}/transactions')->group(function () {
        Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
        Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    });
});

Route::get('/api/shops/{shop}/search-customers', function (App\Models\Shop $shop) {
    if ($shop->user_id !== Auth::id()) {
        return response()->json([], 403);
    }
    
    $query = request('query');
    
    if (!$query) {
        return response()->json([]);
    }
    
    $customers = $shop->transactions()
        ->where(function ($q) use ($query) {
            $q->where('customer_name', 'like', "%{$query}%")
              ->orWhere('customer_phone', 'like', "%{$query}%");
        })
        ->whereNotNull('customer_name')
        ->selectRaw('
            customer_name as name,
            customer_phone as phone,
            customer_address as address,
            COUNT(*) as transaction_count
        ')
        ->groupBy('customer_name', 'customer_phone', 'customer_address')
        ->orderBy('transaction_count', 'desc')
        ->limit(10)
        ->get();
    
    return response()->json($customers);
})->middleware('auth');

Route::get('/api/shops/{shop}/customer-summary', function (App\Models\Shop $shop) {
    if ($shop->user_id !== Auth::id()) {
        return response()->json([], 403);
    }
    
    $name = request('name');
    $phone = request('phone');
    
    if (!$name || !$phone) {
        return response()->json(['total' => 0, 'paid' => 0, 'due' => 0]);
    }
    
    $summary = $shop->transactions()
        ->where('customer_name', $name)
        ->where('customer_phone', $phone)
        ->selectRaw('
            SUM(total_amount) as total,
            SUM(paid_amount) as paid,
            SUM(due_amount) as due
        ')
        ->first();
    
    return response()->json([
        'total' => $summary->total ?: 0,
        'paid' => $summary->paid ?: 0,
        'due' => $summary->due ?: 0
    ]);
})->middleware('auth');


Route::get('/dashboard', function (Request $request) {
    $shops = \App\Models\Shop::where('user_id', $request->user()->id)->latest()->get();
    
    $today = now()->format('Y-m-d');

    $dailySummary = [
        'sales' => 0,
        'total_amount' => 0,
        'total_due' => 0,
        'received_amount' => 0
    ];
    
    if ($shops->isNotEmpty()) {
        foreach ($shops as $shop) {
            $todayTransactions = $shop->transactions()->whereDate('date', $today)->get();
            
            $dailySummary['sales'] += $todayTransactions->count();
            $dailySummary['total_amount'] += $todayTransactions->sum('total_amount');
            $dailySummary['total_due'] += $todayTransactions->sum('due_amount');
            $dailySummary['received_amount'] += $todayTransactions->sum('paid_amount');
        }
    }
    
    return view('dashboard', compact('shops', 'dailySummary', 'today'));
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';