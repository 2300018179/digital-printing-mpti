<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    // Mengunci nama tabel di database agar tetap menggunakan 'carts'
    protected $table = 'carts';

    protected $fillable = [
        'user_id', 
        'product_id', 
        'quantity', 
        'notes',
        'desain' // Ditambahkan agar data upload/link desain bisa masuk ke database
    ];

    // Relasi ke model Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}