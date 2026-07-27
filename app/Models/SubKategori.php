<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    // 1. TAMBAHKAN BARIS INI UNTUK MATIKAN TIMESTAMPS
    public $timestamps = false;

    // Tentukan nama tabel jika Laravel tidak mendeteksinya secara otomatis
    protected $table = 'sub_kategoris';

    protected $fillable = [
        'kategori_id',
        'name'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class, 'sub_kategori_id');
    }
}