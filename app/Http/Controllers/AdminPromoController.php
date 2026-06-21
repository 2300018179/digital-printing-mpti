<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class AdminPromoController extends Controller
{
    // 1. Menampilkan daftar promo
    public function index(Request $request)
    {
        $query = Promo::query();

        // Fitur Pencarian berdasarkan nama atau kode
        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%')
                  ->orWhere('kode', 'like', '%' . $request->cari . '%');
        }

        // Fitur Filter Status
        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }

        $promos = $query->latest()->paginate(10);
        
        return view('admin.promo', compact('promos'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:promos,kode',
            'diskon' => 'required|numeric',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status' => 'required',
        ]);

        // Simpan ke database
        Promo::create($validated);

        return redirect()->route('admin.promo')->with('success', 'Promo berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('admin.edit_promo', compact('promo')); // Pastikan nama view sesuai
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);
        
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'kode'          => 'required|string|unique:promos,kode,' . $id,
            'diskon'        => 'required|numeric',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status'        => 'required|string',
        ]);

        // Data akan terupdate untuk semua kolom yang divalidasi
        $promo->update($validated);

        return redirect()->route('admin.promo')->with('success', 'Promo berhasil diupdate!');
    }

    // 2. Menghapus promo dari database
    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('admin.promo')->with('success', 'Promo berhasil dihapus!');
    }
}