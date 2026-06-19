<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    // Sesuaikan dengan nama tabel asli di database!
    protected $table = 'detail_pesanan'; 

    protected $fillable = [
        'pesanan_id',
        'nama_produk',
        'harga',
        'jumlah',
        'keterangan'
    ];
}