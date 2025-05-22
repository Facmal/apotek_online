@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <span class="icon-check_circle display-3 text-success"></span>
                <h2 class="display-3 text-black">Terima Kasih!</h2>
                <p class="lead mb-5">Pembayaran Anda berhasil.</p>
                <p>Pesanan Anda sedang diproses dan akan segera dikirim.</p>
                <p><a href="/" class="btn btn-sm btn-primary">Kembali ke Beranda</a></p>
                <p><a href="{{ route('pesanan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Pesanan Saya</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('fe.footer')
@endsection