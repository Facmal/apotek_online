@extends('be.master')
@section('sidebar')
@include('be.sidebar')
@endsection
@section('navbar')
@include('be.navbar')
@endsection
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title mb-0">Detail Penjualan</h4>
                <div>
                    @if($penjualan->status_order == 'Menunggu Konfirmasi' && Auth::user()->jabatan == 'kasir')
                    <a href="{{ route('penjualan.updateStatus', ['id' => $penjualan->id, 'status' => 'Diproses']) }}" 
                       class="btn btn-success mr-2"
                       onclick="return confirm('Konfirmasi pesanan ini?')">
                        <i class="mdi mdi-check"></i> Konfirmasi
                    </a>
                    <a href="{{ route('penjualan.updateStatus', ['id' => $penjualan->id, 'status' => 'Dibatalkan Penjual']) }}"
                       class="btn btn-danger mr-2"
                       onclick="return confirm('Tolak pesanan ini?')">
                        <i class="mdi mdi-close"></i> Tolak
                    </a>
                    @endif
                    @if($penjualan->status_order == 'Diproses' && Auth::user()->jabatan == 'karyawan')
                    <a href="{{ route('penjualan.kirim', $penjualan->id) }}" 
                       class="btn btn-primary mr-2" 
                       onclick="return confirm('Yakin ingin mengirim pesanan ini?')">
                        <i class="mdi mdi-truck"></i> Kirim
                    </a>
                    @endif
                    @if($penjualan->status_order == 'Menunggu Kurir' && Auth::user()->jabatan == 'kurir')
                    <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#pickupModal">
                        <i class="mdi mdi-package-up"></i> Ambil Pesanan
                    </button>
                    @endif
                    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">ID Penjualan</th>
                                <td>: #{{ $penjualan->id }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Penjualan</th>
                                <td>: {{ date('d F Y', strtotime($penjualan->tgl_penjualan)) }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pelanggan</th>
                                <td>: {{ $penjualan->pelanggan->nama_pelanggan }}</td>
                            </tr>
                            <tr>
                                <th>Status Order</th>
                                <td>: <span class="badge badge-{{ 
                                    $penjualan->status_order == 'Menunggu Konfirmasi' ? 'warning' : 
                                    ($penjualan->status_order == 'Diproses' ? 'info' :
                                    ($penjualan->status_order == 'Menunggu Kurir' ? 'primary' :
                                    ($penjualan->status_order == 'Selesai' ? 'success' : 'danger'))) 
                                }}">
                                    {{ $penjualan->status_order }}
                                </span></td>
                            </tr>
                            @if($penjualan->keterangan_status)
                            <tr>
                                <th>Keterangan Status</th>
                                <td>: {{ $penjualan->keterangan_status }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Alamat</th>
                                <td>: {{ $penjualan->pelanggan->alamat1 }}</td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td>: {{ $penjualan->pelanggan->kota1 }}</td>
                            </tr>
                            <tr>
                                <th>Provinsi</th>
                                <td>: {{ $penjualan->pelanggan->propinsi1 }}</td>
                            </tr>
                            <tr>
                                <th>Kode Pos</th>
                                <td>: {{ $penjualan->pelanggan->kodepos1 }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>: {{ $penjualan->pelanggan->no_telp }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Metode Bayar</th>
                                <td>: {{ $penjualan->metodeBayar->nama_metode }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Pengiriman</th>
                                <td>: {{ $penjualan->jenisPengiriman->jenis_pengiriman }}</td>
                            </tr>
                            <tr>
                                <th>Ongkos Kirim</th>
                                <td>: Rp {{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Biaya App</th>
                                <td>: Rp {{ number_format($penjualan->biaya_app, 0, ',', '.') }}</td>
                            </tr>
                            @if($penjualan->url_resep)
                            <tr>
                                <th>Resep</th>
                                <td>: <a href="#" data-toggle="modal" data-target="#resepModal">Lihat Resep</a></td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h5>Detail Obat</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan->detailPenjualan as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->obat->nama_obat }}</td>
                                <td>{{ $detail->jumlah_beli }}</td>
                                <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-right"><strong>Subtotal Obat</strong></td>
                                <td><strong>Rp {{ number_format($penjualan->detailPenjualan->sum('subtotal'), 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Ongkos Kirim</td>
                                <td>Rp {{ number_format($penjualan->ongkos_kirim, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Biaya Aplikasi</td>
                                <td>Rp {{ number_format($penjualan->biaya_app, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Total Bayar</strong></td>
                                <td><strong>Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->jabatan == 'kurir')
<div class="modal fade" id="pickupModal" tabindex="-1" role="dialog" aria-labelledby="pickupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('penjualan.pickup', $penjualan->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="pickupModalLabel">Ambil Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="telpon_kurir">Nomor Telepon Kurir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="telpon_kurir" name="telpon_kurir" required 
                            pattern="[0-9]+" maxlength="15" placeholder="Masukkan nomor telepon">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Konfirmasi Pengambilan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if($penjualan->url_resep)
<div class="modal fade" id="resepModal" tabindex="-1" role="dialog" aria-labelledby="resepModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resepModalLabel">Resep #{{ $penjualan->id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('storage/' .$penjualan->url_resep)}}" alt="Resep" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a href="{{asset('storage/' .$penjualan->url_resep)}}" target="_blank" class="btn btn-primary">
                    Buka di Tab Baru
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<style>
.table th {
    font-weight: bold;
}
.badge {
    padding: 8px 12px;
    font-size: 12px;
}
#resepModal .modal-body img {
    max-width: 100%;
    height: auto;
    max-height: 80vh;
}
</style>
@endsection