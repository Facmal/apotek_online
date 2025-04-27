<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('/admin', App\Http\Controllers\AdminController::class);
Route::resource('/jenis', App\Http\Controllers\JenisController::class);