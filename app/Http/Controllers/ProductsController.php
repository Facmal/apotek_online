<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat; // Tambahkan ini di bagian atas file
use App\Models\JenisObat; // Tambahkan ini di bagian atas file

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jenis_obat = JenisObat::all(); // Ambil semua jenis obat
        $selected_jenis = $request->query('jenis'); // Ambil parameter jenis dari URL
        $sort = $request->query('sort'); // Ambil parameter sort dari URL
        $search = $request->query('search'); // Ambil parameter search dari URL

        // Filter obat berdasarkan jenis jika ada parameter jenis
        $obats = Obat::when($selected_jenis, function ($query, $selected_jenis) {
            return $query->where('id_jenis_obat', $selected_jenis);
        });

        // Filter obat berdasarkan pencarian jika ada parameter search
        if ($search) {
            $obats = $obats->where('nama_obat', 'like', '%' . $search . '%');
        }

        // Sorting berdasarkan parameter sort
        if ($sort === 'name_asc') {
            $obats = $obats->orderBy('nama_obat', 'asc');
        } elseif ($sort === 'name_desc') {
            $obats = $obats->orderBy('nama_obat', 'desc');
        } elseif ($sort === 'price_low_high') {
            $obats = $obats->orderBy('harga_jual', 'asc');
        } elseif ($sort === 'price_high_low') {
            $obats = $obats->orderBy('harga_jual', 'desc');
        }

        // Ganti get() dengan paginate()
        $obats = $obats->paginate(12); // 12 items per page

        return view('fe.products.index', [
            'title' => 'Products',
            'menu' => 'Products',
            'obats' => $obats,
            'jenis_obat' => $jenis_obat,
            'selected_jenis' => $selected_jenis,
            'sort' => $sort,
            'search' => $search
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
        $obat = Obat::findOrFail($id); // Ambil data obat berdasarkan ID
        return view('fe.products.detail', compact('obat'), [
            'title' => 'Detail Obat',
            'menu' => 'Products',
            'obat' => $obat
        ]); // Kirim data obat ke view detail
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
}
