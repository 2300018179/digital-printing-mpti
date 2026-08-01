<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller; 
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $dbSettings = Setting::pluck('value', 'key')->toArray();

        $defaultSettings = [
            'nama_toko'         => 'Fantastic Digital Printing',
            'deskripsi_toko'    => 'Layanan cetak digital berkualitas, cepat, dan terpercaya.',
            'banner_toko'       => '[]',
            'jalan_detail'      => 'Jl. Raya Timur Wanadadi',
            'desa_dusun'        => 'Dusun Dua',
            'kecamatan'         => 'Wanadadi',
            'kota'              => 'Banjarnegara',
            'provinsi'          => 'Jawa Tengah',
            'kode_pos'          => '53461',
            'link_google_maps'  => '',
            'jam_senin_sabtu'   => '09.00 - 21.00',
            'jam_minggu'        => 'Tutup',
            'wa_number_1'       => '+62 851-1962-2615',
            'wa_number_2'       => '+62 812-2978-3247',
            'email_toko'        => 'fantasticwnd@gmail.com',
            'instagram_url'     => '@fantastic.printing',
            'fb_link'           => '',
            'tiktok_link'       => '',
            'qris_nama_pemilik' => 'Fantastic Digital Printing',
            'qris_image'        => '',
            'notif_struk_email' => '0',
            'notif_admin_order' => '0',
        ];

        $settings = array_merge($defaultSettings, $dbSettings);

        return view('admin.pengaturan', compact('settings'));
    }

    public function update(Request $request)
    {
        // 1. VALIDASI
        $request->validate([
            'nama_toko'        => 'nullable|string|max:255',
            'deskripsi_toko'   => 'nullable|string',
            'logo_toko'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'qris_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banners'          => 'nullable|array',
            'banners.*'        => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:2048',
            'existing_banners' => 'nullable|array',
        ], [
            'banners.*.max'   => 'Ukuran masing-masing banner maksimal adalah 2 MB.',
            'logo_toko.max'   => 'Ukuran Logo toko maksimal adalah 2 MB.',
            'qris_image.max'  => 'Ukuran gambar QRIS maksimal adalah 2 MB.',
        ]);

        // 2. SIMPAN INPUT TEKS BIASA
        $ignoredKeys = ['_token', 'logo_toko', 'qris_image', 'banners', 'existing_banners', 'banner_toko', 'active_tab'];
        $textData = $request->except($ignoredKeys);

        // Pastikan checkbox/switch ter-handle jika di-uncheck
        $checkboxKeys = ['notif_struk_email', 'notif_admin_order'];
        foreach ($checkboxKeys as $cbKey) {
            if (!$request->has($cbKey)) {
                $textData[$cbKey] = '0';
            }
        }

        foreach ($textData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // 3. PROSES LOGO TOKO
        if ($request->hasFile('logo_toko') && $request->file('logo_toko')->isValid()) {
            $oldLogo = Setting::where('key', 'logo_toko')->first();
            if ($oldLogo && $oldLogo->value && Storage::disk('public')->exists($oldLogo->value)) {
                Storage::disk('public')->delete($oldLogo->value);
            }
            $logoPath = $request->file('logo_toko')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'logo_toko'], ['value' => $logoPath]);
        }

        // 4. PROSES QRIS IMAGE
        if ($request->hasFile('qris_image') && $request->file('qris_image')->isValid()) {
            $oldQris = Setting::where('key', 'qris_image')->first();
            if ($oldQris && $oldQris->value && Storage::disk('public')->exists($oldQris->value)) {
                Storage::disk('public')->delete($oldQris->value);
            }
            $qrisPath = $request->file('qris_image')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'qris_image'], ['value' => $qrisPath]);
        }

        // 5. PROSES BANNER TOKO (Pembersihan file lama & simpan baru)
        $oldBannerSetting = Setting::where('key', 'banner_toko')->first();
        $rawOldBanners = $oldBannerSetting ? json_decode($oldBannerSetting->value, true) : [];
        if (!is_array($rawOldBanners)) $rawOldBanners = [];

        // Flatten $oldBannersList (Memastikan data dari DB murni Array 1 Dimensi Bertipe String)
        $oldBannersList = [];
        array_walk_recursive($rawOldBanners, function($value) use (&$oldBannersList) {
            if (is_string($value) && !empty($value)) {
                $oldBannersList[] = $value;
            }
        });

        $rawExistingBanners = $request->input('existing_banners', []);
        if (!is_array($rawExistingBanners)) $rawExistingBanners = [];

        // Flatten $keptExistingBanners (Memastikan data dari Form Blade murni Array 1 Dimensi Bertipe String)
        $keptExistingBanners = [];
        array_walk_recursive($rawExistingBanners, function($value) use (&$keptExistingBanners) {
            if (is_string($value) && !empty($value)) {
                $keptExistingBanners[] = $value;
            }
        });

        // Hapus file fisik banner yang dibuang oleh user dari form
        $deletedBanners = array_diff(array_unique($oldBannersList), array_unique($keptExistingBanners));
        foreach ($deletedBanners as $deletedFile) {
            if (is_string($deletedFile) && Storage::disk('public')->exists($deletedFile)) {
                Storage::disk('public')->delete($deletedFile);
            }
        }

        $finalBanners = array_values(array_unique($keptExistingBanners));

        // Tambah file banner baru jika ada upload dari user
        if ($request->hasFile('banners')) {
            foreach ($request->file('banners') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('settings', 'public');
                    $finalBanners[] = $path;
                }
            }
        }

        // Simpan ke DB dengan struktur JSON array 1 dimensi yang rapi dan bersih
        Setting::updateOrCreate(
            ['key' => 'banner_toko'],
            ['value' => json_encode(array_values($finalBanners))]
        );

        return redirect()->to(url()->previous() . ($request->active_tab ? '#' . $request->active_tab : ''))
                         ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}