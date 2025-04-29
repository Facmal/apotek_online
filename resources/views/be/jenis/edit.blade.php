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
            <h4 class="card-title">Edit Jenis Obat</h4>
            <p class="card-description">Form untuk mengedit jenis obat</p>
            <form action="{{ route('jenis.update', $jenisObat->id) }}" class="forms-sample" name="frmJenis" id="frmJenis" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Tambahkan method PUT -->
                <div class="form-group">
                    <label for="jenis">Jenis Obat</label>
                    <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Jenis Obat" value="{{ $jenisObat->jenis }}" />
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea
                        name="deskripsi_jenis" id="deskripsi_jenis" class="form-control" placeholder="Deskripsi"
                        rows="4">{{ $jenisObat->deskripsi_jenis }}</textarea>
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
                    @if ($jenisObat->image_url)
                    <small>Current Image:
                        <a href="#" id="viewImageLink">View</a>
                    </small>
                    @endif
                </div>

                <!-- Custom Modal -->
                <div id="imageModal" class="custom-modal">
                    <div class="custom-modal-content">
                        <span class="custom-modal-close" id="closeModal">&times;</span>
                        <img src="{{ asset('storage/' . $jenisObat->image_url) }}" alt="Current Image" class="img-fluid" />
                    </div>
                </div>

                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2"> Update </button>
                <a href="{{ route('jenis.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>
<div id="pesan" class="invisible">
    @isset($pesan){{$pesan}}@endisset
</div>

<style>
    /* Modal Styles */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .custom-modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        max-width: 600px;
        /* Batas maksimal lebar modal */
        max-height: 80%;
        /* Batas maksimal tinggi modal */
        overflow: auto;
        /* Tambahkan scroll jika konten melebihi tinggi */
        text-align: center;
        border-radius: 8px;
    }

    .custom-modal-close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .custom-modal-close:hover,
    .custom-modal-close:focus {
        color: black;
        text-decoration: none;
    }

    .img-fluid {
        max-width: 100%;
        /* Gambar tidak akan melebihi lebar modal */
        max-height: 400px;
        /* Batas maksimal tinggi gambar */
        height: auto;
        /* Menjaga rasio aspek gambar */
    }
</style>

<script>
    // JavaScript to handle modal functionality
    const modal = document.getElementById('imageModal');
    const viewImageLink = document.getElementById('viewImageLink');
    const closeModal = document.getElementById('closeModal');

    // Open modal when "View" is clicked
    viewImageLink.onclick = function(event) {
        event.preventDefault();
        modal.style.display = 'block';
    };

    // Close modal when "x" is clicked
    closeModal.onclick = function() {
        modal.style.display = 'none';
    };

    // Close modal when clicking outside the modal content
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

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

    window.onload = function() {
        tampil_pesan();
    };
</script>

@endsection