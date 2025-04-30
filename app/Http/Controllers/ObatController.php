<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\JenisObat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); // Ambil input pencarian
        $query = Obat::with('jenisObat');

        if ($search) {
            $query->where('nama_obat', 'like', '%' . $search . '%'); // Filter berdasarkan nama obat
        }

        return view('be.obat.index', [
            'title' => 'Obat',
            'menu' => 'Obat',
            'datas' => $query->paginate(5), // Pagination dengan 5 item per halaman
            'jenis_obat' => JenisObat::all(),
            'search' => $search // Kirim kembali input pencarian ke view
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be.obat.create', [
            'title' => 'Tambah Obat',
            'menu' => 'Tambah Obat',
            'jenis_obat' => JenisObat::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'id_jenis_obat' => 'required|exists:jenis_obat,id',
            'harga_jual' => 'required|integer',
            'stok' => 'required|integer',
            'deskripsi_obat' => 'nullable|string',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check for duplicate nama_obat
        $existingObat = Obat::where('nama_obat', $request->nama_obat)->first();
        if ($existingObat) {
            return redirect()->route('obat.create')->withInput()->with('pesan', 'Obat dengan nama ' . $request->nama_obat . ' sudah ada!');
        }

        $data = $request->only([
            'nama_obat',
            'id_jenis_obat',
            'harga_jual',
            'stok',
            'deskripsi_obat',
        ]);

        if ($request->file('foto1')) {
            $data['foto1'] = $request->file('foto1')->store('Foto_Obat');
        }

        Obat::create($data);

        return redirect()->route('obat.index')->with('pesan', 'Obat ' . $data['nama_obat'] . ' berhasil ditambahkan!');
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
        $obat = Obat::findOrFail($id);
        return view('be.obat.edit', [
            'title' => 'Edit Obat',
            'menu' => 'Edit Obat',
            'obat' => $obat,
            'jenis_obat' => JenisObat::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obat = Obat::findOrFail($id);

        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'id_jenis_obat' => 'required|exists:jenis_obat,id',
            'harga_jual' => 'required|integer',
            'stok' => 'required|integer',
            'deskripsi_obat' => 'nullable|string',
            'foto1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only([
            'nama_obat',
            'id_jenis_obat',
            'harga_jual',
            'stok',
            'deskripsi_obat',
        ]);

        if ($request->file('foto1')) {
            if ($obat->foto1) {
                unlink(storage_path('app/public/' . $obat->foto1));
            }
            $data['foto1'] = $request->file('foto1')->store('Foto_Obat');
        }

        $obat->update($data);

        return redirect()->route('obat.index')->with('pesan', 'Obat ' . $data['nama_obat'] . ' berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);

        if ($obat->foto1) {
            unlink(storage_path('app/public/' . $obat->foto1));
        }

        $namaObat = $obat->nama_obat;
        $obat->delete();

        return redirect()->route('obat.index')->with('pesan', 'Obat ' . $namaObat . ' berhasil dihapus!');
    }
}
