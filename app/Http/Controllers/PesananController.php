<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggan = auth('pelanggan')->user();

        $pesanan = Penjualan::with([
            'detailPenjualan.obat',
            'metodeBayar',
            'jenisPengiriman',
            'pengiriman'  // Add this line
        ])
            ->where('id_pelanggan', $pelanggan->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('fe.pesanan.index', [
            'title' => 'Pesanan Saya',
            'menu' => 'Pesanan',
            'pesanan' => $pesanan
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

    /**
     * Cancel the specified order.
     */
    public function cancel($id)
    {
        $order = Penjualan::where('id_pelanggan', auth('pelanggan')->user()->id)
            ->where('id', $id)
            ->where('status_order', 'Menunggu Konfirmasi')
            ->firstOrFail();

        $order->update([
            'status_order' => 'Dibatalkan Pembeli',
            'keterangan_status' => 'Dibatalkan oleh pembeli'
        ]);

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dibatalkan');
    }

    /**
     * Complete the specified order.
     */
    public function complete($id)
    {
        $order = Penjualan::with('pengiriman')
            ->where('id_pelanggan', auth('pelanggan')->user()->id)
            ->where('id', $id)
            ->where('status_order', 'Dalam Pengiriman')
            ->firstOrFail();

        // Check if delivery exists and has arrived
        if (!$order->pengiriman || $order->pengiriman->status_kirim !== 'Tiba Di Tujuan') {
            return redirect()->route('pesanan.index')
                ->with('error', 'Pesanan belum dapat diselesaikan karena belum tiba di tujuan');
        }

        $order->update([
            'status_order' => 'Selesai',
            'keterangan_status' => 'Pesanan telah diterima dan diselesaikan oleh pembeli'
        ]);

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil diselesaikan');
    }
}
