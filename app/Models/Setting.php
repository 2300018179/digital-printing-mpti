<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * Tentukan kolom mana saja yang boleh diisi melalui form.
     * Ini penting agar Laravel mengizinkan data masuk ke database.
     */
    protected $fillable = [
        'key', 
        'value',
    ];

    /**
     * (Opsional) Fungsi pembantu agar mudah mengambil data 
     * di file manapun di aplikasi Anda.
     * Cara panggil: Setting::get('nama_toko')
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}