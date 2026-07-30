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
            ['key' => 'deskripsi_toko', 'value' => 'Fantastic Digital Printing adalah layanan digital...'],
            ['key' => 'logo_toko', 'value' => 'settings/YyI3wdAss5wjYckm75nNUF1Ty1jP6a56ncwREnIu.jpg'], // Sesuaikan ekstensi gambarnya jika ada

            // Jam Layanan
            ['key' => 'jam_senin_sabtu', 'value' => '09.00 - 21.00'],
            ['key' => 'jam_minggu', 'value' => 'Tutup'],

            // Kontak
            ['key' => 'wa_number_1', 'value' => '+62 851-1962-2615'],
            ['key' => 'wa_number_2', 'value' => '+62 812-2978-3247'],
            ['key' => 'email_toko', 'value' => 'fantasticwnd@gmail.com'],
            ['key' => 'instagram_url', 'value' => '@fantastic.printing'],

            // Alamat Terpisah (Penting untuk form/checkout)
            ['key' => 'kota', 'value' => 'Banjarnegara'],
            ['key' => 'kode_pos', 'value' => '53461'],
            ['key' => 'link_google_maps', 'value' => 'https://maps.app.goo.gl/xy5i4cTryXcDAx6Pg'],
            ['key' => 'jalan_detail', 'value' => 'JL Raya Timur Wanadadi'],
            ['key' => 'desa_dusun', 'value' => 'Dusun Dua Wanadadi'],
            ['key' => 'kecamatan', 'value' => 'Wanadadi'],
            ['key' => 'provinsi', 'value' => 'Jawa Tengah'],

            // Pembayaran & QRIS
            ['key' => 'qris_nama_pemilik', 'value' => 'Fantastic Digital Printing'],
            ['key' => 'qris_image', 'value' => 'settings/1iWXL5P90VYfCf8mGU7hEnzzSd9ecUIaYa9UbkZQ.jpg'],

            // Pengaturan Notifikasi & UI
            ['key' => 'notif_struk_email', 'value' => '1'],
            ['key' => 'notif_admin_order', 'value' => '1'],
            ['key' => 'banner_toko', 'value' => '[["settings\/V3q5JdNsKEea7Yg2iA6cwJL8XiYL2gVp3LgJJWHL.jpg","settings\/BozCwZI4Oorm8syxADC1b6x2wlUeCB77ciqQ940V.jpg","settings\/y4Foxo4uAfkCKIOdoVG5hR00LJ3vCv1K067eDcX1.jpg"]]'],
            ['key' => 'active_tab', 'value' => 'sosial-media'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}