@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="item-entry">
                    <div id="productCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img width="100%" src="{{ $obat->foto1 ? asset('storage/' . $obat->foto1) : 'images/default.png' }}" alt="{{ $obat->nama_obat }}" class="img-fluid">
                            </div>
                            @if($obat->foto2)
                            <div class="carousel-item">
                                <img width="100%" src="{{ asset('storage/' . $obat->foto2) }}" alt="{{ $obat->nama_obat }}" class="img-fluid">
                            </div>
                            @endif
                            @if($obat->foto3)
                            <div class="carousel-item">
                                <img width="100%" src="{{ asset('storage/' . $obat->foto3) }}" alt="{{ $obat->nama_obat }}" class="img-fluid">
                            </div>
                            @endif
                        </div>
                        <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-black">{{ $obat->nama_obat }}</h2>
                <p>{{ $obat->deskripsi_obat }}</p>
                <p><strong class="text-primary h4">Rp {{ number_format($obat->harga_jual) }}</strong></p>
                <p><strong>Stok:</strong> {{ $obat->stok > 0 ? $obat->stok . ' tersedia' : 'Stok habis' }}</p>
                
                <p>
                    @if(auth('pelanggan')->check())
                <form action="{{ route('keranjang.store', ['id' => $obat->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    <div class="input-group mb-3" style="max-width: 120px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                        </div>
                        <input type="number" name="jumlah_order" class="form-control text-center" value="1" min="1" max="{{ $obat->stok }}" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                        </div>
                    </div>
                    <button type="submit" class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary">Add To Cart</button>
                </form>
                @else
                <button class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary" id="btn-add-to-cart">Add To Cart</button>
                @endif
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('btn-add-to-cart').addEventListener('click', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Login Required',
            text: 'You must log in as a customer to add items to the cart.',
            confirmButtonText: 'Login Now',
            showCancelButton: true,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('auth.loginpelanggan') }}";
            }
        });
    });
</script>
@endsection
@section('footer')
@include('fe.footer')
@endsection