<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat; // Pastikan Anda mengimpor model Obat
use App\Models\Keranjang; // Pastikan Anda mengimpor model Keranjang


class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keranjang = auth('pelanggan')->user()->keranjang()->with('obat')->get();

        return view('fe.keranjang.index', [
            'title' => 'Keranjang Belanja',
            'menu' => 'Keranjang Belanja',
            'keranjang' => $keranjang,
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
    public function store(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);

        // Validasi jumlah order
        $request->validate([
            'jumlah_order' => 'required|integer|min:1|max:' . $obat->stok,
        ]);

        // Cek apakah produk sudah ada di keranjang
        $keranjangItem = auth('pelanggan')->user()->keranjang()->where('id_obat', $id)->first();

        if ($keranjangItem) {
            // Jika produk sudah ada, update jumlah dan subtotal
            $keranjangItem->jumlah_order += $request->jumlah_order;
            $keranjangItem->subtotal = $keranjangItem->jumlah_order * $keranjangItem->harga;
            $keranjangItem->save();
        } else {
            // Jika produk belum ada, tambahkan ke keranjang
            auth('pelanggan')->user()->keranjang()->create([
                'id_obat' => $obat->id,
                'jumlah_order' => $request->jumlah_order,
                'harga' => $obat->harga_jual,
                'subtotal' => $request->jumlah_order * $obat->harga_jual,
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Item added to cart!');
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
    public function update(Request $request, $id)
    {
        // Validasi jumlah order
        $request->validate([
            'jumlah_order' => 'required|integer|min:1',
        ]);

        // Cari item keranjang berdasarkan ID dan milik pelanggan yang sedang login
        $keranjangItem = auth('pelanggan')->user()->keranjang()->findOrFail($id);

        // Pastikan jumlah tidak melebihi stok
        if ($request->jumlah_order > $keranjangItem->obat->stok) {
            return redirect()->route('keranjang.index')->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        // Update jumlah dan subtotal
        $keranjangItem->jumlah_order = $request->jumlah_order;
        $keranjangItem->subtotal = $keranjangItem->jumlah_order * $keranjangItem->harga;
        $keranjangItem->save();

        return redirect()->route('keranjang.index')->with('success', 'Cart updated successfully!');
    }

    /**
     * Update the quantity of a specific item in the cart.
     */
    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'jumlah_order' => 'required|integer|min:1',
        ]);

        $keranjangItem = auth('pelanggan')->user()->keranjang()->findOrFail($id);

        // Pastikan jumlah tidak melebihi stok
        if ($request->jumlah_order > $keranjangItem->obat->stok) {
            return response()->json(['success' => false, 'message' => 'Jumlah melebihi stok yang tersedia.']);
        }

        // Update jumlah dan subtotal
        $keranjangItem->jumlah_order = $request->jumlah_order;
        $keranjangItem->subtotal = $keranjangItem->jumlah_order * $keranjangItem->harga;
        $keranjangItem->save();

        return response()->json(['success' => true, 'message' => 'Cart updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari item keranjang berdasarkan ID dan milik pelanggan yang sedang login
        $item = auth('pelanggan')->user()->keranjang()->findOrFail($id);

        // Hapus item dari keranjang
        $item->delete();

        // Redirect kembali ke halaman keranjang dengan pesan sukses
        return redirect()->route('keranjang.index')->with('success', 'Item removed from cart!');
    }

    public static function getCartCount()
    {
        if (auth('pelanggan')->check()) {
            return auth('pelanggan')->user()->keranjang()->sum('jumlah_order');
        }
        return 0;
    }
}
