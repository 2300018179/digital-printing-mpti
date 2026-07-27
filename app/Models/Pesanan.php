<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesanan extends Model
{
    // Pastikan tabel sesuai dengan nama di database Anda
    protected $table = 'pesanan'; 

    protected $fillable = [
        'user_id',          // Penting untuk relasi ke User
        'order_id', 
        'nama_pelanggan', 
        'tanggal_pesanan', 
        'status', 
        'bukti_transfer',
        'total',
    ];

    // Relasi ke detail item pesanan
    public function items(): HasMany 
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    // Relasi ke User (Pelanggan)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}