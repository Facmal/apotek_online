<?php

namespace App\Http\Controllers;

use App\Models\JenisPengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('be.jenispengiriman.index', [
            'title' => 'Jenis Pengiriman',
            'menu' => 'Jenis Pengiriman',
            'datas' => JenisPengiriman::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be.jenispengiriman.create', [
            'title' => 'Tambah Jenis Pengiriman',
            'menu' => 'Tambah Jenis Pengiriman'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_kirim' => 'required',
            'nama_ekspedisi' => 'required',
            'logo_ekspedisi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $jenis = DB::table('jenis_pengiriman')->where([
            ['jenis_kirim', '=', $request->jenis_kirim],
            ['nama_ekspedisi', '=', $request->nama_ekspedisi]
        ])->first();

        if ($jenis) {
            return view('be.jenispengiriman.create', [
                'title' => 'Tambah Jenis Pengiriman',
                'menu' => 'Tambah Jenis Pengiriman',
                'jenis_kirim' => $request->jenis_kirim,
                'nama_ekspedisi' => $request->nama_ekspedisi,
                'pesan' => 'Jenis pengiriman dengan ekspedisi tersebut sudah ada!'
            ]);
        } else {
            $data = $request->only(['jenis_kirim', 'nama_ekspedisi']);
            if ($request->file('logo_ekspedisi')) {
                $data['logo_ekspedisi'] = $request->file('logo_ekspedisi')->store('Logo_Ekspedisi');
            }
            $simpan = JenisPengiriman::create($data);
            if ($simpan) {
                return redirect()->route('jenispengiriman.index')->with('pesan', 'Jenis pengiriman berhasil disimpan!');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jenisPengiriman = JenisPengiriman::findOrFail($id);
        return view('be.jenispengiriman.edit', [
            'title' => 'Edit Jenis Pengiriman',
            'menu' => 'Edit Jenis Pengiriman',
            'jenisPengiriman' => $jenisPengiriman
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jenisPengiriman = JenisPengiriman::findOrFail($id);

        $request->validate([
            'jenis_kirim' => 'required',
            'nama_ekspedisi' => 'required',
            'logo_ekspedisi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['jenis_kirim', 'nama_ekspedisi']);
        if ($request->file('logo_ekspedisi')) {
            if ($jenisPengiriman->logo_ekspedisi) {
                @unlink(storage_path('app/public/' . $jenisPengiriman->logo_ekspedisi));
            }
            $data['logo_ekspedisi'] = $request->file('logo_ekspedisi')->store('Logo_Ekspedisi');
        }

        $jenisPengiriman->update($data);

        return redirect()->route('jenispengiriman.index')->with('pesan', 'Jenis pengiriman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jenisPengiriman = JenisPengiriman::findOrFail($id);
        $logo = $jenisPengiriman->logo_ekspedisi;
        $jenisPengiriman->delete();
        if ($logo) {
            @unlink(storage_path('app/public/' . $logo));
        }
        return redirect()->route('jenispengiriman.index')->with('pesan', 'Jenis pengiriman berhasil dihapus!');
    }
}
