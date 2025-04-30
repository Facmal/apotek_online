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
            <h1 class="card-title" style="font-size: 2.5rem; font-weight: bold; color: blue;">Medicine Product</h1>

            <!-- Form Pencarian -->
            <form action="{{ route('obat.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama obat..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>

            <!-- Tombol Kembali -->
            @if (!empty($search))
            <div class="mb-3">
                <a href="{{ route('obat.index') }}" class="btn btn-secondary">Clear Search</a>
            </div>
            @endif

            <div class="d-flex justify-content-end mb-3">
                @if ($jenis_obat->isEmpty())
                <button type="button" class="btn btn-inverse-primary btn-fw" onclick="showAlert()"> New Medicine </button>
                @else
                <a href="{{route('obat.create')}}" type="button" class="btn btn-inverse-primary btn-fw"> New Medicine </a>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Obat</th>
                            <th>Jenis Obat</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($datas->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center">Belum ada produk</td>
                        </tr>
                        @else
                        @foreach ($datas as $nmr => $data)
                        <tr>
                            <td>{{ $datas->firstItem() + $nmr }}</td> <!-- Menyesuaikan nomor urut dengan pagination -->
                            <td>{{ $data['nama_obat'] }}</td>
                            <td>{{ $data->jenisObat->jenis }}</td>
                            <td>Rp {{ number_format($data['harga_jual'], 0, ',', '.') }}</td>
                            <td>{{ $data['stok'] }}</td>
                            <td>{{ $data['deskripsi_obat'] }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $data['foto1']) }}" alt="Image" style="width: 50px; height: 50px;" />
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('obat.edit', $data) }}" class="btn btn-warning btn-sm"><i class="mdi mdi-table-edit"></i> Edit</a>
                                    <a href="{{ route('obat.destroy', $data) }}" onclick="hapus(event, this)" class="btn btn-danger btn-sm"><i class="mdi mdi-delete-forever"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $datas->appends(['search' => $search])->links('pagination::bootstrap-4') }} <!-- Menampilkan navigasi pagination -->
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
    const form = document.getElementById('delete')

    function hapus(event, el) {
        event.preventDefault()
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
                form.setAttribute('action', el.getAttribute('href'))
                form.submit()
            });
    }

    function showAlert() {
        swal({
            title: "Jenis Obat Tidak Tersedia",
            text: "Anda tidak dapat membuat obat baru karena belum ada jenis obat. Silakan tambahkan jenis obat terlebih dahulu.",
            icon: "warning",
            button: "OK",
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
</style>
@endsection