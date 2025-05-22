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
            <h4 class="card-title">Tambah Distributor</h4>
            <p class="card-description">Form untuk menambahkan distributor baru</p>
            <form action="{{ route('distributor.store') }}" class="forms-sample" name="frmDistributor" id="frmDistributor" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_distributor">Nama Distributor</label>
                    <input type="text" class="form-control" name="nama_distributor" id="nama_distributor" placeholder="Nama Distributor" value="{{ old('nama_distributor') }}" />
                </div>
                <div class="form-group">
                    <label for="telepon">Telepon</label>
                    <input type="text" class="form-control" name="telepon" id="telepon" placeholder="Telepon"
                        value="{{ old('telepon') }}" maxlength="15" oninput="validateTelepon(this)" />
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" rows="4">{{ old('alamat') }}</textarea>
                </div>

                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2">Submit</button>
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
        // Prevent the default form submission
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
            form.submit(); // Submit the form if validation passes
        }
    }

    function validateTelepon(input) {
        // Hapus karakter non-angka
        input.value = input.value.replace(/[^0-9]/g, '');

        // Batasi panjang input hingga 15 angka
        if (input.value.length > 15) {
            input.value = input.value.slice(0, 15);
        }
    }

    function tampil_pesan() {
        if (pesan.innerHTML.trim() !== '') {
            swal('Data Duplikat', pesan.innerHTML, 'error');
        }
    }

    // Attach the event listener to the button
    btnSave.onclick = function(event) {
        simpan(event);
    };

    document.body.onload = function() {
        tampil_pesan();
    };
</script>
@endsection