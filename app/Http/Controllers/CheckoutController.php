<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\JenisPengiriman;
use App\Models\MetodeBayar;
use App\Models\Obat;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;
use Carbon\Carbon;
use Illuminate\Support\Str;


class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedItems = json_decode($request->selected_items, true);

        $keranjang = collect();
        if ($selectedItems) {
            $ids = collect($selectedItems)->pluck('id');
            $keranjang = auth('pelanggan')->user()->keranjang()->with('obat')->whereIn('id', $ids)->get();

            foreach ($keranjang as $item) {
                $found = collect($selectedItems)->firstWhere('id', $item->id);
                if ($found) {
                    $item->jumlah_order = $found['qty'];
                    $item->subtotal = $item->jumlah_order * $item->harga;
                }
            }
        }

        // Ambil data pelanggan yang sedang login
        $pelanggan = auth('pelanggan')->user();

        // Get metode pembayaran dan jenis pengiriman
        $metode_bayar = MetodeBayar::all();
        $jenis_pengiriman = JenisPengiriman::all();

        return view('fe.checkout.index', [
            'keranjang' => $keranjang,
            'pelanggan' => $pelanggan,
            'metode_bayar' => $metode_bayar,
            'jenis_pengiriman' => $jenis_pengiriman,
            'title' => 'Checkout',
            'menu' => 'Checkout'
        ]);
    }

    /**
     * Process the checkout and get Midtrans snap token
     */
    public function process(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'id_metode_bayar' => 'required|exists:metode_bayar,id',
            'id_jenis_kirim' => 'required|exists:jenis_pengiriman,id',
            'keranjang_ids' => 'required|array',
            'keranjang_quantities' => 'required|array',
            'ongkos_kirim' => 'required|numeric',
            'address_id' => 'required|in:1,2,3',
            'url_resep' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            // Get keranjang items
            $keranjangIds = $request->keranjang_ids;
            $quantities = $request->keranjang_quantities;

            $keranjang = auth('pelanggan')->user()->keranjang()->with('obat')->whereIn('id', $keranjangIds)->get();

            // Calculate total
            $total_bayar = 0;
            $items = [];
            $orderDetails = [];

            foreach ($keranjang as $index => $item) {
                $qty = $quantities[$index] ?? 1;
                $subtotal = $qty * $item->harga;
                $total_bayar += $subtotal;

                // Prepare item for Midtrans
                $items[] = [
                    'id' => 'ITEM-' . $item->id,
                    'price' => $item->harga,
                    'quantity' => $qty,
                    'name' => $item->obat->nama_obat
                ];

                // Prepare detail penjualan record
                $orderDetails[] = [
                    'id_obat' => $item->obat->id,
                    'jumlah' => $qty,
                    'harga' => $item->harga,
                    'subtotal' => $subtotal
                ];
            }

            // Add ongkos kirim to total
            $ongkos_kirim = $request->ongkos_kirim;
            $total_bayar += $ongkos_kirim;

            // Add biaya aplikasi (if any)
            $biaya_app = 1000; // You can set this as needed
            $total_bayar += $biaya_app;

            // Handle resep upload if exists

            // Get customer details based on selected address
            $addressId = $request->address_id;
            $addressField = 'alamat' . $addressId;
            $kotaField = 'kota' . $addressId;
            $propinsiField = 'propinsi' . $addressId;
            $kodeposField = 'kodepos' . $addressId;

            $pelanggan = auth('pelanggan')->user();
            $order = Penjualan::create([
                'id_metode_bayar' => $request->id_metode_bayar,
                'tgl_penjualan' => Carbon::now(),
                'url_resep' => $request->file('url_resep') ? $request->file('url_resep')->store('resep') : null,
                'ongkos_kirim' => $ongkos_kirim,
                'biaya_app' => $biaya_app,
                'total_bayar' => $total_bayar,
                'status_order' => 'Menunggu Konfirmasi',
                'id_jenis_kirim' => $request->id_jenis_kirim,
                'id_pelanggan' => $pelanggan->id,
            ]);

            // Add this code to create detail_penjualan records:
            foreach ($keranjang as $index => $item) {
                $qty = $quantities[$index] ?? 1;
                $subtotal = $qty * $item->harga;

                // Create detail penjualan record
                $order->detailPenjualan()->create([
                    'id_obat' => $item->obat->id,
                    'jumlah_beli' => $qty,
                    'harga_beli' => $item->harga,
                    'subtotal' => $subtotal
                ]);

                // Update stock
                $obat = Obat::find($item->obat->id);
                if ($obat) {
                    if ($obat->stok < $qty) {
                        throw new \Exception('Stok obat ' . $obat->nama_obat . ' tidak mencukupi');
                    }
                    $obat->update([
                        'stok' => $obat->stok - $qty
                    ]);
                }
            }

            // Generate transaction details for Midtrans
            $transaction_details = [
                'order_id' => 'ORDER-' . $order->id . '-' . Str::random(5),
                'gross_amount' => $total_bayar,
            ];

            // Customer details
            $customer_details = [
                'first_name' => $pelanggan->nama_pelanggan,
                'email' => $pelanggan->email,
                'phone' => $pelanggan->no_telp,
                'billing_address' => [
                    'first_name' => $pelanggan->nama_pelanggan,
                    'phone' => $pelanggan->no_telp,
                    'address' => $pelanggan->$addressField,
                    'city' => $pelanggan->$kotaField,
                    'postal_code' => $pelanggan->$kodeposField,
                    'country_code' => 'IDN'
                ],
                'shipping_address' => [
                    'first_name' => $pelanggan->nama_pelanggan,
                    'phone' => $pelanggan->no_telp,
                    'address' => $pelanggan->$addressField,
                    'city' => $pelanggan->$kotaField,
                    'postal_code' => $pelanggan->$kodeposField,
                    'country_code' => 'IDN'
                ]
            ];

            // Add shipping cost as an item
            if ($ongkos_kirim > 0) {
                $items[] = [
                    'id' => 'SHIPPING',
                    'price' => $ongkos_kirim,
                    'quantity' => 1,
                    'name' => 'Biaya Pengiriman'
                ];
            }

            // Add platform fee as an item if applicable
            if ($biaya_app > 0) {
                $items[] = [
                    'id' => 'PLATFORM_FEE',
                    'price' => $biaya_app,
                    'quantity' => 1,
                    'name' => 'Biaya Platform'
                ];
            }

            $payload = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'item_details' => $items
            ];

            // Get Snap Token from Midtrans
            $snapToken = Snap::getSnapToken($payload);

            // Update the order with snap token
            $order->update(['snap_token' => $snapToken]);

            // Delete items from keranjang after successful order creation
            auth('pelanggan')->user()->keranjang()->whereIn('id', $keranjangIds)->delete();

            // Return response with snap token
            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $order->id,
                'midtrans_order_id' => $transaction_details['order_id'] // Add this line
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle Midtrans notification callback
     */
    public function notification(Request $request)
    {
        try {
            $notification = new Notification();

            $order_id = $notification->order_id;
            $transaction_status = $notification->transaction_status;
            $fraud_status = $notification->fraud_status;

            // Extract the actual order ID from Midtrans order_id format (ORDER-123-XXXXX)
            $orderId = explode('-', $order_id)[1];

            // Get the order with its details and related products
            $order = Penjualan::with('detailPenjualan.obat')->find($orderId);

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transaction_status == 'capture') {
                if ($fraud_status == 'challenge') {
                    $this->cancelAndDeleteOrder($order);
                } else if ($fraud_status == 'accept') {
                    $this->updateOrderSuccess($order);
                }
            } else if ($transaction_status == 'settlement') {
                $this->updateOrderSuccess($order);
            } else if ($transaction_status == 'pending') {
                $this->updateOrderPending($order);
            } else if (
                $transaction_status == 'deny' ||
                $transaction_status == 'cancel' ||
                $transaction_status == 'expire'
            ) {
                $this->cancelAndDeleteOrder($order);
            }

            return response()->json(['message' => 'Notification processed']);
        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle successful payment
     */
    public function finish(Request $request)
    {
        return redirect()->route('checkout.success')->with('success', 'Pembayaran berhasil!');
    }

    /**
     * Handle pending payment
     */
    public function unfinished(Request $request)
    {
        return redirect()->route('checkout.pending')->with('info', 'Pembayaran dalam proses!');
    }

    /**
     * Handle failed payment
     */
    public function error(Request $request)
    {
        \DB::beginTransaction();
        try {
            $order_id = $request->order_id;
            if ($order_id) {
                // Extract order ID from Midtrans format (ORDER-123-XXXXX)
                $orderId = explode('-', $order_id)[1];

                // Find the order with its details and related products
                $order = Penjualan::with(['detailPenjualan.obat'])->find($orderId);

                if ($order) {
                    // Restore stock for each item
                    foreach ($order->detailPenjualan as $detail) {
                        $obat = $detail->obat;
                        if ($obat) {
                            $obat->increment('stok', $detail->jumlah_beli);
                        }
                    }

                    // Delete related records first
                    $order->detailPenjualan()->delete();
                    $order->delete();

                    \DB::commit();

                    return redirect()->route('checkout.failed')
                        ->with('error', 'Pembayaran gagal! Order telah dibatalkan dan stok telah dikembalikan.');
                }
            }

            \DB::commit();
            return redirect()->route('checkout.failed')
                ->with('error', 'Pembayaran gagal!');
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Payment Error Handler: ' . $e->getMessage());
            return redirect()->route('checkout.failed')
                ->with('error', 'Terjadi kesalahan sistem. Silakan hubungi admin.');
        }
    }

    /**
     * Helper method to cancel and delete order
     */
    private function cancelAndDeleteOrder($order)
    {
        \DB::beginTransaction();
        try {
            if (!$order) {
                throw new \Exception('Order not found');
            }

            // Restore stock for each item
            foreach ($order->detailPenjualan as $detail) {
                $obat = $detail->obat;
                if ($obat) {
                    $obat->increment('stok', $detail->jumlah_beli);
                }
            }

            // Delete related records first
            $order->detailPenjualan()->delete();
            $order->delete();

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Cancel Order Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Helper method to update order on success
     */
    private function updateOrderSuccess($order)
    {
        $order->update([
            'status_order' => 'Diproses',
            'keterangan_status' => 'Pembayaran berhasil'
        ]);
    }

    /**
     * Helper method to update order on pending
     */
    private function updateOrderPending($order)
    {
        $order->update([
            'status_order' => 'Menunggu Konfirmasi',
            'keterangan_status' => 'Menunggu pembayaran'
        ]);
    }

    /**
     * Show successful payment page
     */
    public function success()
    {
        return view('fe.checkout.success', [
            'title' => 'Pembayaran Berhasil',
            'menu' => 'Checkout'
        ]);
    }

    /**
     * Show pending payment page
     */
    public function pending()
    {
        return view('fe.checkout.pending', [
            'title' => 'Pembayaran Dalam Proses',
            'menu' => 'Checkout'
        ]);
    }

    /**
     * Show failed payment page
     */
    public function failed()
    {
        return view('fe.checkout.failed', [
            'title' => 'Pembayaran Gagal',
            'menu' => 'Checkout'
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
