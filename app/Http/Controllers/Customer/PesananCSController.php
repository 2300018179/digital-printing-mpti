<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // <-- 1. Tambahkan ini di atas

class PesananCSController extends Controller
{
    /**
     * Menampilkan halaman daftar pesanan / riwayat transaksi customer.
     */
    public function index(Request $request)
    {
        // Mengambil filter status dari query string (default: Diproses)
        $status = $request->query('status', 'Diproses');
        
        // Memulai query pesanan milik user yang sedang login
        $query = Pesanan::where('user_id', auth()->id())
            ->with(['items.product']); // Pre-load relasi items dan product untuk efisiensi query

        // Filter berdasarkan status jika ditentukan
        if (in_array($status, ['Diproses', 'Dicetak', 'Selesai'])) {
            $query->where('status', $status);
        }

        // Ambil data terbaru
        $orders = $query->latest()->get();

        return view('customer.pesanan', compact('orders'));
    }

    /**
     * Method baru untuk menangani download file desain customer
     */
    public function downloadDesain($filename)
    {
        $cleanFilename = basename(urldecode($filename));

        // Tambahkan path storage/app/public/desain_temp ke dalam array
        $possiblePaths = [
            public_path('uploads/desain/' . $cleanFilename),
            public_path($filename), // Jika nilai di DB tersimpan "uploads/desain/nama.jpg"
            storage_path('app/public/desain_temp/' . $cleanFilename), // <-- Untuk transaksi direct checkout
            storage_path('app/public/desain/' . $cleanFilename),
            storage_path('app/public/' . $cleanFilename),
        ];

        foreach ($possiblePaths as $filePath) {
            if (file_exists($filePath)) {
                return response()->download($filePath);
            }
        }

        return back()->with('error', 'File tidak ditemukan di server.');
    }
}