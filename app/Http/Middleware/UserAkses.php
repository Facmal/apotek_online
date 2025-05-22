<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserAkses
{
    public function handle($request, Closure $next, ...$jabatans)
    {
        // Jika user adalah admin, izinkan akses ke semua halaman
        // if (Auth::check() && Auth::user()->jabatan == 'admin') {
        //     return $next($request);
        // }

        // Cek apakah jabatan user ada dalam daftar $jabatans
        if (Auth::check() && in_array(Auth::user()->jabatan, $jabatans)) {
            return $next($request);
        }

        return redirect('/login')->withErrors(['Anda tidak memiliki akses ke halaman ini.']);
    }
}
