<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;

class SesiPelangganController extends Controller
{
    /**
     * Menampilkan halaman login dan registrasi pelanggan.
     */
    public function index()
    {
        return view('auth.loginregister', [
            'title' => 'Login & Register Pelanggan',
            'menu' => 'LoginRegister'
        ]);
    }

    /**
     * Proses login pelanggan.
     */
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password wajib diisi'
            ]
        );

        $pelanggan = Pelanggan::where('email', $request->email)->first();

        if ($pelanggan && password_verify($request->password, $pelanggan->password)) {
            Auth::guard('pelanggan')->login($pelanggan);
            return redirect('/')->with('pesan', 'Login berhasil!');
        } else {
            return redirect('/login-pelanggan')->with('pesan', 'Email atau Password salah!');
        }
    }

    /**
     * Proses registrasi pelanggan baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggan,email',
            'password' => 'required|string|min:6|confirmed',
            'no_telp' => 'required|string|max:15',
            'alamat1' => 'required|string|max:255',
            'kota1' => 'required|string|max:255',
            'propinsi1' => 'required|string|max:255',
            'kodepos1' => 'required|string|max:255',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'no_telp.required' => 'Nomor telepon wajib diisi',
            'alamat1.required' => 'Alamat wajib diisi',
            'kota1.required' => 'Kota wajib diisi',
            'propinsi1.required' => 'Provinsi wajib diisi',
            'kodepos1.required' => 'Kode pos wajib diisi',
        ]);

        // Buat pelanggan baru
        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_telp' => $request->no_telp,
            'alamat1' => $request->alamat1,
            'kota1' => $request->kota1,
            'propinsi1' => $request->propinsi1,
            'kodepos1' => $request->kodepos1,
        ]);

        // Login pelanggan yang baru dibuat
        Auth::guard('pelanggan')->login($pelanggan);

        // Redirect ke halaman utama dengan pesan sukses
        return redirect('/')->with('pesan', 'Registrasi berhasil! Anda telah login.');
    }

    /**
     * Logout pelanggan.
     */
    public function logout()
    {
        Auth::guard('pelanggan')->logout();
        return redirect('/')->with('pesan', 'Logout berhasil!');
    }
}
