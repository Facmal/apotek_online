<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('distributor', function (Blueprint $table) {
            $table->id();
            $table->string('nama_distributor', 50);
            $table->string('telepon', 15);
            $table->string('alamat', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('distributor');
    }
};
