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
            <h1 class="card-title" style="font-size: 2.5rem; font-weight: bold; color: blue;">Medicine Product</h1> <!-- Heading dengan warna biru -->
            <div class="d-flex justify-content-end mb-3">
                @if ($jenis_obat->isEmpty())
                <button type="button" class="btn btn-inverse-primary btn-fw" onclick="showAlert()"> New Medicine </button>
                @else
                <a href="{{route('obat.create')}}" type="button" class="btn btn-inverse-primary btn-fw"> New Medicine </a>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
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
                            <td>{{$nmr + 1}}</td>
                            <td>{{$data['nama_obat']}}</td>
                            <td>{{$data->jenisObat->jenis}}</td>
                            <td>Rp {{number_format($data['harga_jual'], 0, ',', '.')}}</td>
                            <td>{{$data['stok']}}</td>
                            <td>{{$data['deskripsi_obat']}}</td>
                            <td>
                                <img src="{{asset('storage/'.$data['foto1'])}}" alt="Image" style="width: 50px; height: 50px;" />
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{route('obat.edit', $data)}}" class="btn btn-warning"><i class="mdi mdi-table-edit"></i> Edit</a>
                                    <a href="{{route('obat.destroy', $data)}}" onclick="hapus(event, this)" class="btn btn-danger"><i class="mdi mdi-delete-forever"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
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
    /* Ensure the card matches the table width */
    .card-container {
        width: 100%;
        margin-top: 20px;
        /* Adjust the value to push the card downward */
    }
</style>
@endsection