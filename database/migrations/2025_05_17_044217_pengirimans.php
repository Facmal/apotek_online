<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_kurir');
            $table->string('no_invoice', 255);
            $table->dateTime('tgl_kirim');
            $table->dateTime('tgl_tiba')->nullable();
            $table->enum('status_kirim', ['Sedang Dikirim', 'Tiba Di Tujuan']);
            $table->string('nama_kurir', 30);
            $table->string('telpon_kurir', 15);
            $table->string('bukti_foto', 255)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id')->on('penjualan')->onDelete('cascade');
            $table->foreign('id_kurir')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengiriman');
    }
};
