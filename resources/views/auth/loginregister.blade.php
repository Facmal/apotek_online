@extends('fe.master')

@section('content')
<div class="container" id="container">

    <!-- Form Registrasi -->
    <div class="form-container sign-up-container">
        <form action="{{ route('auth.registerpelanggan') }}" method="POST">
            @csrf
            <h1>Sign Up</h1>
            <span>Create your account with email</span>

            <div class="form-group">
                <label for="nama_pelanggan">Name</label>
                <input type="text" id="nama_pelanggan" name="nama_pelanggan" placeholder="Name" value="{{ old('nama_pelanggan') }}" required />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required />
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required />
            </div>

            <div class="form-group">
                <label for="no_telp">Phone Number</label>
                <input type="text" id="no_telp" name="no_telp" placeholder="Phone Number" value="{{ old('no_telp') }}" required />
            </div>

            <div class="form-group">
                <label for="alamat1">Address</label>
                <input type="text" id="alamat1" name="alamat1" placeholder="Address" value="{{ old('alamat1') }}" required />
            </div>

            <div class="form-group">
                <label for="kota1">City</label>
                <input type="text" id="kota1" name="kota1" placeholder="City" value="{{ old('kota1') }}" required />
            </div>

            <div class="form-group">
                <label for="propinsi1">Province</label>
                <input type="text" id="propinsi1" name="propinsi1" placeholder="Province" value="{{ old('propinsi1') }}" required />
            </div>

            <div class="form-group">
                <label for="kodepos1">Postal Code</label>
                <input type="text" id="kodepos1" name="kodepos1" placeholder="Postal Code" value="{{ old('kodepos1') }}" required />
            </div>

            <button type="submit">Sign Up</button>
        </form>
    </div>

    <!-- Form Login -->
    <div class="form-container sign-in-container">
        <form action="{{ route('auth.loginpelanggan') }}" method="POST">
            @csrf
            <h1>Sign in</h1>
            <span>Enter your account credential</span>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Sign In</button>
            <a style="font-size: 10px;" href="{{ route('auth.login') }}">Sign In as Admin</a>
        </form>
    </div>

    <!-- Overlay -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start your journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

    * {
        box-sizing: border-box;
    }

    body {
        background: #f6f5f7;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: 'Montserrat', sans-serif;
        height: 100vh;
        margin: -20px 0 50px;
    }

    h1 {
        font-weight: bold;
        margin: 0;
    }

    p {
        font-size: 14px;
        font-weight: 100;
        line-height: 20px;
        letter-spacing: 0.5px;
        margin: 20px 0 30px;
    }

    span {
        font-size: 12px;
    }

    a {
        color: #333;
        font-size: 14px;
        text-decoration: none;
        margin: 15px 0;
    }

    button {
        border-radius: 20px;
        border: 1px solid #FF4B2B;
        background-color: #FF4B2B;
        color: #FFFFFF;
        font-size: 14px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
        margin-top: 20px;
    }

    button:active {
        transform: scale(0.95);
    }

    button:focus {
        outline: none;
    }

    button.ghost {
        background-color: transparent;
        border-color: #FFFFFF;
    }

    form {
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 20px 50px;
        height: auto;
        text-align: center;
        overflow-y: auto;
        /* Tambahkan scroll jika konten terlalu panjang */
    }

    .form-group {
        width: 100%;
        margin-bottom: 15px;
        text-align: left;
    }

    .form-group label {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
        font-size: 14px;
        border-radius: 5px;
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
            0 10px 10px rgba(0, 0, 0, 0.22);
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        max-height: 600px;
        /* Batas tinggi maksimum */
        min-height: 480px;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        width: 50%;
        transition: all 0.6s ease-in-out;
        overflow-y: auto;
        /* Tambahkan scroll vertikal */
        padding: 20px;
        /* Tambahkan padding agar lebih rapi */
        box-sizing: border-box;
    }

    .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
    }

    .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {

        0%,
        49.99% {
            opacity: 0;
            z-index: 1;
        }

        50%,
        100% {
            opacity: 1;
            z-index: 5;
        }
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .overlay {
        background: #FF416C;
        background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
        background: linear-gradient(to right, #FF4B2B, #FF416C);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }
</style>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const container = document.getElementById('container');

    // Fungsi untuk membaca parameter query string dari URL
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    // Aktifkan panel berdasarkan parameter query string
    const activePanel = getQueryParam('panel');
    if (activePanel === 'register') {
        container.classList.add("right-panel-active");
    } else {
        container.classList.remove("right-panel-active");
    }

    // Tambahkan event listener untuk tombol Sign In dan Sign Up
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    function tampil_pesan() {
        const pesan = "{{session('pesan')}}"

        if (pesan.trim() !== '') {
            swal('Error', pesan, 'error')
        }
    }
    body.onload = function() {
        tampil_pesan();
    };
</script>
@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: `
            <ul style="text-align: left;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        `,
        confirmButtonText: 'OK'
    });
</script>
@endif

@endsection