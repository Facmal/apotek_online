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
            <h4 class="card-title">Tambah Pembelian</h4>
            <p class="card-description">Form untuk menambahkan pembelian baru</p>
            <form action="{{ route('pembelian.store') }}" class="forms-sample" name="frmPembelian" id="frmPembelian" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nonota">Nomor Nota</label>
                    <input type="text" class="form-control" name="nonota" id="nonota" placeholder="Nomor Nota" value="{{ old('nonota') }}" />
                </div>
                <div class="form-group">
                    <label for="tgl_pembelian">Tanggal Pembelian</label>
                    <input type="date" class="form-control" name="tgl_pembelian" id="tgl_pembelian" value="{{ old('tgl_pembelian') }}" />
                </div>
                <div class="form-group">
                    <label for="id_distributor">Distributor</label>
                    <select class="form-control" name="id_distributor" id="id_distributor">
                        <option value="">Pilih Distributor</option>
                        @foreach ($distributors as $distributor)
                        <option value="{{ $distributor->id }}">{{ $distributor->nama_distributor }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="total_bayar">Total Bayar</label>
                    <input type="number" class="form-control" name="total_bayar" id="total_bayar" placeholder="Total Bayar" value="0" readonly />
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h4 class="card-title">Detail Pembelian</h4>
                    <button type="button" id="add-detail" class="btn btn-primary btn-sm">Tambah Detail</button>
                </div>
                <div id="detail-container" style="display: none;">
                    <!-- Detail pembelian akan ditambahkan di sini -->
                </div>

                <button type="submit" id="btnSimpan" class="btn btn-primary mr-2 mt-4">Submit</button>
                <a href="{{ route('pembelian.index') }}" class="btn btn-light mt-4">Cancel</a>
            </form>
        </div>
    </div>
</div>

<div id="pesan" class="alert alert-danger @if(!session('pesan')) invisible @endif">
    {{ session('pesan') }}
</div>

<script>
    let detailIndex = 0;

    document.getElementById('add-detail').addEventListener('click', function() {
        const container = document.getElementById('detail-container');
        container.style.display = 'block'; // Tampilkan container detail jika belum terlihat

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
        updateTotalBayar(); // Update total bayar setelah menambahkan detail baru
    });

    document.getElementById('detail-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-detail')) {
            e.target.parentElement.remove();
            if (document.querySelectorAll('.detail-item').length === 0) {
                document.getElementById('detail-container').style.display = 'none'; // Sembunyikan container jika tidak ada detail
            }
            updateTotalBayar(); // Update total bayar setelah menghapus detail
        }
    });

    document.getElementById('detail-container').addEventListener('input', function(e) {
        if (e.target.classList.contains('jumlah-beli') || e.target.classList.contains('harga-beli')) {
            updateTotalBayar(); // Update total bayar setiap kali jumlah atau harga berubah
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

    const btnSave = document.getElementById('btnSimpan');
    const form = document.getElementById('frmPembelian');
    const pesan = document.getElementById('pesan');

    function simpan(event) {
        event.preventDefault();

        const nonota = document.getElementById('nonota');
        const tglPembelian = document.getElementById('tgl_pembelian');
        const distributor = document.getElementById('id_distributor');
        const totalBayar = document.getElementById('total_bayar');

        if (nonota.value === '') {
            nonota.focus();
            swal("Invalid Data", "Nomor Nota harus diisi", "error");
        } else if (tglPembelian.value === '') {
            tglPembelian.focus();
            swal("Invalid Data", "Tanggal Pembelian harus diisi", "error");
        } else if (distributor.value === '') {
            distributor.focus();
            swal("Invalid Data", "Distributor harus dipilih", "error");
        } else if (totalBayar.value === '' || totalBayar.value === '0') {
            swal("Invalid Data", "Total Bayar tidak boleh kosong atau nol", "error");
        } else {
            form.submit();
        }
    }

    function tampil_pesan() {
        if (pesan.innerHTML.trim() !== '') {
            swal('Pesan', pesan.innerHTML, 'error');
        }
    }

    btnSave.onclick = function(event) {
        simpan(event);
    };

    body.onload = function() {
        tampil_pesan();
    };
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