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
                <h4 class="card-title">Detail Pengiriman</h4>
                <div>
                    @if($data->status_kirim == 'Sedang Dikirim' && Auth::user()->jabatan == 'kurir')
                    <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#completeModal">
                        <i class="mdi mdi-check"></i> Selesai Antar
                    </button>
                    @endif
                    <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Pengiriman</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">No. Invoice</th>
                            <td>: {{ $data->no_invoice }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Kirim</th>
                            <td>: {{ date('d F Y H:i', strtotime($data->tgl_kirim)) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: <span class="badge badge-{{ $data->status_kirim == 'Sedang Dikirim' ? 'warning' : 'success' }}">
                                {{ $data->status_kirim }}</span>
                            </td>
                        </tr>
                        @if($data->tgl_tiba)
                        <tr>
                            <th>Tanggal Tiba</th>
                            <td>: {{ date('d F Y H:i', strtotime($data->tgl_tiba)) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Nama Kurir</th>
                            <td>: {{ $data->nama_kurir }}</td>
                        </tr>
                        <tr>
                            <th>Telepon Kurir</th>
                            <td>: {{ $data->telpon_kurir }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Informasi Penerima</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>: {{ $data->penjualan->pelanggan->nama_pelanggan }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: {{ $data->penjualan->pelanggan->alamat1 }}</td>
                        </tr>
                        <tr>
                            <th>Kota</th>
                            <td>: {{ $data->penjualan->pelanggan->kota1 }}</td>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <td>: {{ $data->penjualan->pelanggan->propinsi1 }}</td>
                        </tr>
                        <tr>
                            <th>Kode Pos</th>
                            <td>: {{ $data->penjualan->pelanggan->kodepos1 }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>: {{ $data->penjualan->pelanggan->no_telp }}</td>
                        </tr>
                    </table>
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
                            @foreach($data->penjualan->detailPenjualan as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->obat->nama_obat }}</td>
                                <td>{{ $detail->jumlah_beli }}</td>
                                <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-right">Ongkos Kirim</td>
                                <td>Rp {{ number_format($data->penjualan->ongkos_kirim, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Biaya Aplikasi</td>
                                <td>Rp {{ number_format($data->penjualan->biaya_app, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Total</strong></td>
                                <td><strong>Rp {{ number_format($data->penjualan->total_bayar, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if($data->bukti_foto)
            <div class="mt-4">
                <h5>Bukti Pengiriman</h5>
                <img src="{{ asset($data->bukti_foto) }}" alt="Bukti Pengiriman" class="img-fluid" style="max-width: 300px">
                @if($data->keterangan)
                <p class="mt-2"><strong>Keterangan:</strong> {{ $data->keterangan }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
@if($data->status_kirim == 'Sedang Dikirim' && Auth::user()->jabatan == 'kurir')
<div class="modal fade" id="completeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pengiriman.updateStatus', $data->id) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="completeForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pengiriman Selesai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Bukti Foto <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="bukti_foto" name="bukti_foto" accept="image/*" capture="camera" required>
                            <label class="custom-file-label" for="bukti_foto">Pilih foto atau gunakan kamera...</label>
                        </div>
                        <small class="form-text text-muted">
                            Anda dapat mengambil foto langsung menggunakan kamera atau memilih foto dari galeri
                        </small>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan jika ada..."></textarea>
                    </div>
                    <div id="preview" class="mt-3 text-center d-none">
                        <img id="imagePreview" src="#" alt="Preview" class="img-fluid" style="max-height: 200px"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Konfirmasi Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@push('scripts')
<script>
document.getElementById('bukti_foto').addEventListener('change', function(e) {
    if (!e.target.files || !e.target.files[0]) return;

    const file = e.target.files[0];
    const label = document.querySelector('.custom-file-label');
    const preview = document.getElementById('preview');
    const imagePreview = document.getElementById('imagePreview');
    
    // Validate file type
    if (!file.type.match('image.*')) {
        alert('File harus berupa gambar');
        e.target.value = '';
        return;
    }

    // Validate file size (max 2MB)
    // if (file.size > 2 * 1024 * 1024) {
    //     alert('Ukuran file maksimal 2MB');
    //     e.target.value = '';
    //     return;
    // }

    // Update label
    label.textContent = file.name;

    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        imagePreview.src = e.target.result;
        preview.classList.remove('d-none');
    }
    reader.readAsDataURL(file);
});

// Add form submit handler
document.getElementById('completeForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('bukti_foto');
    if (!fileInput.files || !fileInput.files[0]) {
        e.preventDefault();
        alert('Silakan pilih foto terlebih dahulu');
    }
});
</script>
@endpush

<style>
.table th {
    font-weight: bold;
}
.badge {
    padding: 8px 12px;
    font-size: 12px;
}
</style>
@endsection