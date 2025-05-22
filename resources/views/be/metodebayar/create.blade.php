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
            <h4 class="card-title">Tambah Metode Pembayaran</h4>
            <p class="card-description">Form untuk menambahkan metode pembayaran baru</p>
            <form action="{{ route('metodebayar.store') }}" class="forms-sample" name="frmMetodeBayar" id="frmMetodeBayar" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="metode_pembayaran">Metode Pembayaran</label>
                    <input type="text" class="form-control" name="metode_pembayaran" id="metode_pembayaran" placeholder="Metode Pembayaran" value="{{ old('metode_pembayaran') }}" />
                </div>
                <div class="form-group">
                    <label for="tempat_bayar">Tempat Bayar</label>
                    <input type="text" class="form-control" name="tempat_bayar" id="tempat_bayar" placeholder="Tempat Bayar" value="{{ old('tempat_bayar') }}" />
                </div>
                <div class="form-group">
                    <label for="no_rekening">No Rekening</label>
                    <input type="text" class="form-control" name="no_rekening" id="no_rekening" placeholder="No Rekening" value="{{ old('no_rekening') }}" />
                </div>
                <div class="form-group">
                    <label>Logo</label>
                    <input type="file" name="url_logo" id="url_logo" class="file-upload-default" />
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Logo" />
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                        </span>
                    </div>
                </div>

                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('metodebayar.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>

<div id="pesan" class="alert alert-danger @if(!session('pesan')) invisible @endif">
    {{ session('pesan') }}
</div>

<script>
    const btnSave = document.getElementById('btnSimpan');
    const metodePembayaran = document.getElementById('metode_pembayaran');
    const tempatBayar = document.getElementById('tempat_bayar');
    const noRekening = document.getElementById('no_rekening');
    const form = document.getElementById('frmMetodeBayar');
    const pesan = document.getElementById('pesan');

    function simpan(event) {
        event.preventDefault();

        if (metodePembayaran.value === '') {
            metodePembayaran.focus();
            swal("Invalid Data", "Metode Pembayaran harus diisi", "error");
        } else if (tempatBayar.value === '') {
            tempatBayar.focus();
            swal("Invalid Data", "Tempat Bayar harus diisi", "error");
        } else if (noRekening.value === '') {
            noRekening.focus();
            swal("Invalid Data", "No Rekening harus diisi", "error");
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