<?php

namespace Database\Factories;

use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kendaraan>
 */
class KendaraanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'plat_nomor' => fake()->unique()->regexify('[A-Z] [0-9]{4} [A-Z]{1,3}'),
            'nama_pemilik' => fake()->name(),
            'no_hp' => '08'.fake()->numerify('#########'),
            'merk_tipe' => fake()->randomElement(['Honda Vario 150', 'Yamaha NMAX', 'Toyota Avanza', 'Suzuki Satria']),
        ];
    }
}
