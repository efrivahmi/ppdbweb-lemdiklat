<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Guru Demo',
            'email' => 'guru@example.test',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nisn' => null,
            'telp' => '081234567890',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.guru@sekolah.com',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'nisn' => null,
            'telp' => '082345678901',
            'email_verified_at' => now(),
        ]);
    }
}

// Jangan lupa tambahkan ke DatabaseSeeder.php:
// $this->call(GuruSeeder::class);