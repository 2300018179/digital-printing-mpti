<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function index()
    {
        // Memanggil relasi 'subKategoris' sesuai nama fungsi di Model Kategori
        $kategoris = Kategori::with('subKategoris')->get();
        
        return view('admin.kategori.index', compact('kategoris'));
    }

    // Tambahkan fungsi relasi ini
    public function subKategoris()
    {
        return $this->hasMany(SubKategori::class, 'kategori_id');
    }
}