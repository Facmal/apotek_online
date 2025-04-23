<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jenis_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kirim', ['ekonomi', 'kargo', 'regular', 'same day', 'standar']);
            $table->string('nama_ekspedisi', 255);
            $table->string('logo_ekspedisi', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan', 255);
            $table->string('email', 255);
            $table->string('katakunci', 15);
            $table->string('no_telp', 15);
            $table->string('alamat1', 255);
            $table->string('kota1', 255);
            $table->string('propinsi1', 255);
            $table->string('kodepos1', 255);
            $table->string('alamat2', 255)->nullable();
            $table->string('kota2', 255)->nullable();
            $table->string('propinsi2', 255)->nullable();
            $table->string('kodepos2', 255)->nullable();
            $table->string('alamat3', 255)->nullable();
            $table->string('kota3', 255)->nullable();
            $table->string('propinsi3', 255)->nullable();
            $table->string('kodepos3', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('url_ktp', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('metode_bayar', function (Blueprint $table) {
            $table->id();
            $table->string('metode_pembayaran');
            $table->string('tempat_bayar', 50);
            $table->string('no_rekening', 25);
            $table->text('url_logo')->nullable();
            $table->timestamps();
        });

        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_metode_bayar')->constrained('metode_bayar')->onDelete('cascade');
            $table->date('tgl_penjualan');
            $table->string('url_resep', 255)->nullable();
            $table->decimal('ongkos_kirim', 10, 2)->default(0);
            $table->decimal('biaya_app', 10, 2)->default(0);
            $table->decimal('total_bayar', 10, 2)->default(0);
            $table->enum('status_order', [
                'Menunggu Konfirmasi',
                'Diproses',
                'Menunggu Kurir',
                'Dibatalkan Pembeli',
                'Dibatalkan Penjual',
                'Bermasalah',
                'Selesai'
            ])->default('Menunggu Konfirmasi');
            $table->string('keterangan_status', 255)->nullable();
            $table->foreignId('id_jenis_kirim')->constrained('jenis_pengiriman')->onDelete('cascade');
            $table->foreignId('id_pelanggan')->constrained('pelanggan')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjualan')->constrained('penjualan')->onDelete('cascade');
            $table->string('no_invoice', 255);
            $table->dateTime('tgl_kirim');
            $table->dateTime('tgl_tiba')->nullable();
            $table->enum('status_kirim', ['Sedang Dikirim', 'Tiba Di Tujuan']);
            $table->string('nama_kurir', 30);
            $table->string('telpon_kurir', 15);
            $table->string('bukti_foto', 255)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
        Schema::dropIfExists('penjualan');
        Schema::dropIfExists('metode_bayar');
        Schema::dropIfExists('pelanggan');
        Schema::dropIfExists('jenis_pengiriman');
    }
};
