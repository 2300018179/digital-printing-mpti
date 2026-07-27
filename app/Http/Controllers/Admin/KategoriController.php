<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\SubKategori;

class KategoriController extends Controller
{
    public function index()
    {
        $subKategoris = SubKategori::with('kategori')->paginate(8);
        return view('admin.kategori', compact('subKategoris'));
    }

    // 1. Menampilkan Halaman Edit
    public function edit($id)
    {
        $subKategori = SubKategori::with('kategori')->findOrFail($id);
        return view('admin.edit-kategori', compact('subKategori'));
    }

    // 2. Menyimpan Tambah Data
    public function store(Request $request)
    {
        $request->validate([
            'kategori_name' => 'required|string|max:255',
            'name'          => 'required|string|max:255',
        ]);

        // Cari Kategori Utama, jika belum ada buat baru
        $kategori = Kategori::firstOrCreate([
            'name' => trim($request->kategori_name)
        ]);

        // Simpan Sub Kategori
        SubKategori::create([
            'kategori_id' => $kategori->id,
            'name'        => trim($request->name),
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Sub Kategori berhasil ditambahkan!');
    }
    
    // 3. Menyimpan Hasil Edit (Aman & Tidak Merusak Kategori Lain)
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_name' => 'required|string|max:255',
            'name'          => 'required|string|max:255',
        ]);

        $subKategori = SubKategori::findOrFail($id);

        // Cari atau buat Kategori Utama yang baru dimasukkan
        $kategori = Kategori::firstOrCreate([
            'name' => trim($request->kategori_name)
        ]);

        // Update SubKategori dengan ID Kategori Utama yang sesuai & Nama Baru
        $subKategori->update([
            'kategori_id' => $kategori->id,
            'name'        => trim($request->name),
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    // 4. Hapus Sub Kategori
    public function destroy($id) 
    {
        // Ubah dari Kategori::findOrFail ke SubKategori::findOrFail
        $subKategori = SubKategori::findOrFail($id);
        $subKategori->delete();
        
        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}