@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<div class="site-blocks-cover" data-aos="fade">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ml-auto order-md-2 align-self-start">
                <div class="site-block-cover-content">
                    <h2 class="sub-title">Find the Best and Most Effective Medicine</h2>
                    <h1>Pharmal</h1>
                    <p><a href="/products" class="btn btn-black rounded-0">Shop Now</a></p>
                </div>
            </div>
            <div class="col-md-6 order-1 align-self-end">
                <img src="{{asset('fe/images/jumbotron1.png')}}" alt="Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="title-section mb-5">
            <h2 class="text-uppercase">Medicine Types</h2>
        </div>
        <div class="row align-items-stretch">
            <div class="col-lg-8">
                @if(isset($jenis_obat[0]))
                <div class="product-item sm-height full-height bg-gray">
                    <a href="{{ url('/products?jenis=' . $jenis_obat[0]->id) }}" class="product-category">
                        {{ $jenis_obat[0]->jenis }} 
                        <span>{{ $jenis_obat[0]->obats->count() }} items</span>
                    </a>
                    <img src="{{ $jenis_obat[0]->image_url ? asset('storage/'.$jenis_obat[0]->image_url) : asset('fe/images/default.png') }}" 
                        alt="{{ $jenis_obat[0]->jenis }}" class="img-fluid">
                </div>
                @endif
            </div>
            <div class="col-lg-4">
                @if(isset($jenis_obat[1]))
                <div class="product-item sm-height bg-gray mb-4">
                    <a href="{{ url('/products?jenis=' . $jenis_obat[1]->id) }}" class="product-category">
                        {{ $jenis_obat[1]->jenis }}
                        <span>{{ $jenis_obat[1]->obats->count() }} items</span>
                    </a>
                    <img src="{{ $jenis_obat[1]->image_url ? asset('storage/'.$jenis_obat[1]->image_url) : asset('fe/images/default.png') }}" 
                        alt="{{ $jenis_obat[1]->jenis }}" class="img-fluid">
                </div>
                @endif

                @if(isset($jenis_obat[2]))
                <div class="product-item sm-height bg-gray">
                    <a href="{{ url('/products?jenis=' . $jenis_obat[2]->id) }}" class="product-category">
                        {{ $jenis_obat[2]->jenis }}
                        <span>{{ $jenis_obat[2]->obats->count() }} items</span>
                    </a>
                    <img src="{{ $jenis_obat[2]->image_url ? asset('storage/'.$jenis_obat[2]->image_url) : asset('fe/images/default.png') }}" 
                        alt="{{ $jenis_obat[2]->jenis }}" class="img-fluid">
                </div>
                @endif
            </div>
        </div>
    </div>
</div>



<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="title-section mb-5 col-12">
                <h2 class="text-uppercase">Products</h2>
            </div>
        </div>
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-4 col-md-6 item-entry mb-4">
                <a href="{{ url('/products/' . $product->id) }}" class="product-item md-height bg-gray d-block">
                    <img src="{{ $product->foto1 ? asset('storage/'.$product->foto1) : asset('fe/images/default.png') }}" 
                         alt="{{ $product->nama_obat }}" class="img-fluid">
                </a>
                <h2 class="item-title"><a href="{{ url('/products/' . $product->id) }}">{{ $product->nama_obat }}</a></h2>
                <strong class="item-price">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</strong>
            </div>
            @endforeach
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ url('/products') }}" class="btn btn-primary px-4 py-2">Show More</a>
            </div>
        </div>
    </div>
</div>

{{-- <div class="site-section">
    <div class="container">
        <div class="row">
            <div class="title-section text-center mb-5 col-12">
                <h2 class="text-uppercase">Most Rated</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 block-3">
                <div class="nonloop-block-3 owl-carousel">
                    <div class="item">
                        <div class="item-entry">
                            <a href="#" class="product-item md-height bg-gray d-block">
                                <img src="{{asset('fe/images/model_1.png')}}" alt="Image" class="img-fluid">
                            </a>
                            <h2 class="item-title"><a href="#">Smooth Cloth</a></h2>
                            <strong class="item-price"><del>$46.00</del> $28.00</strong>
                            <div class="star-rating">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-entry">
                            <a href="#" class="product-item md-height bg-gray d-block">
                                <img src="{{asset('fe/images/prod_3.png')}}" alt="Image" class="img-fluid">
                            </a>
                            <h2 class="item-title"><a href="#">Blue Shoe High Heels</a></h2>
                            <strong class="item-price"><del>$46.00</del> $28.00</strong>

                            <div class="star-rating">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-entry">
                            <a href="#" class="product-item md-height bg-gray d-block">
                                <img src="{{asset('fe/images/model_5.png')}}" alt="Image" class="img-fluid">
                            </a>
                            <h2 class="item-title"><a href="#">Denim Jacket</a></h2>
                            <strong class="item-price"><del>$46.00</del> $28.00</strong>

                            <div class="star-rating">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>

                        </div>
                    </div>
                    <div class="item">
                        <div class="item-entry">
                            <a href="#" class="product-item md-height bg-gray d-block">
                                <img src="{{asset('fe/images/prod_1.png')}}" alt="Image" class="img-fluid">
                            </a>
                            <h2 class="item-title"><a href="#">Leather Green Bag</a></h2>
                            <strong class="item-price"><del>$46.00</del> $28.00</strong>
                            <div class="star-rating">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-entry">
                            <a href="#" class="product-item md-height bg-gray d-block">
                                <img src="{{asset('fe/images/model_7.png')}}" alt="Image" class="img-fluid">
                            </a>
                            <h2 class="item-title"><a href="#">Yellow Jacket</a></h2>
                            <strong class="item-price">$58.00</strong>
                            <div class="star-rating">
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                                <span class="icon-star2 text-warning"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="site-blocks-cover inner-page py-5" data-aos="fade">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ml-auto order-md-2 align-self-start">
                <div class="site-block-cover-content">
                    <h2 class="sub-title">Want to Know More About Us?</h2>
                    <h1>Pharmal</h1>
                    <p><a href="/about" class="btn btn-black rounded-0">About Us</a></p>
                </div>
            </div>
            <div class="col-md-6 order-1 align-self-end">
                <img src="{{asset('fe/images/jumbotron1.png')}}" alt="Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
    const body = document.getElementById('body')

    function tampil_pesan() {
        const pesan = "{{session('pesan')}}"
        const error = "{{session('error')}}"

        if (pesan.trim() !== '') {
            swal('Good Job', pesan, 'success')
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