<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminPembayaranController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil status dari URL, default ke 'Menunggu' jika kosong
        $status = $request->query('status', 'Menunggu');
        
        // Mengambil data berdasarkan status
        $pesanans = \App\Models\Pesanan::where('status', $status)->get();
        
        // Menghitung jumlah per status untuk angka di tombol
        $counts = [
            'Menunggu' => \App\Models\Pesanan::where('status', 'Menunggu')->count(),
            'Disetujui' => \App\Models\Pesanan::where('status', 'Disetujui')->count(),
            'Ditolak' => \App\Models\Pesanan::where('status', 'Ditolak')->count(),
        ];

        return view('admin.pembayaran', compact('pesanans', 'status', 'counts'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = \App\Models\Pesanan::findOrFail($id);
        $pesanan->status = $request->status; // 'Disetujui' atau 'Ditolak'
        $pesanan->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    public function simpanBukti(Request $request, $id)
    {
        // 1. Validasi file (harus gambar, max 2MB)
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // 2. Cek apakah ada file lama, jika ada hapus (opsional, untuk menghemat space)
        if ($pesanan->bukti_transfer) {
            \Storage::disk('public')->delete($pesanan->bukti_transfer);
        }

        // 3. Simpan file ke folder 'bukti_transfer' di dalam storage/app/public
        // Hasilnya tersimpan di: storage/app/public/bukti_transfer/nama_file.jpg
        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

        // 4. Update path di database
        $pesanan->bukti_transfer = $path;
        $pesanan->status = 'Menunggu'; // Otomatis balik ke status menunggu
        $pesanan->save();

        return redirect()->back()->with('success', 'Bukti transfer berhasil diunggah!');
    }
}