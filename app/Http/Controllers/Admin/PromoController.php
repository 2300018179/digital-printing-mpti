<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $queryPromo = Promo::query();

        if ($request->filled('cari')) {
            $queryPromo->where('nama', 'like', '%' . $request->cari . '%')
                       ->orWhere('kode', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('status') && $request->status !== 'Semua') {
            $queryPromo->where('status', $request->status);
        }

        $promos = $queryPromo->latest()->paginate(10, ['*'], 'promo_page');

        $informasis = Pengumuman::latest()->get();

        return view('admin.promo', compact('promos', 'informasis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'kode'            => 'required|string|unique:promos,kode',
            'diskon'          => 'required|numeric|min:1|max:100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status'          => 'required|string',
        ]);

        Promo::create($validated);

        return redirect()->route('admin.promo', ['tab' => 'promo'])
                         ->with('active_tab', 'promo')
                         ->with('success', 'Promo berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('admin.edit_promo', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);
        
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'kode'            => 'required|string|unique:promos,kode,' . $id,
            'diskon'          => 'required|numeric|min:1|max:100',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status'          => 'required|string',
        ]);

        $promo->update($validated);

        return redirect()->route('admin.promo', ['tab' => 'promo'])
                         ->with('active_tab', 'promo')
                         ->with('success', 'Promo berhasil diupdate!');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('admin.promo', ['tab' => 'promo'])
                         ->with('active_tab', 'promo')
                         ->with('success', 'Promo berhasil dihapus!');
    }

    public function storePengumuman(Request $request)
    {
        $validated = $request->validate([
            'judul'   => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status'  => 'required|string',
            'isi'     => 'required|string',
        ]);

        Pengumuman::create($validated);

        return redirect()->route('admin.promo', ['tab' => 'info'])
                         ->with('active_tab', 'info')
                         ->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function editPengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.edit-pengumuman', compact('pengumuman'));
    }

    public function updatePengumuman(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $validated = $request->validate([
            'judul'   => 'required|string|max:255',
            'tanggal' => 'required|date',
            'status'  => 'required|string',
            'isi'     => 'required|string',
        ]);

        $pengumuman->update($validated);

        return redirect()->route('admin.promo', ['tab' => 'info'])
                         ->with('active_tab', 'info')
                         ->with('success', 'Pengumuman berhasil diupdate!');
    }

    public function destroyPengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        return redirect()->route('admin.promo', ['tab' => 'info'])
                         ->with('active_tab', 'info')
                         ->with('success', 'Pengumuman berhasil dihapus!');
    }
}