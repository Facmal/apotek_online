<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('nonota', 100);
            $table->date('tgl_pembelian');
            $table->decimal('total_bayar', 10, 2);
            $table->unsignedBigInteger('id_distributor');
            $table->timestamps();

            $table->foreign('id_distributor')->references('id')->on('distributor')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
};
