@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <span class="icon-clock-o display-3 text-warning"></span>
                <h2 class="display-3 text-black">Menunggu Pembayaran</h2>
                <p class="lead mb-5">Pembayaran Anda sedang dalam proses.</p>
                <p>Silahkan selesaikan pembayaran Anda sesuai dengan instruksi pembayaran yang telah diberikan.</p>
                <p>Kami akan memproses pesanan Anda setelah pembayaran berhasil dikonfirmasi.</p>
                <p><a href="{{ route('home') }}" class="btn btn-sm btn-primary">Kembali ke Beranda</a></p>
                <p><a href="{{ route('orders') }}" class="btn btn-sm btn-outline-primary">Lihat Pesanan Saya</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('fe.footer')
@endsection