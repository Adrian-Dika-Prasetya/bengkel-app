<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'kategori_id',
        'nama_barang',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimal',
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi ke detail servis
    public function detailServises()
    {
        return $this->hasMany(DetailServis::class);
    }
}
