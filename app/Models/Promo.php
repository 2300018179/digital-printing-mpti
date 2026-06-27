<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- PASTIKAN BARIS INI ADA
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory; // <--- INI ADALAH TRAIT YANG DICARI

    protected $fillable = [
        'nama', 
        'kode', 
        'diskon', 
        'tanggal_mulai', 
        'tanggal_selesai', 
        'status'
    ];
}