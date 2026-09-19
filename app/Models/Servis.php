<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mendefinisikan nama tabel secara eksplisit
    protected $table = 'servises';

    protected $guarded = [];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function mekanik()
    {
        return $this->belongsTo(User::class, 'mekanik_id');
    }

    public function detailServises()
    {
        return $this->hasMany(DetailServis::class);
    }
}