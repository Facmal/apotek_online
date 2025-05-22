@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Pesanan Saya</h2>

                <!-- Order Status Tabs -->
                <ul class="nav nav-tabs mb-4" id="orderTabs" role="tablist">
                    @php
                    $pendingCount = $pesanan->where('status_order', 'Menunggu Konfirmasi')->count();
                    $processCount = $pesanan->whereIn('status_order', ['Diproses', 'Menunggu Kurir'])->count();
                    $shippingCount = $pesanan->whereIn('status_order', ['Dalam Pengiriman'])->count();
                    $cancelledCount = $pesanan->whereIn('status_order', ['Dibatalkan Pembeli', 'Dibatalkan Penjual'])->count();
                    $problemCount = $pesanan->where('status_order', 'Bermasalah')->count();
                    $completedCount = $pesanan->where('status_order', 'Selesai')->count();
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab">
                            Menunggu Konfirmasi <span class="badge badge-warning">{{ $pendingCount }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="process-tab" data-toggle="tab" href="#process" role="tab">
                            Diproses <span class="badge badge-info">{{ $processCount }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab">
                            Dikirim <span class="badge badge-primary">{{ $shippingCount }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab">
                            Selesai <span class="badge badge-success">{{ $completedCount }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tab">
                            Dibatalkan <span class="badge badge-danger">{{ $cancelledCount }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="problem-tab" data-toggle="tab" href="#problem" role="tab">
                            Bermasalah <span class="badge badge-danger">{{ $problemCount }}</span>
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="orderTabContent">
                    <!-- Menunggu Konfirmasi -->
                    <div class="tab-pane fade show active" id="pending" role="tabpanel">
                        @php
                        $pendingOrders = $pesanan->where('status_order', 'Menunggu Konfirmasi');
                        @endphp
                        @if($pendingOrders->count() > 0)
                        @foreach($pendingOrders as $order)
                        @include('fe.pesanan.order-card', ['order' => $order])
                        @endforeach
                        @else
                        <div class="text-center py-5">
                            <p>Tidak ada pesanan yang menunggu konfirmasi</p>
                        </div>
                        @endif
                    </div>

                    <!-- Diproses -->
                    <div class="tab-pane fade" id="process" role="tabpanel">
                        @php
                        $processOrders = $pesanan->whereIn('status_order', ['Diproses', 'Menunggu Kurir']);
                        @endphp
                        @if($processOrders->count() > 0)
                        @foreach($processOrders as $order)
                        @include('fe.pesanan.order-card', ['order' => $order])
                        @endforeach
                        @else
                        <div class="text-center py-5">
                            <p>Tidak ada pesanan yang sedang diproses</p>
                        </div>
                        @endif
                    </div>

                    <!-- Dikirim -->
                    <div class="tab-pane fade" id="shipping" role="tabpanel">
                        @php
                        $shippingOrders = $pesanan->where('status_order', 'Dalam Pengiriman')
                            ->filter(function($order) {
                                return $order->pengiriman !== null;
                            });
                        @endphp
                        @if($shippingOrders->count() > 0)
                            @foreach($shippingOrders as $order)
                                @include('fe.pesanan.order-card', ['order' => $order])
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <p>Tidak ada pesanan yang sedang dikirim</p>
                            </div>
                        @endif
                    </div>

                    <!-- Dibatalkan -->
                    <div class="tab-pane fade" id="cancelled" role="tabpanel">
                        @php
                        $cancelledOrders = $pesanan->whereIn('status_order', ['Dibatalkan Pembeli', 'Dibatalkan Penjual']);
                        @endphp
                        @if($cancelledOrders->count() > 0)
                        @foreach($cancelledOrders as $order)
                        @include('fe.pesanan.order-card', ['order' => $order])
                        @endforeach
                        @else
                        <div class="text-center py-5">
                            <p>Tidak ada pesanan yang dibatalkan</p>
                        </div>
                        @endif
                    </div>

                    <!-- Bermasalah -->
                    <div class="tab-pane fade" id="problem" role="tabpanel">
                        @php
                        $problemOrders = $pesanan->where('status_order', 'Bermasalah');
                        @endphp
                        @if($problemOrders->count() > 0)
                        @foreach($problemOrders as $order)
                        @include('fe.pesanan.order-card', ['order' => $order])
                        @endforeach
                        @else
                        <div class="text-center py-5">
                            <p>Tidak ada pesanan yang bermasalah</p>
                        </div>
                        @endif
                    </div>

                    <!-- Selesai -->
                    <div class="tab-pane fade" id="completed" role="tabpanel">
                        @php
                        $completedOrders = $pesanan->where('status_order', 'Selesai');
                        @endphp
                        @if($completedOrders->count() > 0)
                        @foreach($completedOrders as $order)
                        @include('fe.pesanan.order-card', ['order' => $order])
                        @endforeach
                        @else
                        <div class="text-center py-5">
                            <p>Tidak ada pesanan yang selesai</p>
                        </div>
                        @endif
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