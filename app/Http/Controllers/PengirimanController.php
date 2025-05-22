<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengiriman = Pengiriman::with(['penjualan', 'kurir'])
            ->when(auth()->user()->jabatan === 'kurir', function ($query) {
                return $query->where('id_kurir', auth()->id());
            })
            ->latest()
            ->paginate(10);

        return view('be.pengiriman.index', [
            'title' => 'Data Pengiriman',
            'menu' => 'Pengiriman',
            'datas' => $pengiriman
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
        $pengiriman = Pengiriman::with(['penjualan.pelanggan', 'penjualan.detailPenjualan.obat'])
            ->findOrFail($id);

        return view('be.pengiriman.detail', [
            'title' => 'Detail Pengiriman',
            'menu' => 'Pengiriman',
            'data' => $pengiriman
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

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'bukti_foto' => 'required|image', // max 2MB
                'keterangan' => 'nullable|string|max:255'
            ]);

            $pengiriman = Pengiriman::findOrFail($id);

            if ($request->hasFile('bukti_foto')) {
                $file = $request->file('bukti_foto');

                // Debug information
                \Log::info('File Information:', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);

                // Ensure upload directory exists
                $uploadPath = public_path('uploads/bukti_pengiriman');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $filename = time() . '_' . $file->getClientOriginalName();

                // Move with error checking
                try {
                    $file->move($uploadPath, $filename);
                } catch (\Exception $e) {
                    \Log::error('File Upload Error: ' . $e->getMessage());
                    return back()->with('error', 'Gagal mengupload file. Silakan coba lagi.');
                }

                $pengiriman->bukti_foto = 'uploads/bukti_pengiriman/' . $filename;
            }

            $pengiriman->status_kirim = 'Tiba Di Tujuan';
            $pengiriman->tgl_tiba = now();
            $pengiriman->keterangan = $request->keterangan;
            $pengiriman->save();

            return redirect()->route('pengiriman.index')
                ->with('pesan', 'Status pengiriman berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Update Status Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
