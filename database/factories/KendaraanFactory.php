<?php

namespace Database\Factories;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kendaraan>
 */
class KendaraanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pelanggan_id' => Pelanggan::factory(),
            'plat_nomor' => fake()->unique()->regexify('[A-Z] [0-9]{4} [A-Z]{1,3}'),
            'merk' => fake()->randomElement(['Honda', 'Yamaha', 'Toyota', 'Suzuki']),
            'tipe' => fake()->randomElement(['Vario 150', 'NMAX', 'Avanza', 'Satria FU']),
        ];
    }
}
