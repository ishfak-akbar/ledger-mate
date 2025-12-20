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

    //Store new transaction
    public function store(Request $request, Shop $shop)
    {
        if ($shop->user_id !== Auth::id()) {
            abort(403);
        }

        //Check if this is a due clearance transaction
        $isDueClearance = $request->has('transaction_type') && $request->transaction_type === 'due_clearance';

        //Common validation rules
        $validationRules = [
            'paid_amount' => 'required|numeric|min:0',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'description' => 'nullable|string',
            'payment_method' => 'required|in:cash,card,bank_transfer,upi,cheque'
        ];

        //Add different validation for total_amount based on transaction type
        if ($isDueClearance) {
            $validationRules['total_amount'] = 'required|numeric|in:0';
            $request->merge(['due_amount' => 0]);
        } else {
            $validationRules['total_amount'] = 'required|numeric|min:0.01';
            $validationRules['note'] = 'nullable|string';
        }

        $request->validate($validationRules);

        //Calculate values
        if ($isDueClearance) {
            $total = 0;
            $paid = $request->paid_amount;
            $due = 0;
        } else {
            $total = $request->total_amount;
            $paid = $request->paid_amount;
            $due = $total - $paid;
        }

        //Create transaction data
        $transactionData = [
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
            'payment_method' => $request->payment_method
        ];

        if (!$isDueClearance) {
            $transactionData['note'] = $request->note;
        }

        Transaction::create($transactionData);

        $message = $isDueClearance 
            ? 'Payment made successfully!' 
            : 'Transaction added successfully!';

        return redirect()->route('shops.show', $shop)
            ->with('success', $message);
    }

    //View all transactions for a shop
    public function index(Shop $shop)
    {
        if ($shop->user_id !== Auth::id()) {
            abort(403);
        }

        $query = $shop->transactions();
        
        //Search filter
        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }
        
        //Status filter
        if ($status = request('status')) {
            if ($status === 'paid') {
                $query->where('due_amount', 0);
            } elseif ($status === 'pending') {
                $query->where('due_amount', '>', 0);
            }
        }
        
        //Payment method filter
        if ($paymentMethod = request('payment_method')) {
            $query->where('payment_method', $paymentMethod);
        }
        
        $transactions = $query->latest()->paginate(10);
        
        //Calculate stats based on ALL transactions
        $stats = [
            'total_transactions' => $shop->transactions()->count(),
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

    //Destroy transaction
    public function destroy(Shop $shop, Transaction $transaction)
    {
        if ($shop->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($transaction->shop_id !== $shop->id) {
            abort(404, 'Transaction not found for this shop.');
        }
        
        $transaction->delete();
        
        return redirect()->back()
            ->with('success', 'Transaction deleted successfully!');
    }
}