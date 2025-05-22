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
            <h4 class="card-title">Edit Obat</h4>
            <p class="card-description">Form untuk mengedit data obat</p>
            <form action="{{ route('obat.update', $obat->id) }}" class="forms-sample" name="frmObat" id="frmObat" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" class="form-control" name="nama_obat" id="nama_obat" placeholder="Nama Obat" value="{{ old('nama_obat', $obat->nama_obat) }}" />
                </div>
                <div class="form-group">
                    <label for="id_jenis_obat">Jenis Obat</label>
                    <select class="form-control" name="id_jenis_obat" id="id_jenis_obat">
                        <option value="">Pilih Jenis Obat</option>
                        @foreach ($jenis_obat as $jenis)
                        <option value="{{ $jenis->id }}" {{ $obat->id_jenis_obat == $jenis->id ? 'selected' : '' }}>{{ $jenis->jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" class="form-control" name="harga_jual" id="harga_jual" placeholder="Harga Jual" value="{{ old('harga_jual', $obat->harga_jual) }}" />
                </div>
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" name="stok" id="stok" placeholder="Stok" value="{{ old('stok', $obat->stok) }}" />
                </div>
                <div class="form-group">
                    <label for="deskripsi_obat">Deskripsi</label>
                    <textarea name="deskripsi_obat" id="deskripsi_obat" class="form-control" placeholder="Deskripsi Obat" rows="4">{{ old('deskripsi_obat', $obat->deskripsi_obat) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Foto Obat 1</label>
                    <input type="file" name="foto1" id="foto1" class="file-upload-default" onchange="previewImage(event, 'preview1')" />
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Foto 1" />
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                        </span>
                    </div>
                    @if ($obat->foto1)
                    <div class="mt-3">
                        <img id="preview1" src="{{ asset('storage/' . $obat->foto1) }}" alt="Foto Obat 1" style="width: 100px; height: 100px;" />
                    </div>
                    @else
                    <div class="mt-3">
                        <img id="preview1" src="#" alt="Preview Foto 1" style="width: 100px; height: 100px; display: none;" />
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Foto Obat 2</label>
                    <input type="file" name="foto2" id="foto2" class="file-upload-default" onchange="previewImage(event, 'preview2')" />
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Foto 2" />
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                        </span>
                    </div>
                    @if ($obat->foto2)
                    <div class="mt-3">
                        <img id="preview2" src="{{ asset('storage/' . $obat->foto2) }}" alt="Foto Obat 2" style="width: 100px; height: 100px;" />
                    </div>
                    @else
                    <div class="mt-3">
                        <img id="preview2" src="#" alt="Preview Foto 2" style="width: 100px; height: 100px; display: none;" />
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Foto Obat 3</label>
                    <input type="file" name="foto3" id="foto3" class="file-upload-default" onchange="previewImage(event, 'preview3')" />
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Foto 3" />
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                        </span>
                    </div>
                    @if ($obat->foto3)
                    <div class="mt-3">
                        <img id="preview3" src="{{ asset('storage/' . $obat->foto3) }}" alt="Foto Obat 3" style="width: 100px; height: 100px;" />
                    </div>
                    @else
                    <div class="mt-3">
                        <img id="preview3" src="#" alt="Preview Foto 3" style="width: 100px; height: 100px; display: none;" />
                    </div>
                    @endif
                </div>

                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2">Update</button>
                <a href="{{ route('obat.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
    const btnSave = document.getElementById('btnSimpan');
    const namaObat = document.getElementById('nama_obat');
    const jenisObat = document.getElementById('id_jenis_obat');
    const hargaJual = document.getElementById('harga_jual');
    const stok = document.getElementById('stok');
    const deskripsiObat = document.getElementById('deskripsi_obat');
    const form = document.getElementById('frmObat');

    btnSave.onclick = function(event) {
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
        } else if (deskripsiObat.value === '') {
            deskripsiObat.focus();
            swal("Invalid Data", "Deskripsi harus diisi", "error");
        } else {
            form.submit();
        }
    };

    function previewImage(event, previewId) {
        const preview = document.getElementById(previewId);
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.style.display = 'block';
    }
</script>
@endsection