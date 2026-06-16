<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin Utama
        User::create([
            'name' => 'Admin Fantastic',
            'email' => 'admin@fantastic.com',
            'password' => Hash::make('password123'), 
            'role' => 'admin',
        ]);

        // Membuat akun contoh Customer (opsional, untuk testing)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@email.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);
    }
}