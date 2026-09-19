<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sparepart;

class SparepartSeeder extends Seeder
{
    public function run(): void
    {
        Sparepart::create([
            'kode_barang' => 'OLI-001',
            'nama_barang' => 'Oli Mpx2 Matik 0.8L',
            'stok' => 20,
            'harga_jual' => 55000,
        ]);

        Sparepart::create([
            'kode_barang' => 'BAN-001',
            'nama_barang' => 'Ban Luar FDR 80/90-14',
            'stok' => 10,
            'harga_jual' => 185000,
        ]);

        Sparepart::create([
            'kode_barang' => 'BUSI-001',
            'nama_barang' => 'Busi NGK C7HSA',
            'stok' => 50,
            'harga_jual' => 25000,
        ]);
    }
}