<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jenis_obat', function (Blueprint $table) {
            $table->id();
            $table->string('jenis', 50);
            $table->text('deskripsi_jenis')->nullable();
            $table->string('image_url', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_obat');
    }
};
