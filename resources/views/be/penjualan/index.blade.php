@extends('be.master')
@section('sidebar')
@include('be.sidebar')
@endsection
@section('navbar')
@include('be.navbar')
@endsection
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card card-container">
        <div class="card-body">
            <h1 class="card-title" style="font-size: 2.5rem; font-weight: bold; color: blue;">Penjualan</h1>

            <!-- Form Pencarian -->
            <form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari ID penjualan..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>

            <!-- Tombol Kembali -->
            @if (!empty($search))
            <div class="mb-3">
                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Clear Search</a>
            </div>
            @endif

            <!-- Checkbox untuk Menampilkan Order Selesai (Hanya untuk Admin) -->
            @if(Auth::user()->jabatan !== 'kasir' && Auth::user()->jabatan !== 'kurir')
            <div class="mb-3">
                <form action="{{ route('penjualan.index') }}" method="GET" class="d-flex align-items-center">
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                    <div class="custom-control custom-checkbox mr-3">
                        <input type="checkbox" class="custom-control-input" id="showCompleted" 
                               name="show_completed" value="1" {{ request('show_completed') ? 'checked' : '' }}
                               onChange="this.form.submit()">
                        <label class="custom-control-label" for="showCompleted">
                            Tampilkan order yang sudah selesai
                        </label>
                    </div>
                </form>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Tanggal Penjualan</th>
                            <th>Pelanggan</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($datas->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">
                                @if(Auth::user()->jabatan === 'kurir')
                                    Tidak ada pesanan yang menunggu pengiriman
                                @elseif(Auth::user()->jabatan === 'kasir')
                                    Tidak ada pesanan yang menunggu konfirmasi
                                @else
                                    Belum ada data penjualan
                                @endif
                            </td>
                        </tr>
                        @else
                        @foreach ($datas as $nmr => $data)
                        <tr>
                            <td>{{ $datas->firstItem() + $nmr }}</td>
                            <td>#{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $data->tgl_penjualan }}</td>
                            <td>{{ $data->pelanggan->nama_pelanggan }}</td>
                            <td>Rp {{ number_format($data->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $data->status_order == 'Menunggu Konfirmasi' ? 'warning' : 
                                ($data->status_order == 'Diproses' ? 'info' : 
                                ($data->status_order == 'Selesai' ? 'success' : 
                                ($data->status_order == 'Dibatalkan Pembeli' || $data->status_order == 'Dibatalkan Penjual' ? 'danger' : 'secondary'))) }}">
                                    {{ $data->status_order }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('penjualan.show', $data->id) }}" class="btn btn-info btn-sm">
                                        <i class="mdi mdi-eye"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal untuk View Detail -->
                        <div class="modal fade" id="viewModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $data->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="viewModalLabel{{ $data->id }}">Detail Penjualan</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach ($data->detailPenjualan as $index => $detail)
                                        <h5>Detail {{ $index + 1 }}</h5>
                                        <p><strong>Nama Obat:</strong> {{ $detail->obat->nama_obat }}</p>
                                        <p><strong>Jumlah Beli:</strong> {{ $detail->jumlah_beli }}</p>
                                        <p><strong>Harga Jual:</strong> Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</p>
                                        <p><strong>Subtotal:</strong> Rp {{ number_format($detail->harga_jual * $detail->jumlah_beli, 0, ',', '.') }}</p>
                                        <hr>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $datas->appends(['search' => $search, 'show_completed' => request('show_completed')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<form action="" method="POST" id="delete">
    @method('delete')
    @csrf
</form>

<script>
    const body = document.getElementById('body')
    const form = document.getElementById('delete');

    function hapus(event, el) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false,
        },
        function() {
            form.setAttribute('action', el.getAttribute('href'));
            form.submit();
        });
    }

    function tampil_pesan() {
        const pesan = "{{session('pesan')}}"
        const error = "{{session('error')}}"
        
        if (pesan.trim() !== '') {
            swal('Success', pesan, 'success')
        }
        if (error.trim() !== '') {
            swal('Error', error, 'error')
        }
    }

    body.onload = function() {
        tampil_pesan()
    }
</script>

<style>
    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .btn-group .btn {
        margin-right: 5px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .card-container {
        width: 100%;
        margin-top: 20px;
    }

    .modal-dialog {
        max-width: 400px;
    }

    .badge {
        padding: 8px 12px;
        font-size: 12px;
    }

    .custom-checkbox {
        margin-bottom: 0;
    }

    .custom-control-label {
        font-size: 14px;
        color: #6c757d;
        cursor: pointer;
    }

    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
@endsection