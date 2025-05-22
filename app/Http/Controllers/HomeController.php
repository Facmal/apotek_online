<?php

namespace App\Http\Controllers;

use App\Models\JenisObat;
use App\Models\Obat; // Add this line to use the Obat model
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_obat = JenisObat::take(3)->get();
        $products = Obat::take(6)->get(); // Add this line to get 6 products

        return view('fe.home.index', [
            'title' => 'Home',
            'menu' => 'Home',
            'jenis_obat' => $jenis_obat,
            'products' => $products // Add this line
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
}
