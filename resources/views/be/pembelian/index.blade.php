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
            <h1 class="card-title" style="font-size: 2.5rem; font-weight: bold; color: blue;">Pembelian</h1>

            <!-- Form Pencarian -->
            <form action="{{ route('pembelian.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nomor nota..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>

            <!-- Tombol Kembali -->
            @if (!empty($search))
            <div class="mb-3">
                <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Clear Search</a>
            </div>
            @endif

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('pembelian.create') }}" class="btn btn-inverse-primary btn-fw">Tambah Pembelian</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nomor Nota</th>
                            <th>Tanggal Pembelian</th>
                            <th>Distributor</th>
                            <th>Total Bayar</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($datas->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data pembelian</td>
                        </tr>
                        @else
                        @foreach ($datas as $nmr => $data)
                        <tr>
                            <td>{{ $datas->firstItem() + $nmr }}</td>
                            <td>{{ $data->nonota }}</td>
                            <td>{{ $data->tgl_pembelian }}</td>
                            <td>{{ $data->distributor->nama_distributor }}</td>
                            <td>Rp {{ number_format($data->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal{{ $data->id }}">
                                        <i class="mdi mdi-eye"></i> View
                                    </button>
                                    <a href="{{ route('pembelian.edit', $data) }}" class="btn btn-warning btn-sm">
                                        <i class="mdi mdi-table-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('pembelian.destroy', $data) }}" onclick="hapus(event, this)" class="btn btn-danger btn-sm">
                                        <i class="mdi mdi-delete-forever"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal untuk View Detail -->
                        <div class="modal fade" id="viewModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $data->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document"> <!-- Ubah modal-lg menjadi modal-sm -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="viewModalLabel{{ $data->id }}">Detail Pembelian</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach ($data->detailPembelians as $index => $detail)
                                        <h5>Detail {{ $index + 1 }}</h5>
                                        <p><strong>Nama Obat:</strong> {{ $detail->obat->nama_obat }}</p>
                                        <p><strong>Jumlah Beli:</strong> {{ $detail->jumlah_beli }}</p>
                                        <p><strong>Harga Beli:</strong> Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</p>
                                        <p><strong>Subtotal:</strong> Rp {{ number_format($detail->harga_beli * $detail->jumlah_beli, 0, ',', '.') }}</p>
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
                    {{ $datas->appends(['search' => $search])->links('pagination::bootstrap-4') }}
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

        if (pesan.trim() !== '') {
            swal('Good Job', pesan, 'success')
        }
    }
    // let pesan = document.getElementById('pesan').value

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
        /* Atur lebar sesuai kebutuhan */
    }
</style>
@endsection