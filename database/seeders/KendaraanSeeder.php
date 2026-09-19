<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    public function run(): void
    {
        Kendaraan::create([
            'plat_nomor' => 'B 1234 ABC',
            'nama_pemilik' => 'Andi Wijaya',
            'no_hp' => '081234567890',
            'merk_tipe' => 'Honda Vario 150',
        ]);

        Kendaraan::create([
            'plat_nomor' => 'B 5678 DEF',
            'nama_pemilik' => 'Siti Rahmawati',
            'no_hp' => '081298765432',
            'merk_tipe' => 'Yamaha NMAX',
        ]);

        Kendaraan::create([
            'plat_nomor' => 'B 9012 GHI',
            'nama_pemilik' => 'Bambang Susilo',
            'no_hp' => '081345678912',
            'merk_tipe' => 'Toyota Avanza',
        ]);
    }
}
