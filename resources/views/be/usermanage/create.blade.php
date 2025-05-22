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
            <h4 class="card-title">Add New User</h4>
            <p class="card-description">Fill in the form below to add a new user</p>
            <form action="{{ route('usermanage.store') }}" class="forms-sample" name="frmUser" id="frmUser" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" value="{{ old('name') }}" required />
                </div>
                <div class="form-group">
                    <label for="jabatan">Position</label>
                    <select class="form-control" name="jabatan" id="jabatan" required>
                        <option value="" disabled selected>Select Position</option>
                        <option value="admin" {{ old('jabatan') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="apoteker" {{ old('jabatan') == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                        <option value="karyawan" {{ old('jabatan') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                        <option value="kasir" {{ old('jabatan') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="pemilik" {{ old('jabatan') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                        <option value="kurir" {{ old('jabatan') == 'kurir' ? 'selected' : '' }}>Kurir</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="{{ old('email') }}" required />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required />
                </div>
                <div class="form-group">
                    <label for="img_profile">Profile Image</label>
                    <input type="file" name="img_profile" id="img_profile" class="file-upload-default" />
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Profile Image" />
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                </div>

                <button type="submit" id="btnSave" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('usermanage.index') }}" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>

<div id="pesan" class="invisible">
    @isset($pesan){{ $pesan }}@endisset
</div>

<script>
    const btnSave = document.getElementById('btnSave');
    const name = document.getElementById('name');
    const jabatan = document.getElementById('jabatan');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const form = document.getElementById('frmUser');
    const pesan = document.getElementById('pesan');

    function simpan(event) {
        // Prevent the default form submission
        event.preventDefault();

        if (name.value === '') {
            name.focus();
            swal("Invalid Data", "Name must be filled", "error");
        } else if (jabatan.value === '') {
            jabatan.focus();
            swal("Invalid Data", "Position must be selected", "error");
        } else if (email.value === '') {
            email.focus();
            swal("Invalid Data", "Email must be filled", "error");
        } else if (password.value === '') {
            password.focus();
            swal("Invalid Data", "Password must be filled", "error");
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