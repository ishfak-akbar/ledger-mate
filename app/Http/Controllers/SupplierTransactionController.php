<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\SupplierTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierTransactionController extends Controller
{
    public function create(Shop $shop)
    {
        return view('shops/supplier-transaction-create', compact('shop'));
    }

    public function store(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'total_amount' => 'required|numeric|min:0.01',
            'paid_amount' => 'required|numeric|min:0',
            'due_amount' => 'required|numeric',
            'supplier_name' => 'nullable|string|max:255',
            'supplier_phone' => 'nullable|string|max:20',
            'supplier_address' => 'nullable|string',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
            'payment_method' => 'required|string|in:cash,bank_transfer,cheque,credit,online',
            'transaction_type' => 'required|string|in:purchase,payment,return',
        ]);

        $validated['shop_id'] = $shop->id;
        $validated['user_id'] = Auth::id();

        SupplierTransaction::create($validated);

        return redirect()->route('shops.show', $shop)
            ->with('success', 'Supplier transaction added successfully!');
    }

    public function index(Shop $shop)
    {
        $query = SupplierTransaction::where('shop_id', $shop->id);
    
        if (request('supplier')) {
            $query->where('supplier_name', 'like', '%' . request('supplier') . '%');
        }
        
        if (request('type')) {
            $query->where('transaction_type', request('type'));
        }
        
        if (request('from_date')) {
            $query->whereDate('date', '>=', request('from_date'));
        }
        
        if (request('to_date')) {
            $query->whereDate('date', '<=', request('to_date'));
        }
        
        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $totalAmount = $query->sum('total_amount');
        $totalPaid = $query->sum('paid_amount');
        $totalDue = $query->sum('due_amount');
        $totalTransactions = $transactions->total();
        
        $purchaseCount = SupplierTransaction::where('shop_id', $shop->id)
            ->where('transaction_type', 'purchase')
            ->when(request('supplier'), function ($q) {
                $q->where('supplier_name', 'like', '%' . request('supplier') . '%');
            })
            ->when(request('from_date'), function ($q) {
                $q->whereDate('date', '>=', request('from_date'));
            })
            ->when(request('to_date'), function ($q) {
                $q->whereDate('date', '<=', request('to_date'));
            })
            ->count();
        
        $paymentCount = SupplierTransaction::where('shop_id', $shop->id)
            ->where('transaction_type', 'payment')
            ->when(request('supplier'), function ($q) {
                $q->where('supplier_name', 'like', '%' . request('supplier') . '%');
            })
            ->when(request('from_date'), function ($q) {
                $q->whereDate('date', '>=', request('from_date'));
            })
            ->when(request('to_date'), function ($q) {
                $q->whereDate('date', '<=', request('to_date'));
            })
            ->count();
        
        $returnCount = SupplierTransaction::where('shop_id', $shop->id)
            ->where('transaction_type', 'return')
            ->when(request('supplier'), function ($q) {
                $q->where('supplier_name', 'like', '%' . request('supplier') . '%');
            })
            ->when(request('from_date'), function ($q) {
                $q->whereDate('date', '>=', request('from_date'));
            })
            ->when(request('to_date'), function ($q) {
                $q->whereDate('date', '<=', request('to_date'));
            })
            ->count();
        
        return view('supplier-transactions.index', compact(
            'shop',
            'transactions',
            'totalAmount',
            'totalPaid',
            'totalDue',
            'totalTransactions',
            'purchaseCount',
            'paymentCount',
            'returnCount'
        ));
    }

    public function show(Shop $shop, SupplierTransaction $transaction)
    {
        if ($transaction->shop_id !== $shop->id) {
            abort(404);
        }
        
        return view('shops/supplier-transaction-show', compact('shop', 'transaction'));
    }

    public function edit(Shop $shop, SupplierTransaction $transaction)
    {
        if ($transaction->shop_id !== $shop->id) {
            abort(404);
        }
        
        return view('supplier-transaction-edit', compact('shop', 'transaction'));
    }

    public function update(Request $request, Shop $shop, SupplierTransaction $transaction)
    {
        if ($transaction->shop_id !== $shop->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'date' => 'required|date',
            'total_amount' => 'required|numeric|min:0.01',
            'paid_amount' => 'required|numeric|min:0',
            'due_amount' => 'required|numeric',
            'supplier_name' => 'nullable|string|max:255',
            'supplier_phone' => 'nullable|string|max:20',
            'supplier_address' => 'nullable|string',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
            'payment_method' => 'required|string|in:cash,bank_transfer,cheque,credit,online',
            'transaction_type' => 'required|string|in:purchase,payment,return',
        ]);

        $transaction->update($validated);

        return redirect()->route('supplier-transactions.show', [$shop, $transaction])
            ->with('success', 'Transaction updated successfully!');
    }

    public function destroy(Shop $shop, SupplierTransaction $transaction)
    {
        if ($transaction->shop_id !== $shop->id) {
            abort(404);
        }
        
        $transaction->delete();

        return redirect()->route('supplier-transactions.index', $shop)
            ->with('success', 'Transaction deleted successfully!');
    }

    public function makePayment(Request $request, Shop $shop, SupplierTransaction $transaction)
    {
        if ($transaction->shop_id !== $shop->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'payment_amount' => 'required|numeric|min:0.01|max:' . $transaction->due_amount,
            'payment_method' => 'required|string|in:cash,bank_transfer,cheque,online',
            'notes' => 'nullable|string',
        ]);
        
        $transaction->paid_amount += $validated['payment_amount'];
        $transaction->due_amount -= $validated['payment_amount'];
        $transaction->save();
        
        return redirect()->route('supplier-transactions.show', [$shop, $transaction])
            ->with('success', 'Payment of Tk. ' . number_format($validated['payment_amount'], 2) . ' recorded successfully!');
    }

}