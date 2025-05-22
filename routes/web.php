<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesiPelangganController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;


// BACK END


Route::middleware(['userAkses:admin'])->group(function () {
    Route::resource('/admin', App\Http\Controllers\AdminController::class);
    Route::resource('/usermanage', App\Http\Controllers\UserManageController::class);
    Route::get('/admin/download-pdf/{role?}', [AdminController::class, 'downloadPDF'])
        ->name('admin.download-pdf');
});

Route::middleware(['userAkses:kasir,karyawan'])->group(function () {
    Route::resource('/metodebayar', App\Http\Controllers\MetodeBayarController::class);
});

Route::middleware(['userAkses:kasir,karyawan,kurir,pemilik'])->group(function () {
    Route::resource('/penjualan', App\Http\Controllers\PenjualanController::class);
    Route::get('/penjualan/{id}/status/{status}', [App\Http\Controllers\PenjualanController::class, 'updateStatus'])
        ->name('penjualan.updateStatus');
    Route::get('/penjualan/{id}/kirim', [App\Http\Controllers\PenjualanController::class, 'kirim'])->name('penjualan.kirim');
    Route::post('/penjualan/{id}/pickup', [App\Http\Controllers\PenjualanController::class, 'pickup'])->name('penjualan.pickup');
    Route::get('/pengiriman', [App\Http\Controllers\PengirimanController::class, 'index'])->name('pengiriman.index');
    Route::get('/pengiriman/{id}', [App\Http\Controllers\PengirimanController::class, 'show'])->name('pengiriman.show');
    Route::put('/pengiriman/{id}/update-status', [App\Http\Controllers\PengirimanController::class, 'updateStatus'])
        ->name('pengiriman.updateStatus');
    Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
});

Route::middleware(['userAkses:kurir'])->group(function () {
    Route::resource('/kurir', App\Http\Controllers\KurirController::class);
    Route::get('/kurir/download-pdf/{status?}', [App\Http\Controllers\KurirController::class, 'downloadPDF'])
        ->name('kurir.download-pdf');
});
Route::middleware(['userAkses:pemilik'])->group(function () {
    Route::resource('/pemilik', App\Http\Controllers\PemilikController::class);
});
Route::middleware(['userAkses:apoteker'])->group(function () {
    Route::resource('/jenis', App\Http\Controllers\JenisController::class);
    Route::resource('/obat', App\Http\Controllers\ObatController::class);
    Route::resource('/pembelian', App\Http\Controllers\PembelianController::class);
    Route::resource('/apoteker', App\Http\Controllers\ApotekerController::class);
    Route::resource('/distributor', App\Http\Controllers\DistributorController::class);
});
Route::middleware(['userAkses:kasir'])->group(function () {
    Route::resource('/kasir', App\Http\Controllers\KasirController::class);
});
Route::middleware(['userAkses:karyawan'])->group(function () {
    Route::resource('/karyawan', App\Http\Controllers\KaryawanController::class);
    Route::prefix('deliverytype')->group(function () {
        Route::get('/', [App\Http\Controllers\JenisPengirimanController::class, 'index'])->name('jenispengiriman.index');
        Route::get('/edit/{id}', [App\Http\Controllers\JenisPengirimanController::class, 'edit'])->name('jenispengiriman.edit');
        Route::get('/create', [App\Http\Controllers\JenisPengirimanController::class, 'create'])->name('jenispengiriman.create');
        Route::post('/store', [App\Http\Controllers\JenisPengirimanController::class, 'store'])->name('jenispengiriman.store');
        Route::delete('/destroy/{id}', [App\Http\Controllers\JenisPengirimanController::class, 'destroy'])->name('jenispengiriman.destroy');
    });
});
Route::get('/login', [SesiController::class, 'index'])->name('auth.login')->middleware('guest');
Route::get('/logout', [SesiController::class, 'logout'])->name('auth.logout');
Route::post('/login', [SesiController::class, 'login'])->middleware('guest');



// FRONT END

Route::middleware(['pelangganAkses'])->group(function () {
    Route::prefix('pesanan')->group(function () {
        Route::get('/', [App\Http\Controllers\PesananController::class, 'index'])->name('pesanan.index');
        Route::put('/{id}/cancel', [App\Http\Controllers\PesananController::class, 'cancel'])->name('pesanan.cancel');
        Route::put('/{id}/complete', [App\Http\Controllers\PesananController::class, 'complete'])
            ->name('pesanan.complete');
    });
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/{id}', [ProfileController::class, 'update'])->name('profile.update');
    });
    Route::prefix('keranjang')->group(function () {
        Route::get('/', [App\Http\Controllers\KeranjangController::class, 'index'])->name('keranjang.index');
        Route::post('/store/{id}', [App\Http\Controllers\KeranjangController::class, 'store'])->name('keranjang.store');
        Route::delete('/{id}', [App\Http\Controllers\KeranjangController::class, 'destroy'])->name('keranjang.destroy');
        Route::put('/update/{id}', [App\Http\Controllers\KeranjangController::class, 'update'])->name('keranjang.update');
        Route::post('/update-quantity/{id}', [App\Http\Controllers\KeranjangController::class, 'updateQuantity'])->name('keranjang.updateQuantity');
    });
    Route::prefix('checkout')->group(function () {
        Route::get('/', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
        Route::post('/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/success', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
        Route::get('/pending', [App\Http\Controllers\CheckoutController::class, 'pending'])->name('checkout.pending');
        Route::get('/failed', [App\Http\Controllers\CheckoutController::class, 'failed'])->name('checkout.failed');
        Route::get('/finish', [App\Http\Controllers\CheckoutController::class, 'finish'])->name('checkout.finish');
        Route::get('/unfinished', [App\Http\Controllers\CheckoutController::class, 'unfinished'])->name('checkout.unfinished');
        Route::get('/error', [App\Http\Controllers\CheckoutController::class, 'error'])->name('checkout.error');
        Route::post('/notification', [CheckoutController::class, 'notification'])->name('checkout.notification');
    });
});
Route::resource('/', App\Http\Controllers\HomeController::class);
Route::resource('/about', App\Http\Controllers\AboutController::class);
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::resource('/products', App\Http\Controllers\ProductsController::class);
Route::get('/products/{id}', [App\Http\Controllers\ProductsController::class, 'show'])->name('products.show');



Route::get('/login-pelanggan', [SesiPelangganController::class, 'index'])
    ->name('auth.loginpelanggan')
    ->middleware('guest:pelanggan');

Route::post('/login-pelanggan', [SesiPelangganController::class, 'login'])
    ->middleware('guest:pelanggan');

Route::post('/register-pelanggan', [SesiPelangganController::class, 'register'])
    ->middleware('guest:pelanggan');

Route::get('/register-pelanggan', function () {
    return redirect()->route('auth.loginpelanggan', ['panel' => 'register']);
})->name('auth.registerpelanggan');

Route::get('/logout-pelanggan', [SesiPelangganController::class, 'logout'])
    ->name('auth.logoutpelanggan');






// Route::middleware(['auth'])->group(function () {
//     Route::resource('/admin', App\Http\Controllers\AdminController::class)->middleware('auth');
//     Route::resource('/jenis', App\Http\Controllers\AdminController::class)->middleware('userAkses:admin,karyawan');
//     Route::resource('/karyawan', App\Http\Controllers\KaryawanController::class)->middleware('userAkses:karyawan');
//     Route::resource('/pemilik', App\Http\Controllers\PemilikController::class)->middleware('userAkses:pemilik');
// });