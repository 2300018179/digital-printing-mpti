<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    // Tambahkan 'file_desain' dan 'link_desain' ke dalam $fillable
    protected $fillable = [
        'pesanan_id',
        'product_id',
        'nama_produk',
        'jumlah',
        'harga',
        'keterangan',
        'file_desain', // <--- Tambahkan baris ini
        'link_desain', // <--- Tambahkan baris ini
    ];

    // Definisikan relasi ke model Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}