<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_obat', function (Blueprint $table) {
            $table->id();
            $table->string('jenis', 50);
            $table->string('deskripsi_jenis', 255)->nullable();
            $table->string('image_url', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat', 100);
            $table->foreignId('id_jenis_obat')->constrained('jenis_obat')->onDelete('cascade');
            $table->integer('harga_jual');
            $table->text('deskripsi_obat')->nullable();
            $table->string('foto1', 255)->nullable();
            $table->string('foto2', 255)->nullable();
            $table->string('foto3', 255)->nullable();
            $table->integer('stok');
            $table->timestamps();
        });

        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjualan')->constrained('penjualan')->onDelete('cascade');
            $table->foreignId('id_obat')->constrained('obat')->onDelete('cascade');
            $table->integer('jumlah_beli');
            $table->decimal('harga_beli', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        Schema::create('keranjang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelanggan')->constrained('pelanggan')->onDelete('cascade');
            $table->foreignId('id_obat')->constrained('obat')->onDelete('cascade');
            $table->integer('jumlah_order');
            $table->decimal('harga', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        Schema::create('distributor', function (Blueprint $table) {
            $table->id();
            $table->string('nama_distributor', 50);
            $table->string('telepon', 15)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('nonota', 100);
            $table->date('tgl_pembelian');
            $table->decimal('total_bayar', 10, 2);
            $table->foreignId('id_distributor')->constrained('distributor')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_obat')->constrained('obat')->onDelete('cascade');
            $table->integer('jumlah_beli');
            $table->decimal('harga_beli', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->foreignId('id_pembelian')->constrained('pembelian')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
        Schema::dropIfExists('pembelian');
        Schema::dropIfExists('distributor');
        Schema::dropIfExists('keranjang');
        Schema::dropIfExists('detail_penjualan');
        Schema::dropIfExists('obat');
        Schema::dropIfExists('jenis_obat');
    }
};
