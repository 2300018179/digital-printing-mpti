<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    // Nama tabel di database (opsional, Laravel otomatis mendeteksi 'pengumumans')
    protected $table = 'pengumumans';

    // Kolom yang dapat diisi secara massal (Mass Assignment)
    protected $fillable = [
        'judul',
        'isi',
        'tanggal',
        'status',
    ];
}