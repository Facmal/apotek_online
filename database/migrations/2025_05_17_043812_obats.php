<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat', 100);
            $table->unsignedBigInteger('id_jenis_obat');
            $table->integer('harga_jual');
            $table->text('deskripsi_obat')->nullable();
            $table->string('foto1', 255)->nullable();
            $table->string('foto2', 255)->nullable();
            $table->string('foto3', 255)->nullable();
            $table->integer('stok');
            $table->timestamps();

            $table->foreign('id_jenis_obat')->references('id')->on('jenis_obat')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('obat');
    }
};
