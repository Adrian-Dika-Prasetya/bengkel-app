<?php

namespace Database\Factories;

use App\Models\Pembayaran;
use App\Models\Servis;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pembayaran>
 */
class PembayaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'servis_id' => Servis::factory(),
            'kasir_id' => User::factory()->kasir(),
            'jumlah_bayar' => fake()->numberBetween(20000, 300000),
            'metode' => fake()->randomElement(['tunai', 'transfer', 'qris']),
            'dibayar_pada' => now(),
        ];
    }
}
