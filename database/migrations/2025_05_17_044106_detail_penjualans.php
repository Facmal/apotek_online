<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_obat');
            $table->integer('jumlah_beli');
            $table->decimal('harga_beli', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->foreign('id_penjualan')->references('id')->on('penjualan')->onDelete('cascade');
            $table->foreign('id_obat')->references('id')->on('obat')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
