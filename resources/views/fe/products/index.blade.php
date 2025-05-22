@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<div class="site-section">
    <div class="container">

        <div class="row mb-5">
            <div class="col-md-12 order-1">

                <div class="row align">
                    <div class="col-md-12 mb-5">
                        <div class="float-md-left">
                            <h2 class="text-black h5">Shop All</h2>
                        </div>
                        <div class="d-flex">
                            <div class="dropdown mr-1 ml-md-auto">
                                <button type="button" class="btn btn-white btn-sm dropdown-toggle px-4" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $selected_jenis ? $jenis_obat->firstWhere('id', $selected_jenis)->jenis : 'Medicines Type' }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                    <a class="dropdown-item" href="{{ route('products.index') }}">All</a>
                                    @foreach ($jenis_obat as $jenis)
                                    <a class="dropdown-item" href="{{ route('products.index', ['jenis' => $jenis->id]) }}">{{ $jenis->jenis }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-white btn-sm dropdown-toggle px-4" id="dropdownMenuReference" data-toggle="dropdown">
                                    Sort
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                    <a class="dropdown-item" href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name_asc'])) }}">Name, A to Z</a>
                                    <a class="dropdown-item" href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'name_desc'])) }}">Name, Z to A</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_low_high'])) }}">Price, low to high</a>
                                    <a class="dropdown-item" href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_high_low'])) }}">Price, high to low</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-12">
                        @if($search)
                        <p class="text-black">Showing results for: <strong>{{ $search }}</strong></p>
                        @endif
                    </div>
                </div>
                <div class="row mb-5">
                    @foreach ($obats as $obat)
                    <div class="col-lg-4 col-md-4 item-entry mb-4">
                        <a href="{{ route('products.show', $obat->id) }}" class="product-item md-height bg-gray d-block">
                            <img src="{{ $obat->foto1 ? asset('storage/' . $obat->foto1) : 'images/default.png' }}" alt="{{ $obat->nama_obat }}" class="img-fluid">
                        </a>
                        <h2 class="item-title"><a href="{{ route('products.show', $obat->id) }}">{{ $obat->nama_obat }}</a></h2>
                        <strong class="item-price">
                            @if ($obat->harga_jual)
                            Rp {{ number_format($obat->harga_jual) }}
                            @else
                            <span>Price not available</span>
                            @endif
                        </strong>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="site-block-27">
                            @if ($obats->hasPages())
                            <ul>
                                {{-- Previous Page Link --}}
                                <li>
                                    <a href="{{ $obats->previousPageUrl() }}">&lt;</a>
                                </li>

                                {{-- Pagination Elements --}}
                                @for ($i = 1; $i <= $obats->lastPage(); $i++)
                                <li class="{{ ($obats->currentPage() == $i) ? 'active' : '' }}">
                                    @if ($obats->currentPage() == $i)
                                    <span>{{ $i }}</span>
                                    @else
                                    <a href="{{ $obats->url($i) }}">{{ $i }}</a>
                                    @endif
                                </li>
                                @endfor

                                {{-- Next Page Link --}}
                                <li>
                                    <a href="{{ $obats->nextPageUrl() }}">&gt;</a>
                                </li>
                            </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

@endsection
@section('footer')
@include('fe.footer')
@endsection