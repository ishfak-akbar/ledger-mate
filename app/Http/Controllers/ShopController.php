<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}