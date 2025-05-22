<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodeBayar;

class MetodeBayarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = MetodeBayar::query();

        if ($search) {
            $query->where('metode_pembayaran', 'like', '%' . $search . '%')
                ->orWhere('tempat_bayar', 'like', '%' . $search . '%');
        }

        $datas = $query->orderBy('metode_pembayaran')->paginate(10);

        // Group data after pagination
        $groupedDatas = $datas->getCollection()->groupBy('metode_pembayaran')->map(function ($group) {
            return $group->all(); // Ubah menjadi array
        });

        return view('be.metodebayar.index', [
            'title' => 'Metode Pembayaran',
            'menu' => 'Metode Pembayaran',
            'datas' => $datas,
            'groupedDatas' => $groupedDatas,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('be.metodebayar.create', [
            'title' => 'Tambah Metode Pembayaran',
            'menu' => 'Tambah Metode Pembayaran'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string|max:100',
            'tempat_bayar' => 'required|string|max:50',
            'no_rekening' => 'required|string|max:25',
            'url_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['metode_pembayaran', 'tempat_bayar', 'no_rekening']);

        if ($request->file('url_logo')) {
            $data['url_logo'] = $request->file('url_logo')->store('Logo_MetodeBayar');
        }

        MetodeBayar::create($data);

        return redirect()->route('metodebayar.index')->with('pesan', 'Metode Pembayaran berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $metodeBayar = MetodeBayar::findOrFail($id);

        return view('be.metodebayar.edit', [
            'title' => 'Edit Metode Pembayaran',
            'menu' => 'Edit Metode Pembayaran',
            'metodeBayar' => $metodeBayar
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $metodeBayar = MetodeBayar::findOrFail($id);

        $request->validate([
            'metode_pembayaran' => 'required|string|max:100',
            'tempat_bayar' => 'required|string|max:50',
            'no_rekening' => 'required|string|max:25',
            'url_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['metode_pembayaran', 'tempat_bayar', 'no_rekening']);

        if ($request->file('url_logo')) {
            if ($metodeBayar->url_logo) {
                unlink(storage_path('app/public/' . $metodeBayar->url_logo));
            }
            $data['url_logo'] = $request->file('url_logo')->store('Logo_MetodeBayar');
        }

        $metodeBayar->update($data);

        return redirect()->route('metodebayar.index')->with('pesan', 'Metode Pembayaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $metodeBayar = MetodeBayar::findOrFail($id);

        if ($metodeBayar->url_logo) {
            unlink(storage_path('app/public/' . $metodeBayar->url_logo));
        }

        $metodeBayar->delete();

        return redirect()->route('metodebayar.index')->with('pesan', 'Metode Pembayaran berhasil dihapus!');
    }
}
