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
            <h4 class="card-title">Tambah Jenis Pengiriman</h4>
            <p class="card-description">Form Jenis Pengiriman</p>
            <form action="{{ route('jenispengiriman.store') }}" class="forms-sample" name="frmJenisPengiriman" id="frmJenisPengiriman" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="jenis_kirim">Jenis Kirim</label>
                    <select class="form-control" name="jenis_kirim" id="jenis_kirim">
                        <option value="">Pilih Jenis Kirim</option>
                        <option value="ekonomi" @if(isset($jenis_kirim) && $jenis_kirim=='ekonomi' ) selected @endif>Ekonomi</option>
                        <option value="kargo" @if(isset($jenis_kirim) && $jenis_kirim=='kargo' ) selected @endif>Kargo</option>
                        <option value="regular" @if(isset($jenis_kirim) && $jenis_kirim=='regular' ) selected @endif>Regular</option>
                        <option value="same day" @if(isset($jenis_kirim) && $jenis_kirim=='same day' ) selected @endif>Same Day</option>
                        <option value="standar" @if(isset($jenis_kirim) && $jenis_kirim=='standar' ) selected @endif>Standar</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama_ekspedisi">Nama Ekspedisi</label>
                    <input type="text" class="form-control" name="nama_ekspedisi" id="nama_ekspedisi" placeholder="Nama Ekspedisi" value="@isset($nama_ekspedisi){{$nama_ekspedisi}}@endisset" />
                </div>
                <div class="form-group">
                    <label>Logo Ekspedisi</label>
                    <input type="file" name="logo_ekspedisi" id="logo_ekspedisi" class="file-upload-default" />
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Logo" />
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                        </span>
                    </div>
                </div>
                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('jenispengiriman.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>
<div id="pesan" class="invisible">
    @isset($pesan){{$pesan}}@endisset
</div>

<script>
    const btnSave = document.getElementById('btnSimpan');
    const jenis_kirim = document.getElementById('jenis_kirim');
    const nama_ekspedisi = document.getElementById('nama_ekspedisi');
    const form = document.getElementById('frmJenisPengiriman');
    const pesan = document.getElementById('pesan');

    function simpan(event) {
        event.preventDefault();

        if (jenis_kirim.value === '') {
            jenis_kirim.focus();
            swal("Invalid Data", "Jenis Kirim harus dipilih", "error");
        } else if (nama_ekspedisi.value === '') {
            nama_ekspedisi.focus();
            swal("Invalid Data", "Nama Ekspedisi harus diisi", "error");
        } else {
            form.submit();
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

    body.onload = function() {
        tampil_pesan();
    };
</script>
@endsection