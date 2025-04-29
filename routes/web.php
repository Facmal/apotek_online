<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Route::resource('/admin', App\Http\Controllers\AdminController::class);
// Route::resource('/jenis', App\Http\Controllers\JenisController::class);
// Route::resource('/obat', App\Http\Controllers\ObatController::class);
// Route::resource('/karyawan', App\Http\Controllers\KaryawanController::class);
// Route::resource('/pemilik', App\Http\Controllers\PemilikController::class);
// Route::resource('/apoteker', App\Http\Controllers\ApotekerController::class);
// Route::resource('/kasir', App\Http\Controllers\KasirController::class);


Route::middleware(['userAkses:admin'])->group(function () {
    Route::resource('/admin', App\Http\Controllers\AdminController::class);
});

Route::middleware(['userAkses:admin,karyawan'])->group(function () {
    Route::resource('/jenis', App\Http\Controllers\JenisController::class);
    Route::resource('/obat', App\Http\Controllers\ObatController::class);
    Route::resource('/karyawan', App\Http\Controllers\KaryawanController::class);
});

Route::middleware(['userAkses:admin,pemilik'])->group(function () {
    Route::resource('/pemilik', App\Http\Controllers\PemilikController::class);
});
Route::middleware(['userAkses:admin,apoteker'])->group(function () {
    Route::resource('/apoteker', App\Http\Controllers\ApotekerController::class);
});
Route::middleware(['userAkses:admin,kasir'])->group(function () {
    Route::resource('/kasir', App\Http\Controllers\KasirController::class);
});
Route::get('/login', [SesiController::class, 'index'])->name('auth.login')->middleware('guest');
Route::get('/logout', [SesiController::class, 'logout'])->name('auth.logout');
Route::post('/login', [SesiController::class, 'login'])->middleware('guest');

// Route::middleware(['auth'])->group(function () {
//     Route::resource('/admin', App\Http\Controllers\AdminController::class)->middleware('auth');
//     Route::resource('/jenis', App\Http\Controllers\AdminController::class)->middleware('userAkses:admin,karyawan');
//     Route::resource('/karyawan', App\Http\Controllers\KaryawanController::class)->middleware('userAkses:karyawan');
//     Route::resource('/pemilik', App\Http\Controllers\PemilikController::class)->middleware('userAkses:pemilik');
// });