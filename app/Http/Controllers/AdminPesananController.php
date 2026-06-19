<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pesanan; // Pastikan kamu sudah punya model Pesanan
use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    public function index()
    {
        // Mengambil semua data pesanan dari database
        $pesanans = Pesanan::latest()->get(); 
        

        return view('admin.pesanan', compact('pesanans'));
    }
    
    public function detail($id)
    {
        $pesanan = \App\Models\Pesanan::with('items')->findOrFail($id);
        return view('admin.detail-pesanan', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        // 1. Validasi input
        $request->validate([
            'status' => 'required|string',
        ]);

        // 2. Cari pesanan berdasarkan ID
        $pesanan = \App\Models\Pesanan::findOrFail($id);

        // 3. Update status
        $pesanan->status = $request->status;
        $pesanan->save();

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate!');
    }
}