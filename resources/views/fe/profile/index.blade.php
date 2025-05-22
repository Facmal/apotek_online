@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<style>
    /* Reset container styles */
    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    .site-section {
        padding: 2.5em 0;
        background: #f8f9fa;
        width: 100%;
        overflow-x: hidden;
    }

    /* Container untuk form */
    .form-container {
        width: 100%;
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 15px;
        box-sizing: border-box;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        margin: 0;
    }

    .col-12 {
        flex: 0 0 100%;
        max-width: 100%;
        padding: 0;
    }

    form {
        background: #fff;
        padding: 2em;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        width: 100%;
        margin: 0 auto;
        box-sizing: border-box;
    }

    .container h1 {
        color: #333;
        margin-bottom: 1.5em;
        font-weight: 500;
        text-align: center;
    }

    .profile-preview {
        text-align: center;
        margin-bottom: 2em;
        position: relative;
    }

    .profile-preview img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .profile-preview .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .profile-preview:hover .overlay {
        opacity: 1;
    }

    .profile-preview .hidden-input {
        display: none;
    }

    .profile-preview small a {
        color: #51eaea;
        text-decoration: none;
        margin-top: 10px;
        display: inline-block;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .full {
        grid-column: 1 / -1;
    }

    label {
        display: block;
        margin-bottom: 0.5em;
        color: #555;
        font-weight: 500;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 0.75em;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 1em;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #51eaea;
        outline: none;
    }

    .address-group {
        background: #f8f9fa;
        padding: 1.5em;
        border-radius: 8px;
        margin-bottom: 2em;
    }

    .address-group .form-row {
        grid-template-columns: repeat(2, 1fr);
    }

    .address-group h2 {
        grid-column: 1 / -1;
    }

    input[type="file"] {
        background: #f8f9fa;
        padding: 1em;
        border-radius: 5px;
        width: 100%;
        margin-bottom: 1em;
    }

    .actions {
        text-align: center;
        margin-top: 2em;
        padding-top: 1em;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 0.75em 2em;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-cancel {
        background: #f8f9fa;
        color: #666;
        margin-right: 1em;
    }

    .btn-save {
        background: #51eaea;
        color: #fff;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-cancel:hover {
        background: #e9ecef;
    }

    .btn-save:hover {
        background: #3dd8d8;
    }

    /* Modal Styles */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
    }

    .custom-modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border-radius: 10px;
        max-width: 600px;
        position: relative;
    }

    .custom-modal-close {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 28px;
        font-weight: bold;
        color: #666;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .custom-modal-close:hover {
        color: #333;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }

    /* Add to your existing CSS */
    .profile-image-label {
        position: relative;
        cursor: pointer;
        display: inline-block;
        border-radius: 50%;
    }

    .profile-image-label .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .profile-image-label .overlay span {
        color: white;
        font-size: 14px;
        font-weight: 500;
    }

    .profile-image-label:hover .overlay {
        opacity: 1;
    }

    .hidden-input {
        display: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        form {
            padding: 1.5em;
        }

        .btn {
            width: 100%;
            margin: 0.5em 0;
        }

        .custom-modal-content {
            margin: 15% auto;
            width: 90%;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .address-group .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
<div class="site-section">
    <div class="form-container">
        <div class="row">
            <div class="col-12">
                <h1>Edit Profil Pelanggan</h1>
                <form action="{{ route('profile.update', $pelanggan->id) }}" method="post" enctype="multipart/form-data" id="frmProfile">
                    @csrf
                    @method('PUT')

                    <!-- Preview Foto Profil Saat Ini -->
                    <div class="profile-preview">
                        <label for="foto" class="profile-image-label" title="Klik untuk mengganti foto profil">
                            @if(Auth::guard('pelanggan')->user()->foto)
                            <img src="{{ $pelanggan->foto ? asset('storage/' . $pelanggan->foto) : asset('/assets/default-avatar.png') }}"
                                alt="Foto Profil Saat Ini"
                                id="currentProfileImg">
                            @else
                            <span style="display: flex; align-items: center; justify-content: center; height: 100%; font-size: 1rem; color: #888;">No Image</span>
                            @endif
                            <div class="overlay">
                                <span>Ganti Foto</span>
                            </div>
                        </label>
                        <input type="file" id="foto" name="foto" accept="image/*" class="hidden-input">
                    </div>

                    <div class="form-row">
                        <div class="full">
                            <label for="nama">Nama Pelanggan</label>
                            <input type="text" id="nama" name="nama_pelanggan" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required>
                        </div>

                        <div>
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $pelanggan->email) }}" required>
                        </div>

                        <div>
                            <label for="no_telp">No. Telepon</label>
                            <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp', $pelanggan->no_telp) }}" required>
                        </div>

                        <div>
                            <label for="current_password">Kata Sandi Lama</label>
                            <input type="password" id="current_password" name="current_password" placeholder="Masukkan kata sandi lama">
                        </div>

                        <div>
                            <label for="password">Kata Sandi Baru (Opsional)</label>
                            <input type="password" id="password" name="password" placeholder="Kata sandi baru (opsional)">
                        </div>
                    </div>

                    <!-- Address 1 -->
                    <div class="address-group">
                        <h2>Alamat Utama</h2>
                        <div class="form-row">
                            <div class="full">
                                <label for="alamat1">Alamat</label>
                                <input type="text" id="alamat1" name="alamat1" value="{{ old('alamat1', $pelanggan->alamat1) }}">
                            </div>
                            <div>
                                <label for="kota1">Kota</label>
                                <input type="text" id="kota1" name="kota1" value="{{ old('kota1', $pelanggan->kota1) }}">
                            </div>
                            <div>
                                <label for="propinsi1">Provinsi</label>
                                <input type="text" id="propinsi1" name="propinsi1" value="{{ old('propinsi1', $pelanggan->propinsi1) }}">
                            </div>
                            <div>
                                <label for="kodepos1">Kode Pos</label>
                                <input type="text" id="kodepos1" name="kodepos1" value="{{ old('kodepos1', $pelanggan->kodepos1) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Address 2 -->
                    <div class="address-group">
                        <h2>Alamat Alternatif 1</h2>
                        <div class="form-row">
                            <div class="full">
                                <label for="alamat2">Alamat</label>
                                <input type="text" id="alamat2" name="alamat2" value="{{ old('alamat2', $pelanggan->alamat2) }}">
                            </div>
                            <div>
                                <label for="kota2">Kota</label>
                                <input type="text" id="kota2" name="kota2" value="{{ old('kota2', $pelanggan->kota2) }}">
                            </div>
                            <div>
                                <label for="propinsi2">Provinsi</label>
                                <input type="text" id="propinsi2" name="propinsi2" value="{{ old('propinsi2', $pelanggan->propinsi2) }}">
                            </div>
                            <div>
                                <label for="kodepos2">Kode Pos</label>
                                <input type="text" id="kodepos2" name="kodepos2" value="{{ old('kodepos2', $pelanggan->kodepos2) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Address 3 -->
                    <div class="address-group">
                        <h2>Alamat Alternatif 2</h2>
                        <div class="form-row">
                            <div class="full">
                                <label for="alamat3">Alamat</label>
                                <input type="text" id="alamat3" name="alamat3" value="{{ old('alamat3', $pelanggan->alamat3) }}">
                            </div>
                            <div>
                                <label for="kota3">Kota</label>
                                <input type="text" id="kota3" name="kota3" value="{{ old('kota3', $pelanggan->kota3) }}">
                            </div>
                            <div>
                                <label for="propinsi3">Provinsi</label>
                                <input type="text" id="propinsi3" name="propinsi3" value="{{ old('propinsi3', $pelanggan->propinsi3) }}">
                            </div>
                            <div>
                                <label for="kodepos3">Kode Pos</label>
                                <input type="text" id="kodepos3" name="kodepos3" value="{{ old('kodepos3', $pelanggan->kodepos3) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Photo and KTP -->
                    <div class="form-row">

                        <div>
                            <label for="url_ktp">Upload KTP</label>
                            <input type="file" id="url_ktp" name="url_ktp" accept="image/*,application/pdf">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="actions">
                        <button type="reset" class="btn btn-cancel">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Foto -->
