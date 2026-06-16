<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminKategoriController extends Controller {
    public function index()
    {
        $kategoris = \App\Models\Kategori::all(); 
        return view('admin.kategori', compact('kategoris'));
    }

    public function edit($id)
    {
        $kategori = \App\Models\Kategori::findOrFail($id);
        return view('admin.edit-kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:kategoris,name',
        ]);

        // 2. Simpan ke database
        \App\Models\Kategori::create([
            'name' => $request->name,
        ]);

        // 3. Kembali ke halaman kategori dengan pesan sukses
        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $kategori = \App\Models\Kategori::findOrFail($id);
        $kategori->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id) {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('admin.kategori')->with('success', 'Kategori dihapus!');
    }
}
