<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function create(Shop $shop)
    {
        if ($shop->user_id !== Auth::id()) {
            abort(403);
        }

        return view('transactions.create', compact('shop'));
    }

    // Store new transaction
    public function store(Request $request, Shop $shop)
    {
        if ($shop->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'total_amount' => 'required|numeric|min:0.01',
            'paid_amount' => 'required|numeric|min:0',
            'customer_name' => 'nullable|string|max:100',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:cash,card,bank_transfer,upi,cheque'
        ]);

        // Calculate due amount
        $total = $request->total_amount;
        $paid = $request->paid_amount;
        $due = $total - $paid;

        Transaction::create([
            'shop_id' => $shop->id,
            'user_id' => Auth::id(),
            'date' => now(),
            'total_amount' => $total,
            'paid_amount' => $paid,
            'due_amount' => $due,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'description' => $request->description,
            'note' => $request->note,
            'payment_method' => $request->payment_method
        ]);

        return redirect()->route('shops.show', $shop)
            ->with('success', 'Transaction added successfully!');
    }

    // View all transactions for a shop
    public function index(Shop $shop)
    {
        if ($shop->user_id !== Auth::id()) {
            abort(403);
        }

        $transactions = $shop->transactions()->latest()->paginate(20);
        $stats = [
            'total_transactions' => $transactions->total(),
            'total_amount' => $shop->transactions()->sum('total_amount'),
            'total_paid' => $shop->transactions()->sum('paid_amount'),
            'total_due' => $shop->transactions()->sum('due_amount'),
            'completed' => $shop->transactions()->where('due_amount', 0)->count(),
            'pending' => $shop->transactions()->where('due_amount', '>', 0)->count()
        ];

        return view('transactions.index', compact('shop', 'transactions', 'stats'));
    }

    // Show single transaction
    public function show(Shop $shop, Transaction $transaction)
    {
        if ($shop->user_id !== Auth::id() || $transaction->shop_id !== $shop->id) {
            abort(403);
        }

        return view('transactions.show', compact('shop', 'transaction'));
    }
}