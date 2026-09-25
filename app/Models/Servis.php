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

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    // Total uang yang sudah dibayar pelanggan
    public function getTotalDibayarAttribute(): int
    {
        if ($this->relationLoaded('pembayarans')) {
            return (int) $this->pembayarans->sum('jumlah_bayar');
        }

        return (int) $this->pembayarans()->sum('jumlah_bayar');
    }

    // Status pelunasan dihitung dari total pembayaran, bukan kolom status.
    // Tagihan 0 (jasa & sparepart kosong) otomatis dianggap lunas.
    public function getLunasAttribute(): bool
    {
        return $this->totalDibayar >= $this->total_bayar;
    }
}
