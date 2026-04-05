<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Jika user sudah login (Authenticated), hantar mereka ke Laman Utama
        if (Auth::guard($guard)->check()) {
            return redirect('/'); 
        }

        return $next($request);
    }
}