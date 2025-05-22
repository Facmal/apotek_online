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
            <h1 class="card-title" style="font-size: 2.5rem; font-weight: bold; color: blue;">Payment Methods</h1>

            <!-- Form Pencarian -->
            <form action="{{ route('metodebayar.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari metode bayar..." value="{{ $search ?? '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>

            <!-- Tombol Kembali -->
            @if (!empty($search))
            <div class="mb-3">
                <a href="{{ route('metodebayar.index') }}" class="btn btn-secondary">Clear Search</a>
            </div>
            @endif

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('metodebayar.create') }}" type="button" class="btn btn-inverse-primary btn-fw"> New Payment Method </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Metode Pembayaran</th>
                            <th>Tempat Bayar</th>
                            <th>No Rekening</th>
                            <th>Logo</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($groupedDatas->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">Belum ada metode pembayaran</td>
                        </tr>
                        @else
                        @foreach ($groupedDatas as $metode => $groupedData)
                        @php $rowspan = count($groupedData); @endphp
                        @foreach ($groupedData as $index => $data)
                        <tr>
                            @if ($index === 0)
                            <td rowspan="{{ $rowspan }}">{{ $loop->parent->iteration }}</td>
                            <td rowspan="{{ $rowspan }}">{{ $metode }}</td>
                            @endif
                            <td>{{ $data->tempat_bayar }}</td>
                            <td>{{ $data->no_rekening }}</td>
                            <td>
                                @if ($data->url_logo)
                                <img src="{{ asset('storage/' . $data->url_logo) }}" alt="Logo" style="width: 50px; height: 50px;" />
                                @else
                                <span>-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('metodebayar.edit', $data) }}" class="btn btn-warning btn-sm"><i class="mdi mdi-table-edit"></i> Edit</a>
                                    <a href="{{ route('metodebayar.destroy', $data) }}" onclick="hapus(event, this)" class="btn btn-danger btn-sm"><i class="mdi mdi-delete-forever"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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

    function tampil_pesan() {
        const pesan = "{{session('pesan')}}"

        if (pesan.trim() !== '') {
            swal('Good Job', pesan, 'success')
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
</style>
@endsection