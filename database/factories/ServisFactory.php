<?php

namespace Database\Factories;

use App\Models\Kendaraan;
use App\Models\Servis;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Servis>
 */
class ServisFactory extends Factory
{
    public function definition(): array
    {
        $kendaraan = Kendaraan::factory()->create();

        return [
            'kode_transaksi' => 'SRV-'.fake()->unique()->numerify('######'),
            'kendaraan_id' => $kendaraan->id,
            'mekanik_id' => User::factory()->create(['role' => 'mekanik']),
            'keluhan' => fake()->sentence(),
            'biaya_jasa' => fake()->numberBetween(25000, 150000),
            'total_bayar' => fn (array $attributes) => $attributes['biaya_jasa'],
            'status' => fake()->randomElement(['antre', 'proses', 'selesai']),
        ];
    }
}
