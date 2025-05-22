<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Distributor;
use App\Models\Obat;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Pembelian::with(['distributor', 'detailPembelians.obat']); // Ganti 'details' dengan 'detailPembelians'

        if ($search) {
            $query->where('nonota', 'like', '%' . $search . '%');
        }

        return view('be.pembelian.index', [
            'title' => 'Pembelian',
            'menu' => 'Pembelian',
            'datas' => $query->paginate(5),
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be.pembelian.create', [
            'title' => 'Tambah Pembelian',
            'menu' => 'Tambah Pembelian',
            'distributors' => Distributor::all(),
            'obats' => Obat::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nonota' => 'required|string|max:100|unique:pembelian,nonota',
            'tgl_pembelian' => 'required|date',
            'id_distributor' => 'required|exists:distributor,id',
            'total_bayar' => 'required|numeric',
            'details.*.id_obat' => 'required|exists:obat,id',
            'details.*.jumlah_beli' => 'required|integer|min:1',
            'details.*.harga_beli' => 'required|numeric|min:0',
        ]);

        $pembelian = Pembelian::create($request->only(['nonota', 'tgl_pembelian', 'id_distributor', 'total_bayar']));

        foreach ($request->details as $detail) {
            DetailPembelian::create([
                'id_pembelian' => $pembelian->id,
                'id_obat' => $detail['id_obat'],
                'jumlah_beli' => $detail['jumlah_beli'],
                'harga_beli' => $detail['harga_beli'],
                'subtotal' => $detail['jumlah_beli'] * $detail['harga_beli'],
            ]);

            // Update stok obat
            $obat = Obat::find($detail['id_obat']);
            $obat->stok += $detail['jumlah_beli'];
            $obat->save();
        }

        return redirect()->route('pembelian.index')->with('pesan', 'Pembelian berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembelian = Pembelian::with('detailPembelians.obat', 'distributor')->findOrFail($id);

        return view('be.pembelian.show', [
            'title' => 'Detail Pembelian',
            'menu' => 'Pembelian',
            'pembelian' => $pembelian
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pembelian = Pembelian::with('detailPembelians.obat')->findOrFail($id);

        return view('be.pembelian.edit', [
            'title' => 'Edit Pembelian',
            'menu' => 'Edit Pembelian',
            'pembelian' => $pembelian,
            'distributors' => Distributor::all(),
            'obats' => Obat::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $request->validate([
            'nonota' => 'required|string|max:100|unique:pembelian,nonota,' . $pembelian->id,
            'tgl_pembelian' => 'required|date',
            'id_distributor' => 'required|exists:distributor,id',
            'total_bayar' => 'required|numeric',
            'details.*.id_obat' => 'required|exists:obat,id',
            'details.*.jumlah_beli' => 'required|integer|min:1',
            'details.*.harga_beli' => 'required|numeric|min:0',
        ]);

        $pembelian->update($request->only(['nonota', 'tgl_pembelian', 'id_distributor', 'total_bayar']));

        // Hapus detail pembelian lama
        foreach ($pembelian->detailPembelians as $detail) {
            $obat = Obat::find($detail->id_obat);
            $obat->stok -= $detail->jumlah_beli;
            $obat->save();
            $detail->delete();
        }

        // Tambahkan detail pembelian baru
        foreach ($request->details as $detail) {
            DetailPembelian::create([
                'id_pembelian' => $pembelian->id,
                'id_obat' => $detail['id_obat'],
                'jumlah_beli' => $detail['jumlah_beli'],
                'harga_beli' => $detail['harga_beli'],
                'subtotal' => $detail['jumlah_beli'] * $detail['harga_beli'],
            ]);

            // Update stok obat
            $obat = Obat::find($detail['id_obat']);
            $obat->stok += $detail['jumlah_beli'];
            $obat->save();
        }

        return redirect()->route('pembelian.index')->with('pesan', 'Pembelian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembelian = Pembelian::with('detailPembelians.obat')->findOrFail($id);

        foreach ($pembelian->detailPembelians as $detail) {
            $obat = Obat::find($detail->id_obat);
            $obat->stok -= $detail->jumlah_beli;
            $obat->save();
            $detail->delete();
        }

        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('pesan', 'Pembelian berhasil dihapus!');
    }
}
