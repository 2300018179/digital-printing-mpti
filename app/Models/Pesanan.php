<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesanan extends Model
{
    protected $table = 'pesanan'; 

    protected $fillable = [
        'user_id',        
        'order_id', 
        'nama_pelanggan', 
        'tanggal_pesanan', 
        'status',          // 'menunggu_pembayaran', 'dp', 'selesai', 'dibatalkan'
        'tipe_pembayaran',  // 'full', 'dp_50'
        'bukti_transfer',
        'nominal_dibayar', // Nominal riil yang dikirim (misal DP 50% dari total)
        'total',           // Grand total pesanan
    ];

    public function items(): HasMany 
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Helper Pendapatan Riil (Pencegah Selisih)
     */
    public function getUangMasukAttribute()
    {
        // Jika kolom nominal_dibayar diisi, gunakan nilainya. Jika tidak, ambil total jika status selesai.
        if ($this->nominal_dibayar > 0) {
            return $this->nominal_dibayar;
        }
        
        return $this->status === 'selesai' ? $this->total : 0;
    }
}