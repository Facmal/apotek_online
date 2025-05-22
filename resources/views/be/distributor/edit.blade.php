@extends('be.master')
@section('sidebar')
@include('be.sidebar')
@endsection
@section('navbar')
@include('be.navbar')
@endsection
@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Distributor</h4>
            <p class="card-description">Form untuk mengedit data distributor</p>
            <form action="{{ route('distributor.update', $data->id) }}" class="forms-sample" name="frmDistributor" id="frmDistributor" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_distributor">Nama Distributor</label>
                    <input type="text" class="form-control" name="nama_distributor" id="nama_distributor" placeholder="Nama Distributor" value="{{ old('nama_distributor', $data->nama_distributor) }}" />
                </div>
                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="text" class="form-control" name="telepon" id="telepon" placeholder="Telepon"
                        value="{{ old('telepon', $data->telepon) }}" maxlength="15" oninput="validateTelepon(this)" />
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" rows="4">{{ old('alamat', $data->alamat) }}</textarea>
                </div>

                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('distributor.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>

<div id="pesan" class="invisible">
    @isset($pesan){{$pesan}}@endisset
</div>

<script>
    const btnSave = document.getElementById('btnSimpan');
    const namaDistributor = document.getElementById('nama_distributor');
    const telepon = document.getElementById('telepon');
    const alamat = document.getElementById('alamat');
    const form = document.getElementById('frmDistributor');
    const pesan = document.getElementById('pesan');

    function simpan(event) {
        event.preventDefault();

        if (namaDistributor.value === '') {
            namaDistributor.focus();
            swal("Invalid Data", "Nama Distributor harus diisi", "error");
        } else if (telepon.value === '') {
            telepon.focus();
            swal("Invalid Data", "Telepon harus diisi", "error");
        } else if (alamat.value === '') {
            alamat.focus();
            swal("Invalid Data", "Alamat harus diisi", "error");
        } else {
            form.submit();
        }
    }

    function validateTelepon(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length > 15) {
            input.value = input.value.slice(0, 15);
        }
    }

    function tampil_pesan() {
        if (pesan.innerHTML.trim() !== '') {
            swal('Data Duplikat', pesan.innerHTML, 'error');
        }
    }

    btnSave.onclick = function(event) {
        simpan(event);
    };

    window.onload = function() {
        tampil_pesan();
    };
</script>
@endsection