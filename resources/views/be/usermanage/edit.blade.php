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
            <h4 class="card-title">Edit User</h4>
            <p class="card-description">Form untuk mengedit data user</p>
            <form action="{{ route('usermanage.update', $user->id) }}" class="forms-sample" name="frmUser" id="frmUser" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Tambahkan method PUT -->
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nama" value="{{ $user->name }}" required />
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <select class="form-control" name="jabatan" id="jabatan" required>
                        <option value="" disabled>Pilih Jabatan</option>
                        <option value="admin" {{ $user->jabatan == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="apoteker" {{ $user->jabatan == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                        <option value="karyawan" {{ $user->jabatan == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                        <option value="kasir" {{ $user->jabatan == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="pemilik" {{ $user->jabatan == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $user->email }}" required />
                </div>
                <div class="form-group">
                    <label for="current_password">Password Lama</label>
                    <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Masukkan Password Lama" />
                </div>
                <div class="form-group">
                    <label for="password">Password Baru (Opsional)</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password Baru (Opsional)" />
                </div>
                <div class="form-group">
                    <label>Foto Profil</label>
                    <input type="file" name="img_profile" id="img_profile" class="file-upload-default" />
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Foto" />
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                        </span>
                    </div>
                    @if ($user->img_profile)
                    <small>Foto Saat Ini:
                        <a href="#" id="viewImageLink">Lihat</a>
                    </small>
                    @endif
                </div>

                <!-- Custom Modal -->
                <div id="imageModal" class="custom-modal">
                    <div class="custom-modal-content">
                        <span class="custom-modal-close" id="closeModal">&times;</span>
                        <img src="{{ asset('storage/' . $user->img_profile) }}" alt="Current Image" class="img-fluid" />
                    </div>
                </div>

                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2"> Update </button>
                <a href="{{ route('usermanage.index') }}" class="btn btn-light">Cancel</a>
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
        max-height: 80%;
        overflow: auto;
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
        max-height: 400px;
        height: auto;
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
    const name = document.getElementById('name');
    const jabatan = document.getElementById('jabatan');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const currentPassword = document.getElementById('current_password');
    const form = document.getElementById('frmUser');
    const pesan = document.getElementById('pesan');

    function simpan(event) {
        event.preventDefault();

        if (name.value === '') {
            name.focus();
            swal("Invalid Data", "Nama harus diisi", "error");
        } else if (jabatan.value === '') {
            jabatan.focus();
            swal("Invalid Data", "Jabatan harus diisi", "error");
        } else if (email.value === '') {
            email.focus();
            swal("Invalid Data", "Email harus diisi", "error");
        } else if (password.value !== '' && password.value.length < 6) {
            password.focus();
            swal("Invalid Data", "Password minimal 6 karakter", "error");
        } else if (password.value !== '' && currentPassword.value === '') {
            currentPassword.focus();
            swal("Invalid Data", "Password lama harus diisi jika ingin mengubah password", "error");
        } else {
            form.submit();
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

        <?php
        if(session('pesan')){
            echo "swal('Wrong Old Password', '" . session('pesan') . "', 'error');";
        }
        ?>
    };
</script>
@endsection