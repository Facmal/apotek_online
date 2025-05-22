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
            <h1 class="card-title" style="font-size: 2.5rem; font-weight: bold; color: blue;">Distributor</h1> <!-- Judul tabel -->
            <div class="d-flex justify-content-end mb-3">
                <a href="{{route('distributor.create')}}" type="button" class="btn btn-inverse-primary btn-fw"> Tambah Distributor </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Distributor</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($datas->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Belum ada distributor</td>
                        </tr>
                        @else
                        @foreach ($datas as $nmr => $data)
                        <tr>
                            <td>{{$nmr + 1}}</td>
                            <td>{{$data['nama_distributor']}}</td>
                            <td>{{$data['telepon']}}</td>
                            <td>{{$data['alamat']}}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{route('distributor.edit', $data)}}" class="btn btn-warning"><i class="mdi mdi-table-edit"></i> Edit</a>
                                    <a href="{{route('distributor.destroy', $data)}}" onclick="hapus(event, this)" class="btn btn-danger"><i class="mdi mdi-delete-forever"></i> Delete</a>
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
    const body = document.getElementById('body');
    const form = document.getElementById('delete');

    function hapus(event, el) {
        event.preventDefault();
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this data!",
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
        const pesan = "{{ session('pesan') }}";

        if (pesan.trim() !== '') {
            swal('Good Job', pesan, 'success');
        }
    }

    body.onload = function() {
        tampil_pesan();
    };
</script>
@endsection

<style>
    .card-container {
        width: 100%;
        margin-top: 20px;
    }

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
</style>