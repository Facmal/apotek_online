<div class="card mb-4">
    <div class="card-header bg-light">
        <div class="row">
            <div class="col-md-6">
                <strong>Order ID: #{{ $order->id }}</strong>
            </div>
            <div class="col-md-6 text-right">
                @if($order->status_order === 'Dalam Pengiriman' && $order->pengiriman)
                    <span class="badge badge-{{ $order->pengiriman->status_kirim == 'Sedang Dikirim' ? 'warning' : 'success' }}">
                        {{ $order->pengiriman->status_kirim }}
                    </span>
                @else
                    <span class="badge badge-{{ 
                        $order->status_order === 'Selesai' ? 'success' : 
                        ($order->status_order === 'Dibatalkan Pembeli' || $order->status_order === 'Dibatalkan Penjual' ? 'danger' : 
                        ($order->status_order === 'Bermasalah' ? 'danger' : 
                        ($order->status_order === 'Dalam Pengiriman' ? 'primary' : 'warning'))) 
                    }}">
                        {{ $order->status_order }}
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <small class="text-muted">Tanggal Order:</small>
                <div>{{ $order->tgl_penjualan }}</div>
            </div>
            <div class="col-md-6">
                <small class="text-muted">Metode Pembayaran:</small>
                <div>{{ $order->metodeBayar->metode_pembayaran }} - {{ $order->metodeBayar->tempat_bayar }}</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->detailPenjualan as $detail)
                    <tr>
                        <!-- Update the image source in the product listing -->
                        <td>
                            <div class="d-flex align-items-center">
                                @if($detail->obat->foto1)
                                <img src="{{ asset('storage/' . $detail->obat->foto1) }}" alt="{{ $detail->obat->nama_obat }}" 
                                    class="img-thumbnail mr-3" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                <div class="bg-secondary mr-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-image text-white"></i>
                                </div>
                                @endif
                                <div>
                                    <div>{{ $detail->obat->nama_obat }}</div>
                                    <small class="text-muted">{{ $detail->obat->jenis->nama_jenis ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>Rp {{ number_format($detail->harga_beli) }}</td>
                        <td>{{ $detail->jumlah_beli }}</td>
                        <td>Rp {{ number_format($detail->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Ongkos Kirim:</strong></td>
                        <td>Rp {{ number_format($order->ongkos_kirim) }}</td>
                    </tr>
                    @if($order->biaya_app > 0)
                    <tr>
                        <td colspan="3" class="text-right"><strong>Biaya Platform:</strong></td>
                        <td>Rp {{ number_format($order->biaya_app) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td><strong>Rp {{ number_format($order->total_bayar) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <small class="text-muted">Pengiriman:</small>
                <div>{{ $order->jenisPengiriman->nama_ekspedisi }} - {{ $order->jenisPengiriman->jenis_kirim }}</div>
            </div>
            <div class="col-md-6 text-right">
                @if($order->status_order === 'Menunggu Konfirmasi')
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmCancel({{ $order->id }})">
                    Batalkan Pesanan
                </button>
                <form id="cancel-form-{{ $order->id }}" action="{{ route('pesanan.cancel', $order->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('PUT')
                </form>
                @endif
            </div>
        </div>

        <!-- Add delivery details section when order is being shipped -->
        @if($order->status_order === 'Dalam Pengiriman' && $order->pengiriman)
        <div class="mt-3 p-3 bg-light rounded">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#deliveryModal{{ $order->id }}">
                    <i class="fa fa-eye"></i> Lihat Detail
                </button>
            </div>
            
            @if($order->status_order === 'Dalam Pengiriman' && $order->pengiriman && $order->pengiriman->status_kirim === 'Tiba Di Tujuan')
            <div class="d-flex justify-content-between align-items-center mb-2">
                <button type="button" class="btn btn-success btn-sm" onclick="confirmComplete({{ $order->id }})">
                    <i class="fa fa-check"></i> Selesaikan Pesanan
                </button>
            </div>
            <form id="complete-form-{{ $order->id }}" action="{{ route('pesanan.complete', $order->id) }}" method="POST" class="d-none">
                @csrf
                @method('PUT')
            </form>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Delivery Detail Modal -->
@if($order->status_order === 'Dalam Pengiriman' && $order->pengiriman)
<div class="modal fade" id="deliveryModal{{ $order->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengiriman #{{ $order->id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($order->pengiriman)
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informasi Kurir</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="35%">Nama Kurir</th>
                                    <td>: {{ $order->pengiriman->nama_kurir ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td>: {{ $order->pengiriman->telpon_kurir ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>No. Invoice</th>
                                    <td>: {{ $order->pengiriman->no_invoice ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Status Pengiriman</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="35%">Status</th>
                                    <td>
                                        <span class="badge badge-{{ $order->pengiriman->status_kirim == 'Sedang Dikirim' ? 'warning' : 'success' }}">
                                            {{ $order->pengiriman->status_kirim }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Waktu Kirim</th>
                                    <td>: {{ $order->pengiriman->tgl_kirim ? \Carbon\Carbon::parse($order->pengiriman->tgl_kirim)->format('d M Y H:i') : 'N/A' }}</td>
                                </tr>
                                @if($order->pengiriman->tgl_tiba)
                                <tr>
                                    <th>Waktu Tiba</th>
                                    <td>: {{ \Carbon\Carbon::parse($order->pengiriman->tgl_tiba)->format('d M Y H:i') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    @if($order->pengiriman->status_kirim == 'Tiba Di Tujuan')
                        <div class="mt-4">
                            <h6>Bukti Pengiriman</h6>
                            @if($order->pengiriman->bukti_foto)
                                <div class="text-center">
                                    <img src="{{ asset($order->pengiriman->bukti_foto) }}" alt="Bukti Pengiriman" class="img-fluid rounded" style="max-height: 300px">
                                </div>
                            @endif
                            @if($order->pengiriman->keterangan)
                                <div class="mt-3">
                                    <h6>Keterangan:</h6>
                                    <p class="text-muted">{{ $order->pengiriman->keterangan }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <p class="text-muted">Data pengiriman tidak tersedia</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmCancel(orderId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Pesanan akan dibatalkan dan tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, batalkan!',
            cancelButtonText: 'Tidak, kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancel-form-' + orderId).submit();
            }
        });
    }

    function confirmComplete(orderId) {
        Swal.fire({
            title: 'Selesaikan Pesanan?',
            text: "Pastikan pesanan sudah diterima dengan baik",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Selesaikan!',
            cancelButtonText: 'Tidak, Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('complete-form-' + orderId).submit();
            }
        });
    }
</script>

<style>
.table td {
    vertical-align: middle;
}
.img-thumbnail {
    border-radius: 4px;
}
</style>