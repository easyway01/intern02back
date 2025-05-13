<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors('You must log in first.');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect('/')->withErrors('Unauthorized access.');
        }

        return $next($request);
    }
}
