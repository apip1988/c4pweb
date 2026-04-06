<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Benarkan masuk jika role adalah ADMIN atau SUPER ADMIN
        if (Auth::check() && in_array(Auth::user()->role, ['ADMIN', 'SUPER ADMIN'])) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Anda tidak mempunyai akses ke halaman ini.');
    }
}