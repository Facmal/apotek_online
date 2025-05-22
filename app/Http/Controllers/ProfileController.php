<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        return view('fe.profile.index', [
            'pelanggan' => $pelanggan,
            'title' => 'Profile',
            'menu' => 'Profile'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'nama_pelanggan' => 'required',
            'email' => 'required|email|unique:pelanggan,email,' . $id,
            'no_telp' => 'required',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:6',
        ]);

        // Verifikasi password lama jika ada password baru
        if ($request->password) {
            if (!Hash::check($request->current_password, $pelanggan->password)) {
                return redirect()->back()->with('pesan', 'Password lama tidak sesuai.');
            }
        }

        $data = $request->only([
            'nama_pelanggan',
            'email',
            'no_telp',
            'alamat1',
            'kota1',
            'propinsi1',
            'kodepos1',
            'alamat2',
            'kota2',
            'propinsi2',
            'kodepos2',
            'alamat3',
            'kota3',
            'propinsi3',
            'kodepos3'
        ]);

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        // Handle foto profil
        if ($request->file('foto')) {
            if ($pelanggan->foto) {
                unlink(storage_path('app/public/' . $pelanggan->foto));
            }
            $data['foto'] = $request->file('foto')->store('Pelanggan_Images');
        }

        // Handle KTP
        if ($request->file('url_ktp')) {
            if ($pelanggan->url_ktp) {
                unlink(storage_path('app/public/' . $pelanggan->url_ktp));
            }
            $data['url_ktp'] = $request->file('url_ktp')->store('KTP_Images');
        }

        $pelanggan->update($data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
