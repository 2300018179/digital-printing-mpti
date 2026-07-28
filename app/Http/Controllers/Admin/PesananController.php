<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan; // <--- 1. Tambahkan model ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    // <--- 2. Function Download Desain
    public function downloadDesain($id)
    {
        $item = DetailPesanan::findOrFail($id); 

        if (!$item->file_desain) {
            return back()->with('error', 'Item ini tidak memiliki file desain.');
        }

        // Bersihkan path dari string 'public/' atau 'storage/' jika ada
        $cleanPath = ltrim(str_replace(['public/', 'storage/'], '', $item->file_desain), '/');

        // 1. Prioritas: Cek langsung di C:\xampp\htdocs\digital-printing-mpti\public\uploads\desain
        $fullPublicPath = public_path($cleanPath);
        if (file_exists($fullPublicPath)) {
            return response()->download($fullPublicPath);
        }

        // 2. Fallback: Cek di storage/app/public/ (jika ada file lain yang masuk ke sini)
        if (Storage::disk('public')->exists($cleanPath)) {
            return Storage::disk('public')->download($cleanPath);
        }

        return back()->with('error', 'File tidak ditemukan di path: ' . $fullPublicPath);
    }
}