@extends('be.master')
@section('sidebar')
@include('be.sidebar')
@endsection
@section('navbar')
@include('be.navbar')
@endsection
@section('content')
<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-xl-11">
            <div class="row">
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $waitingCount }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-warning">
                                        <i class="mdi mdi-clock-alert text-warning"></i>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Menunggu Pickup</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $onDeliveryCount }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-info">
                                        <i class="mdi mdi-truck-delivery text-info"></i>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Sedang Diantar</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $deliveredCount }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success">
                                        <i class="mdi mdi-check-circle text-success"></i>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Tiba Di Tujuan</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-xl-11">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-0">Daftar Pengiriman</h4>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('kurir.download-pdf', ['status' => $currentStatus]) }}" 
                                       class="btn btn-danger mr-3">
                                        <i class="mdi mdi-file-pdf"></i> Download PDF
                                    </a>
                                    
                                    <div class="form-group mb-0">
                                        <select class="form-control" id="statusFilter" onchange="this.form.submit()" name="status" form="filterForm">
                                            <option value="all" {{ $currentStatus == 'all' ? 'selected' : '' }}>
                                                Semua Status
                                            </option>
                                            <option value="Sedang Dikirim" {{ $currentStatus == 'Sedang Dikirim' ? 'selected' : '' }}>
                                                Sedang Dikirim
                                            </option>
                                            <option value="Tiba Di Tujuan" {{ $currentStatus == 'Tiba Di Tujuan' ? 'selected' : '' }}>
                                                Tiba Di Tujuan
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <form id="filterForm" action="{{ route('kurir.index') }}" method="GET"></form>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Invoice</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Tanggal Kirim</th>
                                            <th>Tanggal Tiba</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($deliveries as $index => $delivery)
                                        <tr>
                                            <td>{{ $deliveries->firstItem() + $index }}</td>
                                            <td>{{ $delivery->no_invoice }}</td>
                                            <td>{{ $delivery->penjualan->pelanggan->nama_pelanggan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($delivery->tgl_kirim)->format('d M Y H:i') }}</td>
                                            <td>
                                                @if($delivery->tgl_tiba)
                                                    {{ \Carbon\Carbon::parse($delivery->tgl_tiba)->format('d M Y H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $delivery->status_kirim == 'Sedang Dikirim' ? 'info' : 'success' }}">
                                                    {{ $delivery->status_kirim }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('pengiriman.show', $delivery->id) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data pengiriman</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $deliveries->withQueryString()->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-box-warning,
.icon-box-info,
.icon-box-success {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}
.icon-box-warning {
    background: rgba(255, 193, 7, 0.1);
}
.icon-box-info {
    background: rgba(23, 162, 184, 0.1);
}
.icon-box-success {
    background: rgba(40, 167, 69, 0.1);
}
.icon-box-warning i,
.icon-box-info i,
.icon-box-success i {
    font-size: 24px;
}
.grid-margin {
    margin-bottom: 2rem;
}
.card {
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s;
    margin: 1rem 0;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.card-body {
    padding: 2rem;
    overflow: hidden;  /* Ensures negative margin doesn't create horizontal scroll */
}
.container-fluid {
    min-height: auto;
    background-color: #f8f9fa;
}

#statusFilter {
    min-width: 150px;
    height: 38px;
}

.table th {
    white-space: nowrap;
}

.badge {
    padding: 0.5em 1em;
}

.badge-info {
    background-color: #17a2b8;
}

.badge-success {
    background-color: #28a745;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(23, 162, 184, 0.05);
}

.card-title {
    color: #333;
    font-size: 1.25rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
}

.table-responsive {
    margin: 0 -1rem;  /* Negative margin to counteract card padding */
    padding: 0 1rem;
    width: calc(100% + 2rem);
}

.table {
    min-width: 800px;  /* Minimum table width */
    width: 100%;
}

.btn-danger {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-danger i {
    font-size: 18px;
}

@media (min-width: 1200px) {
    .col-xl-11 {
        flex: 0 0 91.666667%;
        max-width: 91.666667%;
    }
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }

    #statusFilter {
        width: 100%;
    }

    .table-responsive {
        margin: 0 -0.5rem;
        padding: 0 0.5rem;
    }

    .d-flex.align-items-center {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-danger {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection