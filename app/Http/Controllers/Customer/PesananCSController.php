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
        // Ambil nama file bersih dari request
        $cleanFilename = basename(urldecode($filename));

        // Path fisik sesuai dengan lokasi sebenarnya di laptop kamu
        $filePath = public_path('uploads/desain/' . $cleanFilename);

        // Cek apakah file ada di folder public/uploads/desain
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        // Backup jika di kemudian hari file di-upload ke assets/file_desain
        $backupPath = public_path('assets/file_desain/' . $cleanFilename);
        if (file_exists($backupPath)) {
            return response()->download($backupPath);
        }

        return back()->with('error', 'File tidak ditemukan di server.');
    }
}