<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; 

    protected $fillable = [
        'name', 
        'slug', 
        'sub_kategori_id', 
        'price', 
        'minimum_order', 
        'unit', 
        'description', 
        'image', 
        'status'
    ];

    /**
     * Relasi ke model SubKategori
     */
    public function subKategori()
    {
        return $this->belongsTo(SubKategori::class, 'sub_kategori_id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(\App\Models\DetailPesanan::class, 'product_id');
    }
}