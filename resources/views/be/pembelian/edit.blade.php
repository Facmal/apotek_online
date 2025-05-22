
@extends('be.master')
@section('sidebar')
@include('be.sidebar')
@endsection
@section('navbar')
@include('be.navbar')
@endsection
@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Pembelian</h4>
            <p class="card-description">Form untuk mengedit data pembelian</p>
            <form action="{{ route('pembelian.update', $pembelian->id) }}" class="forms-sample" name="frmPembelian" id="frmPembelian" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nonota">Nomor Nota</label>
                    <input type="text" class="form-control" name="nonota" id="nonota" placeholder="Nomor Nota" value="{{ old('nonota', $pembelian->nonota) }}" />
                </div>
                <div class="form-group">
                    <label for="tgl_pembelian">Tanggal Pembelian</label>
                    <input type="date" class="form-control" name="tgl_pembelian" id="tgl_pembelian" value="{{ old('tgl_pembelian', $pembelian->tgl_pembelian) }}" />
                </div>
                <div class="form-group">
                    <label for="id_distributor">Distributor</label>
                    <select class="form-control" name="id_distributor" id="id_distributor">
                        <option value="">Pilih Distributor</option>
                        @foreach ($distributors as $distributor)
                        <option value="{{ $distributor->id }}" {{ $pembelian->id_distributor == $distributor->id ? 'selected' : '' }}>{{ $distributor->nama_distributor }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="total_bayar">Total Bayar</label>
                    <input type="number" class="form-control" name="total_bayar" id="total_bayar" placeholder="Total Bayar" value="{{ old('total_bayar', $pembelian->total_bayar) }}" readonly />
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h4 class="card-title">Detail Pembelian</h4>
                    <button type="button" id="add-detail" class="btn btn-primary btn-sm">Tambah Detail</button>
                </div>
                <div id="detail-container">
                    @foreach ($pembelian->detailPembelians as $index => $detail)
                    <div class="detail-item">
                        <div class="form-group">
                            <label for="details[{{ $index }}][id_obat]">Obat</label>
                            <select class="form-control" name="details[{{ $index }}][id_obat]" id="details[{{ $index }}][id_obat]">
                                <option value="">Pilih Obat</option>
                                @foreach ($obats as $obat)
                                <option value="{{ $obat->id }}" {{ $detail->id_obat == $obat->id ? 'selected' : '' }}>{{ $obat->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="details[{{ $index }}][jumlah_beli]">Jumlah Beli</label>
                            <input type="number" class="form-control jumlah-beli" name="details[{{ $index }}][jumlah_beli]" id="details[{{ $index }}][jumlah_beli]" placeholder="Jumlah Beli" value="{{ old('details.' . $index . '.jumlah_beli', $detail->jumlah_beli) }}" />
                        </div>
                        <div class="form-group">
                            <label for="details[{{ $index }}][harga_beli]">Harga Beli</label>
                            <input type="number" class="form-control harga-beli" name="details[{{ $index }}][harga_beli]" id="details[{{ $index }}][harga_beli]" placeholder="Harga Beli" value="{{ old('details.' . $index . '.harga_beli', $detail->harga_beli) }}" />
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-detail">Hapus</button>
                    </div>
                    @endforeach
                </div>

                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2 mt-4">Update</button>
                <a href="{{ route('pembelian.index') }}" class="btn btn-light mt-4">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
    let detailIndex = {{ $pembelian->detailPembelians->count() }};

    document.getElementById('add-detail').addEventListener('click', function() {
        const container = document.getElementById('detail-container');

        const newDetail = document.createElement('div');
        newDetail.classList.add('detail-item');
        newDetail.innerHTML = `
            <div class="form-group">
                <label for="details[${detailIndex}][id_obat]">Obat</label>
                <select class="form-control" name="details[${detailIndex}][id_obat]" id="details[${detailIndex}][id_obat]">
                    <option value="">Pilih Obat</option>
                    @foreach ($obats as $obat)
                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="details[${detailIndex}][jumlah_beli]">Jumlah Beli</label>
                <input type="number" class="form-control jumlah-beli" name="details[${detailIndex}][jumlah_beli]" id="details[${detailIndex}][jumlah_beli]" placeholder="Jumlah Beli" />
            </div>
            <div class="form-group">
                <label for="details[${detailIndex}][harga_beli]">Harga Beli</label>
                <input type="number" class="form-control harga-beli" name="details[${detailIndex}][harga_beli]" id="details[${detailIndex}][harga_beli]" placeholder="Harga Beli" />
            </div>
            <button type="button" class="btn btn-danger btn-sm remove-detail">Hapus</button>
        `;
        container.appendChild(newDetail);
        detailIndex++;
        updateTotalBayar();
    });

    document.getElementById('detail-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-detail')) {
            e.target.parentElement.remove();
            updateTotalBayar();
        }
    });

    document.getElementById('detail-container').addEventListener('input', function(e) {
        if (e.target.classList.contains('jumlah-beli') || e.target.classList.contains('harga-beli')) {
            updateTotalBayar();
        }
    });

    function updateTotalBayar() {
        let totalBayar = 0;
        document.querySelectorAll('.detail-item').forEach(function(item) {
            const jumlahBeli = parseFloat(item.querySelector('.jumlah-beli').value) || 0;
            const hargaBeli = parseFloat(item.querySelector('.harga-beli').value) || 0;
            totalBayar += jumlahBeli * hargaBeli;
        });
        document.getElementById('total_bayar').value = totalBayar;
    }
</script>

<style>
    .detail-item {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
    }
</style>
@endsection