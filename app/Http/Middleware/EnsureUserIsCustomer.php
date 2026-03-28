<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsCustomer
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->role == 'employee')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }

}
