<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['id' => 1, 'name' => 'Print On Paper', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Print Stiker', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Kalender', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Banner & Spanduk', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Sablon', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Sovenir', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Undangan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Papan Informasi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Tanda Pengenal', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('kategoris')->insert($kategoris);
    }
}