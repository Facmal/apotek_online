<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pelanggan';
    protected $fillable = [
        'nama_pelanggan',
        'email',
        'password',
        'no_telp',
        'alamat1','kota1','propinsi1','kodepos1',
        'alamat2','kota2','propinsi2','kodepos2',
        'alamat3','kota3','propinsi3','kodepos3',
        'foto','url_ktp',
    ];
    protected $hidden = ['password'];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_pelanggan');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_pelanggan');
    }
}
