<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@bengkel.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        User::create([
            'name' => 'Mekanik Budi',
            'email' => 'budi@bengkel.com',
            'password' => Hash::make('password'),
            'role' => 'mekanik',
        ]);
    }
}