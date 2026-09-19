<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Sparepart;
use Illuminate\Database\Seeder;

class SparepartSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['OLI-001', 'Oli & Pelumas', 'Oli Mpx2 Matik 0.8L', 40000, 55000, 20, 5],
            ['BAN-001', 'Ban', 'Ban Luar FDR 80/90-14', 145000, 185000, 10, 3],
            ['BUSI-001', 'Busi & Pengapian', 'Busi NGK C7HSA', 15000, 25000, 50, 10],
        ];

        foreach ($data as [$kode, $kategori, $nama, $hargaBeli, $hargaJual, $stok, $stokMinimal]) {
            Sparepart::firstOrCreate(
                ['kode_barang' => $kode],
                [
                    'kategori_id' => Kategori::where('nama', $kategori)->first()?->id,
                    'nama_barang' => $nama,
                    'harga_beli' => $hargaBeli,
                    'harga_jual' => $hargaJual,
                    'stok' => $stok,
                    'stok_minimal' => $stokMinimal,
                ]
            );
        }
    }
}
