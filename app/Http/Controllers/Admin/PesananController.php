<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    public function index()
    {
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
        $request->validate([
            'status' => 'required|string',
            'bukti_pelunasan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // 1. Update Status Utama Pesanan
        $pesanan->status = $request->status;

        // 2. Cek Jika Ada Unggahan Bukti Pelunasan DP
        if ($request->hasFile('bukti_pelunasan')) {
            $file = $request->file('bukti_pelunasan');
            $filename = 'pelunasan_' . time() . '_' . $pesanan->order_id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/bukti_pelunasan'), $filename);

            // Otomatis Hitung Ulang & Set Lunas di Database
            $pesanan->bukti_pelunasan  = $filename;
            $pesanan->status_pelunasan = 'lunas';
            $pesanan->nominal_dibayar  = $pesanan->total; // Nominal jadi 100% full
            $pesanan->sisa_pembayaran  = 0;               // Sisa tagihan jadi NOL
        }

        $pesanan->save();

        return redirect()->back()->with('success', 'Status pesanan #' . $pesanan->order_id . ' & pelunasan berhasil diperbarui!');
    }

    public function downloadDesain($id)
    {
        $item = DetailPesanan::findOrFail($id); 

        if (!$item->file_desain) {
            return back()->with('error', 'Item ini tidak memiliki file desain.');
        }

        $cleanPath = ltrim(str_replace(['public/', 'storage/'], '', $item->file_desain), '/');

        $fullPublicPath = public_path($cleanPath);
        if (file_exists($fullPublicPath)) {
            return response()->download($fullPublicPath);
        }

        if (Storage::disk('public')->exists($cleanPath)) {
            return Storage::disk('public')->download($cleanPath);
        }

        return back()->with('error', 'File tidak ditemukan di path: ' . $fullPublicPath);
    }
} 