<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan model User di-import
use Illuminate\Http\Request;

class AdminPelangganController extends Controller
{
    public function index(Request $request)
    {
        // 1. Query user dengan role 'customer'
        $query = User::query()->where('role', 'customer'); 

        // 2. Filter pencarian
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('name', 'like', "%{$cari}%")
                  ->orWhere('email', 'like', "%{$cari}%");
            });
        }

        // 3. Mengambil data dengan menghitung jumlah pesanan (withCount)
        // 'orders' harus sesuai dengan nama method relasi di Model User
        $pelanggan = $query->withCount('pesanan')
                           ->latest()
                           ->paginate(10);

        return view('admin.pelanggan', compact('pelanggan'));
    }

    public function show($id)
    {
        // Mengambil user berdasarkan ID, sekaligus relasi pesanannya
        $pelanggan = \App\Models\User::with('pesanan')->findOrFail($id);
        
        return view('admin.detail_pelanggan', compact('pelanggan'));
    }
}