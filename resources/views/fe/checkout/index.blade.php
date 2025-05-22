@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="border p-4 rounded" role="alert">
                    Returning customer? <a href="#">Click here</a> to login
                </div>
            </div>
        </div>
        <form id="checkout-form">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-5 mb-md-0">
                    <h2 class="h3 mb-3 text-black">Billing Details</h2>
                    <div class="p-3 p-lg-5 border">
                        <div class="form-group">
                            <label for="address_select" class="text-black">Pilih Alamat <span class="text-danger">*</span></label>
                            <select class="form-control" id="address_select" name="address_id">
                                <option value="1">Alamat Utama</option>
                                @if($pelanggan->alamat2)
                                <option value="2">Alamat 2</option>
                                @endif
                                @if($pelanggan->alamat3)
                                <option value="3">Alamat 3</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="c_country" class="text-black">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="c_country" name="c_country" value="{{ $pelanggan->propinsi1 ?? '' }}" readonly>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="c_fname" class="text-black">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_fname" name="c_fname" value="{{ $pelanggan->nama_pelanggan ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="c_lname" class="text-black">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_lname" name="c_lname" value="{{ $pelanggan->no_telp ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_address" name="c_address" value="{{ $pelanggan->alamat1 ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="c_city" class="text-black">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_city" name="c_city" value="{{ $pelanggan->kota1 ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="c_postal_zip" class="text-black">Postal / Zip <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip" value="{{ $pelanggan->kodepos1 ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <div class="col-md-12">
                                <label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="c_email_address" name="c_email_address" value="{{ $pelanggan->email ?? '' }}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url_resep" class="text-black">Upload Resep (Opsional)</label>
                            <input type="file" class="form-control" id="url_resep" name="url_resep">
                            <small class="text-muted">Format: JPG, JPEG, PNG, PDF. Max: 2MB</small>
                        </div>

                        <div class="form-group">
                            <label for="id_jenis_kirim" class="text-black">Metode Pengiriman <span class="text-danger">*</span></label>
                            <select class="form-control" id="id_jenis_kirim" name="id_jenis_kirim" required>
                                <option value="">Pilih Metode Pengiriman</option>
                                @foreach($jenis_pengiriman as $jp)
                                <option value="{{ $jp->id }}" data-harga="10000">{{ $jp->nama_ekspedisi }} - {{ $jp->jenis_kirim }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h2 class="h3 mb-3 text-black">Your Order</h2>
                            <div class="p-3 p-lg-5 border">
                                <table class="table site-block-order-table mb-5">
                                    <thead>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </thead>
                                    <tbody>
                                        @foreach($keranjang as $key => $item)
                                        <tr>
                                            <td>{{ $item->obat->nama_obat }} <strong class="mx-2">x</strong> {{ $item->jumlah_order }}</td>
                                            <td>Rp {{ number_format($item->subtotal) }}</td>
                                            <input type="hidden" name="keranjang_ids[]" value="{{ $item->id }}">
                                            <input type="hidden" name="keranjang_quantities[]" value="{{ $item->jumlah_order }}">
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                                            <td class="text-black">
                                                Rp <span id="subtotal">{{ number_format($keranjang->sum('subtotal')) }}</span>
                                                <input type="hidden" id="subtotal_value" value="{{ $keranjang->sum('subtotal') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Shipping</strong></td>
                                            <td class="text-black">
                                                Rp <span id="shipping">0</span>
                                                <input type="hidden" name="ongkos_kirim" id="ongkos_kirim" value="0">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                                            <td class="text-black font-weight-bold">
                                                <strong>Rp <span id="total">{{ number_format($keranjang->sum('subtotal')) }}</span></strong>
                                                <input type="hidden" id="total_value" value="{{ $keranjang->sum('subtotal') }}">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="border p-3 mb-3">
                                    <h3 class="h6 mb-0">Metode Pembayaran</h3>

                                    <div class="py-2">
                                        <div class="form-group">
                                            <select class="form-control" id="id_metode_bayar" name="id_metode_bayar" required>
                                                <option value="">Pilih Metode Pembayaran</option>
                                                @foreach($metode_bayar as $mb)
                                                <option value="{{ $mb->id }}">{{ $mb->metode_pembayaran }} - {{ $mb->tempat_bayar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="pay-button">Place Order</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Midtrans Client Key -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    // Data alamat pelanggan dari backend
    const alamatData = {
        1: {
            alamat: @json($pelanggan -> alamat1),
            kota: @json($pelanggan -> kota1),
            propinsi: @json($pelanggan -> propinsi1),
            kodepos: @json($pelanggan -> kodepos1)
        },
        2: {
            alamat: @json($pelanggan -> alamat2),
            kota: @json($pelanggan -> kota2),
            propinsi: @json($pelanggan -> propinsi2),
            kodepos: @json($pelanggan -> kodepos2)
        },
        3: {
            alamat: @json($pelanggan -> alamat3),
            kota: @json($pelanggan -> kota3),
            propinsi: @json($pelanggan -> propinsi3),
            kodepos: @json($pelanggan -> kodepos3)
        }
    };

    // Update address fields when selection changes
    document.getElementById('address_select').addEventListener('change', function() {
        const selected = this.value;
        document.getElementById('c_address').value = alamatData[selected].alamat || '';
        document.getElementById('c_city').value = alamatData[selected].kota || '';
        document.getElementById('c_country').value = alamatData[selected].propinsi || '';
        document.getElementById('c_postal_zip').value = alamatData[selected].kodepos || '';
    });

    // Update shipping cost and total
    document.getElementById('id_jenis_kirim').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const shippingCost = parseFloat(selected.getAttribute('data-harga')) || 0;

        document.getElementById('shipping').textContent = shippingCost.toLocaleString('id-ID');
        document.getElementById('ongkos_kirim').value = shippingCost;

        // Update total
        const subtotal = parseFloat(document.getElementById('subtotal_value').value);
        const total = subtotal + shippingCost;

        document.getElementById('total').textContent = total.toLocaleString('id-ID');
        document.getElementById('total_value').value = total;
    });

    // Handle form submission for Midtrans payment
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add('was-validated');
            return;
        }

        // Disable submit button to prevent multiple submissions
        document.getElementById('pay-button').disabled = true;
        document.getElementById('pay-button').textContent = 'Processing...';

        // Create FormData for file upload support
        const formData = new FormData(this);

        // Process payment via AJAX
        fetch('{{ route("checkout.process") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // Open Midtrans Snap payment page
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = '{{ route("checkout.finish") }}';
                        },
                        onPending: function(result) {
                            window.location.href = '{{ route("checkout.unfinished") }}';
                        },
                        onError: function(result) {
                            // Pass the order ID to the error route
                            window.location.href = '{{ route("checkout.error") }}?order_id=' + data.midtrans_order_id;
                        },
                        onClose: function() {
                            // Also handle snap close as potential error/cancel
                            window.location.href = '{{ route("checkout.error") }}?order_id=' + data.midtrans_order_id;
                            document.getElementById('pay-button').disabled = false;
                            document.getElementById('pay-button').textContent = 'Place Order';
                        }
                    });
                } else {
                    alert('Error: ' + data.message);
                    // Enable the submit button again
                    document.getElementById('pay-button').disabled = false;
                    document.getElementById('pay-button').textContent = 'Place Order';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');

                // Enable the submit button again
                document.getElementById('pay-button').disabled = false;
                document.getElementById('pay-button').textContent = 'Place Order';
            });
    });
</script>
@endsection
@section('footer')
@include('fe.footer')
@endsection