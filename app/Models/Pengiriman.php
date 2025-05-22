<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengiriman';
    protected $fillable = [
        'id_penjualan',
        'id_kurir',
        'no_invoice',
        'tgl_kirim',
        'tgl_tiba',
        'status_kirim',
        'nama_kurir',
        'telpon_kurir',
        'bukti_foto',
        'keterangan'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    public function kurir()
    {
        return $this->belongsTo(User::class, 'id_kurir');
    }
}
