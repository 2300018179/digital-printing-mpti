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
        $query = User::query()->where('role', 'customer'); 

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('name', 'like', "%{$cari}%")
                  ->orWhere('email', 'like', "%{$cari}%")
                  ->orWhere('phone', 'like', "%{$cari}%");
            });
        }

        $pelanggan = $query->withCount('pesanan')
                           ->latest()
                           ->paginate(7)
                           ->appends($request->all()); 

        return view('admin.pelanggan', compact('pelanggan'));
    }

    /**
     * Menampilkan detail profil dan log riwayat pesanan milik pelanggan tertentu.
     */
    public function show(Request $request, $id)
    {
        $pelanggan = User::findOrFail($id);

        $pesanan = $pelanggan->pesanan()
                            ->latest()
                            ->paginate(5)
                            ->appends($request->all());

        return view('admin.detail-pelanggan', compact('pelanggan', 'pesanan'));
    }
}