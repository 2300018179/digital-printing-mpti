<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat Akun Admin Utama
        User::create([
            'name' => 'Admin Fantastic',
            'email' => 'admin@fantastic.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Membuat Akun Customer Contoh (Untuk Tes)
        User::create([
            'name' => 'Customer Toko',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);
    }
}