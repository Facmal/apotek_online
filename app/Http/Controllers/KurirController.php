<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;

class KurirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kurirId = Auth::id();

        // Get selected status filter, default to 'Sedang Dikirim'
        $statusFilter = $request->get('status', 'Sedang Dikirim');

        // Count orders for widgets
        $waitingCount = Penjualan::where('status_order', 'Menunggu Kurir')->count();
        $onDeliveryCount = Pengiriman::where('id_kurir', $kurirId)
            ->where('status_kirim', 'Sedang Dikirim')
            ->count();
        $deliveredCount = Pengiriman::where('id_kurir', $kurirId)
            ->where('status_kirim', 'Tiba Di Tujuan')
            ->count();

        // Get deliveries for table with filter
        $deliveries = Pengiriman::with(['penjualan.pelanggan'])
            ->where('id_kurir', $kurirId)
            ->when($statusFilter !== 'all', function ($query) use ($statusFilter) {
                return $query->where('status_kirim', $statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('be.dashboard.kurir', [
            'title' => 'Kurir',
            'menu' => 'Kurir',
            'waitingCount' => $waitingCount,
            'onDeliveryCount' => $onDeliveryCount,
            'deliveredCount' => $deliveredCount,
            'deliveries' => $deliveries,
            'currentStatus' => $statusFilter
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
     * Download PDF of deliveries.
     */
    public function downloadPDF($status = 'all')
    {
        try {
            $kurirId = Auth::id();
            $kurir = Auth::user(); // Get current logged in courier

            $deliveries = Pengiriman::with(['penjualan.pelanggan'])
                ->where('id_kurir', $kurirId)
                ->when($status !== 'all', function ($query) use ($status) {
                    return $query->where('status_kirim', $status);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            $pdf = PDF::loadView('be.dashboard.kurir-pdf', [
                'deliveries' => $deliveries,
                'statusFilter' => $status,
                'currentDate' => now()->format('d M Y'),
                'kurirName' => $kurir->name // Add courier name
            ]);

            return $pdf->download('daftar-pengiriman-' . strtolower($status) . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal men-download PDF. Silahkan coba lagi.');
        }
    }
}
