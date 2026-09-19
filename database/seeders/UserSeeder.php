<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'no_telepon' => '081100000001',
        ]);

        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@bengkel.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'kasir',
            'no_telepon' => '081100000002',
        ]);

        User::create([
            'name' => 'Mekanik Budi',
            'email' => 'budi@bengkel.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'mekanik',
            'no_telepon' => '081100000003',
        ]);
    }
}
