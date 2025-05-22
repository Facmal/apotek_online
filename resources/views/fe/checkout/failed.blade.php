@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <span class="icon-close display-3 text-danger"></span>
                <h2 class="display-3 text-black">Pembayaran Gagal</h2>
                <p class="lead mb-5">Maaf, pembayaran Anda tidak berhasil diproses.</p>
                <p>Silahkan coba lagi atau gunakan metode pembayaran lain.</p>
                <p><a href="/" class="btn btn-sm btn-primary">Kembali ke Beranda</a></p>
                <p><a href="{{ route('checkout') }}" class="btn btn-sm btn-outline-primary">Coba Lagi</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('fe.footer')
@endsection