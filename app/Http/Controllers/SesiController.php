<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    function index()
    {
        return view('auth.login', [
            'title' => 'Login',
            'menu' => 'Login'
        ]);
    }
    function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'Email wajib diisi',
                'password.required' => 'Password wajib diisi'
            ]
        );

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
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
        } else {
            return redirect('/login')->with('error', 'Email atau Password salah!');
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
