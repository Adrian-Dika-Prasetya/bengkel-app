<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Sparepart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sparepart>
 */
class SparepartFactory extends Factory
{
    public function definition(): array
    {
        $hargaBeli = fake()->numberBetween(8000, 150000);

        return [
            'kode_barang' => fake()->unique()->regexify('[A-Z]{3}-[0-9]{3}'),
            'kategori_id' => Kategori::factory(),
            'nama_barang' => fake()->randomElement(['Oli Mpx2 Matik 0.8L', 'Ban Luar FDR 80/90-14', 'Busi NGK C7HSA', 'V-belt Vario 125']),
            'harga_beli' => $hargaBeli,
            'harga_jual' => $hargaBeli + fake()->numberBetween(5000, 50000),
            'stok' => fake()->numberBetween(5, 50),
            'stok_minimal' => fake()->numberBetween(1, 5),
        ];
    }
}
