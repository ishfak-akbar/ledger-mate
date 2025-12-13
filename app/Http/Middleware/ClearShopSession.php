<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClearShopSession
{
    public function handle(Request $request, Closure $next)
    {
        //Clear shop session when going to dashboard
        if ($request->routeIs('dashboard')) {
            session()->forget('current_shop');
        }
        
        return $next($request);
    }
}