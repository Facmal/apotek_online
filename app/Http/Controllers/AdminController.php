<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\PDF;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userCount = User::count();
        $customerCount = Pelanggan::count();

        // Get selected role filter
        $roleFilter = $request->get('role', 'all');

        // Query users with role filter
        $users = User::when($roleFilter !== 'all', function ($query) use ($roleFilter) {
            return $query->where('jabatan', $roleFilter);
        })->paginate(10);

        // Get available roles
        $roles = ['admin', 'apoteker', 'karyawan', 'kasir', 'pemilik', 'kurir'];

        // Get customer growth data for the last 7 days
        $customerGrowth = Pelanggan::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare data for chart
        $dates = [];
        $counts = [];
        foreach ($customerGrowth as $data) {
            $dates[] = Carbon::parse($data->date)->format('d M');
            $counts[] = $data->total;
        }

        return view('be.dashboard.admin', [
            'title' => 'Admin',
            'userCount' => $userCount,
            'customerCount' => $customerCount,
            'chartDates' => json_encode($dates),
            'chartCounts' => json_encode($counts),
            'users' => $users,
            'roles' => $roles,
            'currentRole' => $roleFilter
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
     * Download PDF of users list.
     */
    public function downloadPDF($role = 'all')
    {
        try {
            $users = User::when($role !== 'all', function ($query) use ($role) {
                return $query->where('jabatan', $role);
            })->get();

            $pdf = PDF::loadView('be.dashboard.admin-pdf', [
                'users' => $users,
                'roleFilter' => $role,
                'currentDate' => now()->format('d M Y')
            ]);

            return $pdf->download('daftar-users-' . strtolower($role) . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal men-download PDF. Silahkan coba lagi.');
        }
    }
}
