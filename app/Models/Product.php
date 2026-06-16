<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Daftarkan semua nama kolom database kamu di properti $fillable ini:
    protected $fillable = [
        'name',
        'slug',
        'kategori',
        'price',
        'stock',
        'unit',
        'description',
        'image',
        'status'
    ];
}