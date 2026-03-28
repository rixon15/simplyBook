<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class EnsureUserIsEmployee
{

    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && auth()->user()->isEmployee()) {
            return $next($request);
        }

        return redirect()->route('bookings');
    }

}
