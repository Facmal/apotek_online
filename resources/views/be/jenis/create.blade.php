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
            <h4 class="card-title">Basic form elements</h4>
            <p class="card-description">Basic form elements</p>
            <form action="{{ route('jenis.store') }}" class="forms-sample" name="frmJenis" id="frmJenis" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="jenis">Jenis Obat</label>
                    <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Jenis Obat" value="@isset($jenis){{$jenis}} @endisset" />
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea
                        name="deskripsi_jenis" id="deskripsi_jenis" class="form-control" placeholder="Deskripsi"
                        rows="4">@if (@isset($deskripsi_jenis)){{$deskripsi_jenis}} @endif</textarea>
                </div>
                <div class="form-group">
                    <label>File upload</label>
                    <input type="file" name="image_url" id="image_url" class="file-upload-default" />
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image" />
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                        </span>
                    </div>
                </div>

                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2"> Submit </button>
                <a href="{{ route('jenis.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>
<div id="pesan" class="invisible">
    @isset($pesan){{$pesan}}@endisset
</div>

<script>
    const btnSave = document.getElementById('btnSimpan');
    const jenis = document.getElementById('jenis');
    const deskripsi_jenis = document.getElementById('deskripsi_jenis');
    const form = document.getElementById('frmJenis');
    const pesan = document.getElementById('pesan');

    function simpan(event) {
        // Prevent the default form submission
        event.preventDefault();

        if (jenis.value === '') {
            jenis.focus();
            swal("Invalid Data", "Jenis Obat Must Be Filled", "error");
        } else if (deskripsi_jenis.value === '') {
            deskripsi_jenis.focus();
            swal("Invalid Data", "Deskripsi Must Be filled in", "error");
        } else {
            form.submit(); // Submit the form if validation passes
        }
    }

    function tampil_pesan() {
        if (pesan.innerHTML.trim() !== '') {
            swal('Data Duplication', pesan.innerHTML, 'error');
        }
    }

    // Attach the event listener to the button
    btnSave.onclick = function(event) {
        simpan(event);
    };

    body.onload = function() {
        tampil_pesan();
    };
</script>

@endsection