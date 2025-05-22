@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<div class="site-section py-5 contact-hero" style="background-image: url({{asset('fe/images/jumbotron1.png')}}); background-size: cover; background-position: center; position: relative;">
    <div class="overlay"></div>
    <div class="container position-relative">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h2 class="display-4 text-white font-weight-bold">Hubungi Kami</h2>
                <p class="lead text-white font-weight-bold">Kami Siap Melayani Anda 24/7</p>
                <div class="divider mx-auto my-4" style="width: 100px; height: 3px; background-color: #ffffff;"></div>
            </div>
        </div>
    </div>
</div>

<div class="site-section bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="bg-white p-4 h-100 shadow-sm rounded">
                    <h3 class="text-primary mb-4">Informasi Kontak</h3>
                    <div class="d-flex mb-4">
                        <div class="icon mr-4">
                            <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                        </div>
                        <div class="text">
                            <h5 class="text-dark">Alamat</h5>
                            <p>Jl. Raya Karadenan No.7, Karadenan, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16111</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="icon mr-4">
                            <i class="fas fa-phone fa-2x text-primary"></i>
                        </div>
                        <div class="text">
                            <h5 class="text-dark">Telepon</h5>
                            <p>+62 858 9158 6352</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="icon mr-4">
                            <i class="fas fa-envelope fa-2x text-primary"></i>
                        </div>
                        <div class="text">
                            <h5 class="text-dark">Email</h5>
                            <p>akmalmhank21@gmail</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="icon mr-4">
                            <i class="fas fa-clock fa-2x text-primary"></i>
                        </div>
                        <div class="text">
                            <h5 class="text-dark">Jam Operasional</h5>
                            <p>Senin - Minggu: 24 Jam</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-white p-4 shadow-sm rounded">
                    <h3 class="text-primary mb-4">Kirim Pesan</h3>

                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-hero {
    min-height: 400px;
    display: flex;
    align-items: center;
}
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
}
.position-relative {
    z-index: 1;
}
.icon i {
    width: 40px;
}
</style>

<script>
    const body = document.getElementById('body')

    function tampil_pesan() {
        const pesan = "{{session('pesan')}}"
        const error = "{{session('error')}}"

        if (pesan.trim() !== '') {
            swal('Thank You For Your Message', pesan, 'success')
        }
        if (error.trim() !== '') {
            swal(error, '', 'error')
        }
    }
    // let pesan = document.getElementById('pesan').value

    body.onload = function() {
        tampil_pesan()
    }
</script>
@endsection
@section('footer')
@include('fe.footer')
@endsection