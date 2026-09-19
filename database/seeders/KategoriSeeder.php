<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Oli & Pelumas', 'Ban', 'Busi & Pengapian', 'Kampas Rem'] as $nama) {
            Kategori::firstOrCreate(['nama' => $nama]);
        }
    }
}
