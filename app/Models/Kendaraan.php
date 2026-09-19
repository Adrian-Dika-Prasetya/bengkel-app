<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plat_nomor',
        'nama_pemilik',
        'no_hp',
        'merk_tipe',
    ];

    // Relasi: 1 Kendaraan bisa punya banyak Riwayat Servis
    public function servises()
    {
        return $this->hasMany(Servis::class);
    }
}