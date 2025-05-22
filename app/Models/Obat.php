<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';
    protected $fillable = [
        'nama_obat',
        'id_jenis_obat',
        'harga_jual',
        'deskripsi_obat',
        'foto1',
        'foto2',
        'foto3',
        'stok'
    ];

    public function jenisObat()
    {
        return $this->belongsTo(JenisObat::class, 'id_jenis_obat');
    }

    public function detailPembelians()
    {
        return $this->hasMany(DetailPembelian::class, 'id_obat');
    }

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_obat');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class, 'id_obat');
    }
}
