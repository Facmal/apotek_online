<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserAkses
{
    public function handle($request, Closure $next, ...$jabatans)
    {
        if (Auth::check() && in_array(Auth::user()->jabatan, $jabatans)) {
            return $next($request);
        }else {
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

        
    }
}
