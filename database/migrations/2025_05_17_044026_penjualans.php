<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_metode_bayar');
            $table->date('tgl_penjualan');
            $table->string('url_resep', 255)->nullable();
            $table->decimal('ongkos_kirim', 10, 2);
            $table->decimal('biaya_app', 10, 2);
            $table->decimal('total_bayar', 10, 2);
            $table->enum('status_order', ['Menunggu Konfirmasi', 'Diproses', 'Menunggu Kurir', 'Dalam Pengiriman', 'Dibatalkan Pembeli', 'Dibatalkan Penjual', 'Bermasalah', 'Selesai']);
            $table->string('keterangan_status', 255)->nullable();
            $table->string('snap_token', 255)->nullable();
            $table->unsignedBigInteger('id_jenis_kirim');
            $table->unsignedBigInteger('id_pelanggan');
            $table->timestamps();

            $table->foreign('id_metode_bayar')->references('id')->on('metode_bayar');
            $table->foreign('id_jenis_kirim')->references('id')->on('jenis_pengiriman');
            $table->foreign('id_pelanggan')->references('id')->on('pelanggan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
};
