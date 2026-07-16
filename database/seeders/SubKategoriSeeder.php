<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubKategoriSeeder extends Seeder
{
    public function run(): void
    {
        // Menghapus data lama terlebih dahulu
        $subKategoris = [
            // 1: Print On Paper
            ['id' => 1, 'kategori_id' => 1, 'name' => 'Print A3+'],
            ['id' => 2, 'kategori_id' => 1, 'name' => 'Blocknote'],
            ['id' => 3, 'kategori_id' => 1, 'name' => 'Buku Yasin'],
            ['id' => 4, 'kategori_id' => 1, 'name' => 'Buku Nota'],
            ['id' => 5, 'kategori_id' => 1, 'name' => 'Tiket & Kupon'],

            // 2: Print Stiker
            ['id' => 6, 'kategori_id' => 2, 'name' => 'Stiker Meteran'],
            ['id' => 7, 'kategori_id' => 2, 'name' => 'Stiker A3+'],

            // 3: Kalender
            ['id' => 8, 'kategori_id' => 3, 'name' => 'Kalender Dinding'],
            ['id' => 9, 'kategori_id' => 3, 'name' => 'Kalender Meja'],

            // 4: Banner & Spanduk
            ['id' => 10, 'kategori_id' => 4, 'name' => 'Banner'],
            ['id' => 11, 'kategori_id' => 4, 'name' => 'Spanduk'],

            // 5: Sablon
            ['id' => 12, 'kategori_id' => 5, 'name' => 'Baju'],
            ['id' => 13, 'kategori_id' => 5, 'name' => 'Tas'],

            // 6: Sovenir
            ['id' => 14, 'kategori_id' => 6, 'name' => 'Payung'],
            ['id' => 15, 'kategori_id' => 6, 'name' => 'Gelas'],

            // 7: Undangan
            ['id' => 16, 'kategori_id' => 7, 'name' => 'Blangko'],
            ['id' => 17, 'kategori_id' => 7, 'name' => 'Custom'],

            // 8: Papan Informasi
            ['id' => 18, 'kategori_id' => 8, 'name' => 'Papan Tulis'],
            ['id' => 19, 'kategori_id' => 8, 'name' => 'Papan Informasi Besi'],
            ['id' => 20, 'kategori_id' => 8, 'name' => 'Papan Informasi Pigura'],
            ['id' => 21, 'kategori_id' => 8, 'name' => 'Papan Informasi Akrilik'],
            
            // 9: Tanda Pengenal
            ['id' => 22, 'kategori_id' => 9, 'name' => 'Co Card'],
            ['id' => 23, 'kategori_id' => 9, 'name' => 'Name Tag'],
            ['id' => 24, 'kategori_id' => 9, 'name' => 'Stampel'],
        ];
        DB::table('sub_kategoris')->insert($subKategoris);
    }
}