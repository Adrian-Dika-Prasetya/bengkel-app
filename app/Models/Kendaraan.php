<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'plat_nomor',
        'merk',
        'tipe',
    ];

    // Relasi: 1 Kendaraan dimiliki 1 Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi: 1 Kendaraan bisa punya banyak Riwayat Servis
    public function servises()
    {
        return $this->hasMany(Servis::class);
    }
}
