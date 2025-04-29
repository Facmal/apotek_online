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
            <h4 class="card-title">Tambah Obat</h4>
            <p class="card-description">Form untuk menambahkan obat baru</p>
            <form action="{{ route('obat.store') }}" class="forms-sample" name="frmObat" id="frmObat" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" class="form-control" name="nama_obat" id="nama_obat" placeholder="Nama Obat" value="{{ old('nama_obat') }}" />
                </div>
                <div class="form-group">
                    <label for="id_jenis_obat">Jenis Obat</label>
                    <select class="form-control" name="id_jenis_obat" id="id_jenis_obat">
                        <option value="">Pilih Jenis Obat</option>
                        @foreach ($jenis_obat as $jenis)
                        <option value="{{ $jenis->id }}">{{ $jenis->jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" class="form-control" name="harga_jual" id="harga_jual" placeholder="Harga Jual" value="{{ old('harga_jual') }}" />
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" name="stok" id="stok" placeholder="Stok" value="{{ old('stok') }}" />
                </div>
                <div class="form-group">
                    <label for="deskripsi_obat">Deskripsi</label>
                    <textarea name="deskripsi_obat" id="deskripsi_obat" class="form-control" placeholder="Deskripsi Obat" rows="4">{{ old('deskripsi_obat') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Foto Obat</label>
                    <input type="file" name="foto1" id="foto1" class="file-upload-default" />
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Foto" />
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                        </span>
                    </div>
                </div>

                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('obat.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>

<div id="pesan" class="alert alert-danger @if(!session('pesan')) invisible @endif">
    {{ session('pesan') }}
</div>

<script>
    const btnSave = document.getElementById('btnSimpan');
    const namaObat = document.getElementById('nama_obat');
    const jenisObat = document.getElementById('id_jenis_obat');
    const hargaJual = document.getElementById('harga_jual');
    const stok = document.getElementById('stok');
    const form = document.getElementById('frmObat');
    const pesan = document.getElementById('pesan');

    function simpan(event) {
        event.preventDefault();

        if (namaObat.value === '') {
            namaObat.focus();
            swal("Invalid Data", "Nama Obat harus diisi", "error");
        } else if (jenisObat.value === '') {
            jenisObat.focus();
            swal("Invalid Data", "Jenis Obat harus dipilih", "error");
        } else if (hargaJual.value === '') {
            hargaJual.focus();
            swal("Invalid Data", "Harga Jual harus diisi", "error");
        } else if (stok.value === '') {
            stok.focus();
            swal("Invalid Data", "Stok harus diisi", "error");
        } else {
            form.submit();
        }
    }

    function tampil_pesan() {
        if (pesan.innerHTML.trim() !== '') {
            swal('Pesan', pesan.innerHTML, 'error');
        }
    }

    btnSave.onclick = function(event) {
        simpan(event);
    };

    body.onload = function() {
        tampil_pesan();
    };
</script>
@endsection