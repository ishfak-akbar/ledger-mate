<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function create()
    {
        return view('shops.add-shop');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'category' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $shop = Shop::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'address' => $request->address,
            'category' => $request->category,
            'notes' => $request->notes
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Shop added successfully!');
    }

    public function index()
    {
        $shops = Shop::where('user_id', Auth::id())->latest()->get();
        return view('shops.index', compact('shops'));
    }

    public function show(Shop $shop)
    {
        if ($shop->user_id !== Auth::id()) {
            abort(403);
        }
        return view('shops.show', compact('shop'));
    }
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        //Get all shops for the user
        $shops = Shop::where('user_id', $user->id)
                    ->withCount('transactions')
                    ->latest()
                    ->get();
        
        //Get selected date from request or default to today
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        //Calculate daily summary from all shops
        $dailySummary = $this->calculateDailySummary($user, $selectedDate);
        
        //Get daily transactions for the selected date
        $dailyTransactions = $this->getDailyTransactions($user, $selectedDate);
        
        return view('dashboard', compact(
            'shops', 
            'dailySummary', 
            'selectedDate', 
            'dailyTransactions'
        ));
    }
    
    private function calculateDailySummary($user, $date)
    {
        $summary = [
            'sales' => 0,
            'transactions' => 0,
            'due' => 0,
            'received' => 0
        ];
        
        $shops = Shop::where('user_id', $user->id)->get();
        
        foreach ($shops as $shop) {
            $transactions = Transaction::where('shop_id', $shop->id)
                ->whereDate('created_at', $date)
                ->get();
            
            foreach ($transactions as $transaction) {
                $summary['transactions']++;
                $summary['sales'] += $transaction->total_amount;

                if ($transaction->payment_status === 'paid') {
                    $summary['received'] += $transaction->total_amount;
                } elseif ($transaction->payment_status === 'partial') {
                    $paidAmount = $transaction->paid_amount ?? 0;
                    $summary['received'] += $paidAmount;
                    $summary['due'] += ($transaction->total_amount - $paidAmount);
                } else {
                    $summary['due'] += $transaction->total_amount;
                }
            }
        }
        
        return $summary;
    }
    
    private function getDailyTransactions($user, $date)
    {
        return Transaction::whereHas('shop', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereDate('created_at', $date)
            ->with('shop')
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function destroy(Shop $shop)
    {
        if ($shop->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $shop->transactions()->delete();

        $shop->delete();
        
        session()->forget('current_shop');
        
        return redirect()->route('dashboard')
            ->with('success', 'Shop "' . $shop->name . '" has been deleted successfully.');
    }

    public function settings(Shop $shop)
    {
        return view('shops.settings', compact('shop'));
    }

    public function updateSettings(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:retail,wholesale,restaurant,cafe,grocery,electronics,clothing,pharmacy,hardware,other',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $shop->update($validated);

        return redirect()->route('shops.show', $shop)->with('success', 'Shop settings updated successfully!');
    }
}