<?php

namespace Database\Factories;

use App\Models\Sparepart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sparepart>
 */
class SparepartFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode_barang' => fake()->unique()->regexify('[A-Z]{3}-[0-9]{3}'),
            'nama_barang' => fake()->randomElement(['Oli Mpx2 Matik 0.8L', 'Ban Luar FDR 80/90-14', 'Busi NGK C7HSA', 'V-belt Vario 125']),
            'stok' => fake()->numberBetween(5, 50),
            'harga_jual' => fake()->numberBetween(15000, 200000),
        ];
    }
}
