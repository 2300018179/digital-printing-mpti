<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        // Mengambil semua data pesanan dari database
        $pesanans = Pesanan::latest()->paginate(7);

        return view('admin.pesanan', compact('pesanans'));
    }
    
    public function detail($id)
    {
        $pesanan = Pesanan::with('items')->findOrFail($id);
        return view('admin.detail-pesanan', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        // 1. Validasi input
        $request->validate([
            'status' => 'required|string',
        ]);

        // 2. Cari pesanan berdasarkan ID
        $pesanan = Pesanan::findOrFail($id);

        // 3. Update status
        $pesanan->status = $request->status;
        $pesanan->save();

        // 4. Redirect ke halaman Data Pesanan dengan nama route 'admin.pesanan'
        return redirect()->route('admin.pesanan')->with('success', 'Status pesanan #' . $pesanan->order_id . ' berhasil diperbarui!');
    }
}