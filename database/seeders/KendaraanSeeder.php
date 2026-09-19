<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['B 1234 ABC', 'Honda', 'Vario 150'],
            ['B 5678 DEF', 'Yamaha', 'NMAX'],
            ['B 9012 GHI', 'Toyota', 'Avanza'],
        ];

        $pelanggans = Pelanggan::orderBy('id')->get();

        foreach ($data as $index => [$plat, $merk, $tipe]) {
            $pelanggan = $pelanggans->get($index) ?? $pelanggans->last();

            Kendaraan::firstOrCreate(
                ['plat_nomor' => $plat],
                ['pelanggan_id' => $pelanggan->id, 'merk' => $merk, 'tipe' => $tipe]
            );
        }
    }
}
