@extends('fe.master')
@section('navbar')
@include('fe.navbar')
@endsection
@section('content')
<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="site-blocks-table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="product-select">Select</th> <!-- Tambahkan kolom untuk checkbox -->
                                <th class="product-thumbnail">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                                <th class="product-remove">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keranjang as $item)
                            <tr>
                                <td class="product-select">
                                    <input type="checkbox" class="product-checkbox" data-subtotal="{{ $item->subtotal }}" onchange="updateSubtotal()">
                                </td>
                                <td class="product-thumbnail">
                                    <img src="{{ $item->obat->foto1 ? asset('storage/' . $item->obat->foto1) : asset('images/default.png') }}" alt="{{ $item->obat->nama_obat }}" class="img-fluid">
                                </td>
                                <td class="product-name">
                                    <h2 class="h5 text-black">{{ $item->obat->nama_obat }}</h2>
                                </td>
                                <td>Rp {{ number_format($item->harga) }}</td>
                                <td>
                                    <div class="input-group mb-3" style="max-width: 120px;">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-primary" type="button" onclick="updateQuantity(this, -1)">&minus;</button>
                                        </div>
                                        <input type="number" name="jumlah_order" class="form-control text-center quantity-input"
                                            value="{{ $item->jumlah_order }}"
                                            min="1"
                                            max="{{ $item->obat->stok }}"
                                            data-id="{{ $item->id }}"
                                            data-price="{{ $item->harga }}"
                                            onchange="updateSubtotalRow(this)" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary " type="button" onclick="updateQuantity(this, 1)">&plus;</button>
                                        </div>
                                    </div>
                                </td>
                                <td class="subtotal-cell">Rp {{ number_format($item->subtotal) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Your cart is empty.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-outline-primary btn-sm btn-block" onclick="window.location='{{ route('products.index') }}'">Continue Shopping</button>
            </div>
            <div class="col-md-6 text-right">
                <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <span class="text-black">Subtotal</span>
                    </div>
                    <div class="col-md-6 text-right">
                        <strong class="text-black" id="selected-subtotal">Rp 0</strong>
                    </div>
                </div>
                <form id="checkout-form" action="{{ route('checkout') }}" method="GET">
                    <input type="hidden" name="selected_items" id="selected-items">
                    <button type="button" class="btn btn-primary btn-lg btn-block" onclick="submitCheckout()">Proceed To Checkout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('fe.footer')
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateQuantity(button, change) {
        const input = button.closest('.input-group').querySelector('.quantity-input');
        const currentValue = parseInt(input.value);
        const newValue = currentValue + change;

        if (newValue >= parseInt(input.min) && newValue <= parseInt(input.max)) {
            input.value = newValue;
            updateSubtotalRow(input);
        }
    }

    function updateSubtotalRow(input) {
        const row = input.closest('tr');
        const price = parseFloat(input.getAttribute('data-price'));
        const quantity = parseInt(input.value);
        const subtotal = price * quantity;

        // Update subtotal in the row
        const subtotalCell = row.querySelector('.subtotal-cell');
        subtotalCell.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');

        // Update the data-subtotal attribute for the checkbox
        const checkbox = row.querySelector('.product-checkbox');
        checkbox.setAttribute('data-subtotal', subtotal);

        // Send updated data to the server
        const cartItemId = input.getAttribute('data-id');
        updateCartInDatabase(cartItemId, quantity);

        // Update the overall subtotal
        updateSubtotal();
    }

    function updateSubtotal() {
        let checkboxes = document.querySelectorAll('.product-checkbox:checked');
        let subtotal = 0;

        checkboxes.forEach(checkbox => {
            subtotal += parseFloat(checkbox.getAttribute('data-subtotal'));
        });

        document.getElementById('selected-subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    }

    function updateCartInDatabase(cartItemId, quantity) {
        fetch(`/keranjang/update-quantity/${cartItemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    jumlah_order: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Cart updated successfully');
                } else {
                    console.error('Failed to update cart');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function submitCheckout() {
        let checkboxes = document.querySelectorAll('.product-checkbox:checked');
        let selectedItems = [];
        checkboxes.forEach(checkbox => {
            let row = checkbox.closest('tr');
            let input = row.querySelector('.quantity-input');
            selectedItems.push({
                id: input.getAttribute('data-id'),
                qty: input.value
            });
        });

        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Silakan pilih minimal satu produk untuk checkout.'
            });
            return false;
        }

        document.getElementById('selected-items').value = JSON.stringify(selectedItems);
        document.getElementById('checkout-form').submit();
    }
</script>