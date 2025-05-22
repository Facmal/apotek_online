<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('be.distributor.index', [
            'title' => 'Distributor',
            'menu' => 'Distributor',
            'datas' => Distributor::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be.distributor.create', [
            'title' => 'Distributor',
            'menu' => 'Tambah Distributor'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Cek apakah nama distributor sudah ada
        $existingDistributor = Distributor::where('nama_distributor', $request->nama_distributor)->first();

        if ($existingDistributor) {
            return view('be.distributor.create', [
                'title' => 'Distributor',
                'menu' => 'Tambah Distributor',
                'nama_distributor' => $request->nama_distributor,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'pesan' => 'Distributor dengan nama "' . $request->nama_distributor . '" sudah ada!'
            ]);
        } else {
            // Validasi data
            $validated = $request->validate([
                'nama_distributor' => 'required|string|max:50',
                'telepon' => 'nullable|string|max:15',
                'alamat' => 'nullable|string|max:255',
            ]);

            // Simpan data distributor
            Distributor::create($validated);

            return redirect()->route('distributor.index')->with('pesan', 'Distributor berhasil ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        return view('be.distributor.show', [
            'title' => 'Detail Distributor',
            'menu' => 'Distributor',
            'data' => $distributor
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distributor $distributor)
    {
        return view('be.distributor.edit', [
            'title' => 'Edit Distributor',
            'menu' => 'Distributor',
            'data' => $distributor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Distributor $distributor)
    {
        $validated = $request->validate([
            'nama_distributor' => 'required|string|max:50',
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);

        $distributor->update($validated);

        return redirect()->route('distributor.index')->with('pesan', 'Distributor berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor)
    {
        $distributor->delete();

        return redirect()->route('distributor.index')->with('pesan', 'Distributor berhasil dihapus.');
    }
}
