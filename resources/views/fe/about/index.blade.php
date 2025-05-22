@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<div class="site-section py-5 about-hero" style="background-image: url({{asset('fe/images/jumbotron1.png')}}); background-size: cover; background-position: center; position: relative;">
    <div class="overlay"></div>
    <div class="container position-relative">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h2 class="display-4 text-white font-weight-bold">Tentang Kami</h2>
                <p class="lead text-white font-weight-bold">Apotek Terpercaya dengan Produk Berkualitas</p>
                <div class="divider mx-auto my-4" style="width: 100px; height: 3px; background-color: #ffffff;"></div>
            </div>
        </div>
    </div>
</div>

<div class="site-section bg-light py-5">
    <div class="container">
        {{-- <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h2 class="display-4 text-primary font-weight-bold">Tentang Kami</h2>
                <p class="lead text-dark font-weight-bold">Apotek Terpercaya dengan Produk Berkualitas</p>
                <div class="divider mx-auto my-4" style="width: 100px; height: 3px; background-color: #007bff;"></div>
            </div>
        </div> --}}
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="bg-white p-4 shadow-sm rounded">
                    <p class="mb-4 lead text-dark">Selamat datang di Apotek kami, destinasi terpercaya untuk semua kebutuhan obat-obatan Anda. Kami berkomitmen untuk menyediakan produk farmasi berkualitas tinggi dengan harga yang terjangkau untuk seluruh masyarakat Indonesia.</p>
                    
                    <h3 class="text-primary mb-4">Keunggulan Apotek kami:</h3>
                    <ul class="list-unstyled mb-5">
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-success mr-3 fa-2x"></i>
                            <span class="h5 mb-0">Produk 100% Original dan Bersertifikat BPOM</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-success mr-3 fa-2x"></i>
                            <span class="h5 mb-0">Harga Termurah Se-Indonesia dengan Kualitas Terjamin</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-success mr-3 fa-2x"></i>
                            <span class="h5 mb-0">Konsultasi Gratis dengan Apoteker Berpengalaman</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="fas fa-check-circle text-success mr-3 fa-2x"></i>
                            <span class="h5 mb-0">Pengiriman Cepat ke Seluruh Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="bg-white p-4 h-100 shadow-sm rounded hover-shadow transition">
                    <div class="icon mb-4 text-center">
                        <i class="fas fa-shield-alt fa-3x text-primary"></i>
                    </div>
                    <div class="text text-center">
                        <h3 class="text-uppercase text-primary mb-3">Produk Terjamin</h3>
                        <p class="text-dark">Kami menjamin keaslian dan kualitas setiap produk yang kami jual. Semua obat-obatan telah terdaftar di BPOM dan disimpan sesuai standar farmasi.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="bg-white p-4 h-100 shadow-sm rounded hover-shadow transition">
                    <div class="icon mb-4 text-center">
                        <i class="fas fa-dollar-sign fa-3x text-primary"></i>
                    </div>
                    <div class="text text-center">
                        <h3 class="text-uppercase text-primary mb-3">Harga Terbaik</h3>
                        <p class="text-dark">Kami menawarkan harga termurah untuk setiap produk dengan tetap menjaga kualitas. Dapatkan juga berbagai promo menarik setiap bulannya.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="bg-white p-4 h-100 shadow-sm rounded hover-shadow transition">
                    <div class="icon mb-4 text-center">
                        <i class="fas fa-headset fa-3x text-primary"></i>
                    </div>
                    <div class="text text-center">
                        <h3 class="text-uppercase text-primary mb-3">Layanan 24/7</h3>
                        <p class="text-dark">Tim customer service kami siap membantu Anda 24 jam setiap hari. Konsultasikan kebutuhan Anda dengan apoteker profesional kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.transition {
    transition: all .3s ease;
}
.about-hero {
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
</style>
@endsection
@section('footer')
@include('fe.footer')
@endsection