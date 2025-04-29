<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            if (Auth::user()->jabatan == 'admin') {
                return redirect('/admin');
            } elseif (Auth::user()->jabatan == 'karyawan') {
                return redirect('/karyawan');
            } elseif (Auth::user()->jabatan == 'apoteker') {
                return redirect('/apoteker');
            } elseif (Auth::user()->jabatan == 'pemilik') {
                return redirect('/pemilik');
            } elseif (Auth::user()->jabatan == 'kasir') {
                return redirect('/kasir');
            }
        }

        return $next($request);
    }
}
