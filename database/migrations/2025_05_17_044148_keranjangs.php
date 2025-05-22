<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedBigInteger('id_obat');
            $table->integer('jumlah_order');
            $table->decimal('harga', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('id_obat')->references('id')->on('obat')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('keranjang');
    }
};
