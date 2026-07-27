<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Identitas & Deskripsi
            ['key' => 'nama_toko', 'value' => 'Fantastic Digital Printing'],
            ['key' => 'deskripsi_toko', 'value' => 'Fantastic Digital Printing adalah layanan digital printing online terpercaya yang melayani berbagai kebutuhan cetak Anda dengan kualitas terbaik dan harga terjangkau.'],
            ['key' => 'logo_toko', 'value' => null], // Gambar logo

            // Jam Layanan (Sesuai Footer)
            ['key' => 'jam_senin_sabtu', 'value' => '09.00 - 21.00'],
            ['key' => 'jam_minggu', 'value' => 'Tutup'],

            // Alamat & Kontak (Sesuai Footer)
            ['key' => 'alamat_lengkap', 'value' => 'Jl. Raya Timur Wanadadi, Dusun Dua, Wanadadi, Kec. Wanadadi, Kab. Banjarnegara, Jawa Tengah'],
            ['key' => 'wa_number_1', 'value' => '+62 851-1962-2615'],
            ['key' => 'wa_number_2', 'value' => '+62 812-2978-3247'],
            ['key' => 'email_toko', 'value' => 'fantasticwnd@gmail.com'],

            // Sosial Media
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/fantastic_printing'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}