@extends('be.master')
@section('content')
<section class="vh-100" style="margin-top: 50px;">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                    class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <h2>Sign in</h2>
                <form action="" method="POST">
                    @csrf
                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" value="{{ old('email') }}" name="email" id="form3Example3" class="form-control form-control-lg"
                            placeholder="Enter a valid email address" />
                        <label class="form-label" for="form3Example3">Email address</label>
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-3">
                        <input type="password" id="form3Example4" name="password" class="form-control form-control-lg"
                            placeholder="Enter password" value="{{ old('password') }}" />
                        <label class="form-label" for="form3Example4">Password</label>
                    </div>

                    

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0"></p><a href="/login-pelanggan"
                                class="link-danger">Login as Cutomer</a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

<!-- Tambahkan ini di file login.blade.php -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Tambahkan script untuk SweetAlert -->
@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '{{ session("error") }}',
        confirmButtonText: 'OK'
    });
</script>
@endif

@endsection