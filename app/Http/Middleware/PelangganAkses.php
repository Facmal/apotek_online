<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PelangganAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated as 'pelanggan'
        if (!Auth::guard('pelanggan')->check()) {
            return redirect('/')->with('error', 'You must be logged in as a customer to access this page.');
        }

        return $next($request);
    }
}
