<?php

namespace App\Models;

use Database\Factories\PelangganFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    /** @use HasFactory<PelangganFactory> */
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
    ];

    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class);
    }
}
