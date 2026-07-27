<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Menampilkan daftar pelanggan dengan filter pencarian dan pagination.
     */
    public function index(Request $request)
    {
        // 1. Query user dengan role 'customer'
        $query = User::query()->where('role', 'customer'); 

        // 2. Filter pencarian berdasarkan Nama, Email, atau No HP jika ada input 'cari'
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('name', 'like', "%{$cari}%")
                  ->orWhere('email', 'like', "%{$cari}%")
                  ->orWhere('phone', 'like', "%{$cari}%");
            });
        }

        // 3. Ambil data pelanggan beserta jumlah pesanan (limit 7 per halaman)
        $pelanggan = $query->withCount('pesanan')
                           ->latest()
                           ->paginate(7)
                           ->appends($request->all()); // Menjaga query parameter pencarian saat berpindah halaman

        return view('admin.pelanggan', compact('pelanggan'));
    }

    /**
     * Menampilkan detail profil dan log riwayat pesanan milik pelanggan tertentu.
     */
    public function show(Request $request, $id)
    {
        // 1. Ambil data pelanggan berdasarkan ID
        $pelanggan = User::findOrFail($id);

        // 2. Ambil riwayat pesanan milik pelanggan tersebut (limit 5 per halaman)
        $pesanan = $pelanggan->pesanan()
                            ->latest()
                            ->paginate(5)
                            ->appends($request->all());

        return view('admin.detail-pelanggan', compact('pelanggan', 'pesanan'));
    }
}