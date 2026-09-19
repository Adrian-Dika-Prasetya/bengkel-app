<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok',
        'harga_jual',
    ];

    // Relasi ke detail servis
    public function detailServises()
    {
        return $this->hasMany(DetailServis::class);
    }
}