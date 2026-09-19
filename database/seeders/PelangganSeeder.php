<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        Pelanggan::firstOrCreate(
            ['no_hp' => '081234567890'],
            ['nama' => 'Andi Wijaya', 'alamat' => 'Jl. Merdeka No.1']
        );

        Pelanggan::firstOrCreate(
            ['no_hp' => '081298765432'],
            ['nama' => 'Siti Rahmawati', 'alamat' => 'Jl. Melati No.7']
        );

        Pelanggan::firstOrCreate(
            ['no_hp' => '081345678912'],
            ['nama' => 'Bambang Susilo', 'alamat' => 'Jl. Anggrek No.12']
        );
    }
}
