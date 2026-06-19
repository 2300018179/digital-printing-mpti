<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetailPesanan;

class Pesanan extends Model
{
    public function items() {
    return $this->hasMany(\App\Models\DetailPesanan::class, 'pesanan_id');
    }

    protected $fillable = [
        'order_id', 
        'nama_pelanggan', 
        'tanggal_pesanan', 
        'status', 
        'total',
        // tambahkan kolom lainnya di sini
    ];

    protected $guarded = []; // Agar semua kolom bisa diisi
}