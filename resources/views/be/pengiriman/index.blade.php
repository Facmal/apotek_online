@extends('be.master')
@section('sidebar')
@include('be.sidebar')
@endsection
@section('navbar')
@include('be.navbar')
@endsection
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Pengiriman</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Invoice</th>
                            <th>Tanggal Kirim</th>
                            <th>Nama Kurir</th>
                            <th>Status</th>
                            <th>Penerima</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->no_invoice }}</td>
                            <td>{{ $item->tgl_kirim }}</td>
                            <td>{{ $item->nama_kurir }}<br>({{ $item->telpon_kurir }})</td>
                            <td>
                                <span class="badge badge-{{ $item->status_kirim == 'Sedang Dikirim' ? 'warning' : 'success' }}">
                                    {{ $item->status_kirim }}
                                </span>
                            </td>
                            <td>
                                {{ $item->penjualan->pelanggan->nama_pelanggan }}<br>
                                {{ $item->penjualan->pelanggan->alamat1 }}
                            </td>
                            <td>
                                <a href="{{ route('pengiriman.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="mdi mdi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pengiriman</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $datas->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

<style>
.table th, 
.table td {
    vertical-align: middle;
    text-align: center;
}
.badge {
    padding: 8px 12px;
    font-size: 12px;
}
</style>
@endsection