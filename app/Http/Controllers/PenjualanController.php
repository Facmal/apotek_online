<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
use App\Models\Obat;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $showCompleted = $request->input('show_completed', false);
        $query = Penjualan::with(['pelanggan', 'detailPenjualan.obat']);

        // Filter based on user role
        if (auth()->user()->jabatan === 'kurir') {
            $query->where('status_order', 'Menunggu Kurir');
        } elseif (auth()->user()->jabatan === 'kasir') {
            $query->where('status_order', 'Menunggu Konfirmasi');
        } else {
            // Hide completed orders unless checkbox is checked
            if (!$showCompleted) {
                $query->where('status_order', '!=', 'Selesai');
            }
        }

        if ($search) {
            // Remove # if present in search term
            $search = str_replace('#', '', $search);
            $query->where('id', 'like', '%' . $search . '%');
        }

        return view('be.penjualan.index', [
            'title' => 'Penjualan',
            'menu' => 'Penjualan',
            'datas' => $query->paginate(5),
            'search' => $search,
            'showCompleted' => $showCompleted
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
    public function show($id)
    {
        $penjualan = Penjualan::with([
            'pelanggan',
            'metodeBayar',
            'jenisPengiriman',
            'detailPenjualan.obat'
        ])->findOrFail($id);

        return view('be.penjualan.detail', [
            'title' => 'Detail Penjualan',
            'menu' => 'Penjualan',
            'penjualan' => $penjualan
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus($id, $status)
    {
        // Check if user is kasir
        if (auth()->user()->jabatan !== 'kasir') {
            return redirect()->route('penjualan.index')
                ->with('error', 'Hanya kasir yang dapat mengkonfirmasi atau menolak pesanan');
        }

        $penjualan = Penjualan::findOrFail($id);

        if ($penjualan->status_order != 'Menunggu Konfirmasi') {
            return redirect()->route('penjualan.index')
                ->with('error', 'Status hanya bisa diubah saat menunggu konfirmasi');
        }

        $penjualan->status_order = $status;
        $penjualan->keterangan_status = $status == 'Diproses' ?
            'Pesanan dikonfirmasi oleh penjual' :
            'Pesanan ditolak oleh penjual';
        $penjualan->save();

        $message = $status == 'Diproses' ?
            'Pesanan berhasil dikonfirmasi' :
            'Pesanan ditolak';

        return redirect()->route('penjualan.index')
            ->with('pesan', $message);
    }

    public function kirim($id)
    {
        if (auth()->user()->jabatan !== 'karyawan') {
            return redirect()->route('penjualan.index')
                ->with('error', 'Hanya karyawan yang dapat mengirim pesanan');
        }

        $penjualan = Penjualan::findOrFail($id);

        if ($penjualan->status_order != 'Diproses') {
            return redirect()->route('penjualan.index')
                ->with('error', 'Status hanya bisa diubah saat pesanan diproses');
        }

        $penjualan->status_order = 'Menunggu Kurir';
        $penjualan->keterangan_status = 'Pesanan siap untuk dikirim';
        $penjualan->save();

        return redirect()->route('penjualan.index')
            ->with('pesan', 'Pesanan berhasil disiapkan untuk pengiriman');
    }

    public function pickup(Request $request, $id)
    {
        if (auth()->user()->jabatan !== 'kurir') {
            return redirect()->route('penjualan.index')
                ->with('error', 'Hanya kurir yang dapat mengambil pesanan');
        }

        $request->validate([
            'telpon_kurir' => 'required|string|max:15'
        ]);

        $penjualan = Penjualan::findOrFail($id);

        if ($penjualan->status_order != 'Menunggu Kurir') {
            return redirect()->route('penjualan.index')
                ->with('error', 'Status pesanan tidak valid untuk pengambilan');
        }

        // Create pengiriman record
        $pengiriman = new \App\Models\Pengiriman([
            'id_penjualan' => $penjualan->id,
            'id_kurir' => auth()->id(),
            'no_invoice' => 'INV/' . date('Ymd') . '/' . $penjualan->id,
            'tgl_kirim' => now(),
            'status_kirim' => 'Sedang Dikirim',
            'nama_kurir' => auth()->user()->name,
            'telpon_kurir' => $request->telpon_kurir
        ]);
        $pengiriman->save();

        // Update penjualan status
        $penjualan->status_order = 'Dalam Pengiriman';
        $penjualan->keterangan_status = 'Pesanan sedang dalam pengiriman oleh kurir';
        $penjualan->save();

        return redirect()->route('penjualan.index')
            ->with('pesan', 'Pesanan berhasil diambil dan siap dikirim');
    }
}
