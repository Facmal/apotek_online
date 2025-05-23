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
            <h1 class="card-title" style="font-size: 2.5rem; font-weight: bold; color: blue;">Medicine Type</h1> <!-- Tambahkan judul di sini -->
            <div class="d-flex justify-content-end mb-3">
                <a href="{{route('jenis.create')}}" type="button" class="btn btn-inverse-primary btn-fw"> New Medicine Type </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Jenis</th>
                            <th>Deskripsi</th>
                            <th>Image URL</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($datas->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Belum ada jenis</td>
                        </tr>
                        @else
                        @foreach ($datas as $nmr => $data)
                        <tr>
                            <td>{{$nmr + 1}}</td>
                            <td>{{$data['jenis']}}</td>
                            @if (strlen($data['deskripsi_jenis']) > 15)
                            <td data-bs-toggle="tooltip" data-bs-placement="right" title="{{$data['deskripsi_jenis']}}">{{ substr($data['deskripsi_jenis'], 0, 50) . '...' }}</td>
                            @else
                            <td>{{$data['deskripsi_jenis']}}</td>
                            @endif
                            <td><img src="{{asset('storage/'.$data['image_url'])}}" alt="Image" /></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{route('jenis.edit', $data)}}" class="btn btn-warning"><i class="mdi mdi-table-edit"></i> Edit</a>
                                    <a href="{{route('jenis.destroy', $data)}}" onclick="hapus(event, this)" class="btn btn-danger"><i class="mdi mdi-delete-forever"></i> Delete</a>
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
                text: "Your will not be able to recover this data!",
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
@endsection



<style>
    /* Ensure the card matches the table width */
    .card-container {
        width: 100%;
        margin-top: 20px;
        /* Adjust the value to push the card downward */
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

    .card-container {
        width: 100%;
        margin-top: 20px;
    }
</style>