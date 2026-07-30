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
        ]);

        $pesanan = Pesanan::findOrFail($id);

        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('admin.pesanan')->with('success', 'Status pesanan #' . $pesanan->order_id . ' berhasil diperbarui!');
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