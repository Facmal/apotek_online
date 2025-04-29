<?php

namespace App\Http\Controllers;

use App\Models\JenisObat;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('be.jenis.index', [
            'title' => 'Jenis',
            'menu' => 'Jenis Obat',
            'datas' => JenisObat::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be.jenis.create', [
            'title' => 'Jenis',
            'menu' => 'Tambah Jenis Obat'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jenis = DB::table('jenis_obat')->where('jenis', '=', $request->jenis)->value('jenis');

        if ($jenis) {
            return view('be.jenis.create', [
                'title' => 'Admin',
                'menu' => 'Jenis Obat',
                'jenis' => $request->jenis,
                'deskripsi_jenis' => $request->deskripsi_jenis,
                'pesan' => 'Jenis obat "' . $request['jenis'] . '" sudah ada!'
            ]);
        } else {
            $data = $request->only([
                'menu',
                'jenis',
                'deskripsi_jenis',
            ]);
            if ($request->file('image_url') !== null) $data['image_url'] = $request->file('image_url')->store('Foto_Jenis');
            $simpan = JenisObat::create($data);
            if ($simpan) {
                return redirect()->route('jenis.index')->with('pesan', 'Jenis obat ' . $data['jenis'] . ' berhasil disimpan!');
            }
        }
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
    public function edit($id)
    {
        $jenisObat = JenisObat::findOrFail($id);
        return view('be.jenis.edit', [
            'title' => 'Edit Jenis Obat',
            'menu' => 'Edit Jenis Obat',
            'jenisObat' => $jenisObat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jenisObat = JenisObat::findOrFail($id);

        $request->validate([
            'jenis' => 'required',
            'deskripsi_jenis' => 'required',
        ]);

        $data = $request->only(['jenis', 'deskripsi_jenis']);
        if ($request->file('image_url')) {
            if ($jenisObat->image_url) {
                unlink(storage_path('app/public/' . $jenisObat->image_url));
            }
            $data['image_url'] = $request->file('image_url')->store('Foto_Jenis');
        }

        $jenisObat->update($data);

        return redirect()->route('jenis.index')->with('pesan', 'Jenis obat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image_url = JenisObat::find($id)->value('image_url');
        JenisObat::find($id)->delete();
        if ($image_url !== null) unlink(storage_path('app/public/' . $image_url));
        return redirect()->route('jenis.index')->with('pesan', 'Jenis obat berhasil dihapus!');
    }
}
