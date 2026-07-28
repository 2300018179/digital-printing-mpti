<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris'; // atau 'categories', sesuaikan dengan nama tabel di DB kamu
    protected $fillable = ['name'];

    // Relasi ke SubKategori
    public function subKategoris()
    {
        return $this->hasMany(SubKategori::class, 'kategori_id');
    }
}