<div id="imageModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-modal-close" id="closeModal">&times;</span>
        <img src="{{ $pelanggan->foto ? asset('storage/' . $pelanggan->foto) : asset('/assets/default-avatar.png') }}" alt="Current Image" class="img-fluid" />
    </div>
</div>

<div id="pesan" class="invisible">
    @isset($pesan){{$pesan}}@endisset
    @if ($errors->any())
    {{ implode(', ', $errors->all()) }}
    @endif
</div>


<script>
    // Modal preview foto
    const modal = document.getElementById('imageModal');
    const viewImageLink = document.getElementById('viewImageLink');
    const closeModal = document.getElementById('closeModal');

    if (viewImageLink) {
        viewImageLink.onclick = function(event) {
            event.preventDefault();
            modal.style.display = 'block';
        };
    }

    if (closeModal) {
        closeModal.onclick = function() {
            modal.style.display = 'none';
        };
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    const fotoInput = document.getElementById('foto');
    const currentProfileImg = document.getElementById('currentProfileImg');

    fotoInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                currentProfileImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Form validation
    const btnSave = document.getElementById('btnSimpan');
    const nama = document.getElementById('nama');
    const email = document.getElementById('email');
    const noTelp = document.getElementById('no_telp');
    const password = document.getElementById('password');
    const currentPassword = document.getElementById('current_password');
    const form = document.getElementById('frmProfile');
    const pesan = document.getElementById('pesan');

    function simpan(event) {
        event.preventDefault();

        if (nama.value === '') {
            nama.focus();
            swal("Invalid Data", "Nama harus diisi", "error");
        } else if (email.value === '') {
            email.focus();
            swal("Invalid Data", "Email harus diisi", "error");
        } else if (noTelp.value === '') {
            noTelp.focus();
            swal("Invalid Data", "No. Telepon harus diisi", "error");
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
            swal('Error', pesan.innerHTML, 'error');
        }
    }

    btnSave.onclick = function(event) {
        simpan(event);
    };

    window.onload = function() {
        tampil_pesan();
        @if(session('pesan'))
        swal('Wrong Old Password', '{{ session('
            pesan ') }}', 'error');
        @endif
        @if(session('success'))
        swal('Success', '{{ session('
            success ') }}', 'success');
        @endif
    };
</script>
@endsection
@section('footer')
@include('fe.footer')
@endsection