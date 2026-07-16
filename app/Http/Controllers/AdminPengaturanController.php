<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPengaturanController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.pengaturan', compact('settings'));
    }

    public function update(Request $request)
    {
        // 1. Ambil semua input kecuali _token
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            // 2. Cek apakah ini input file (gambar)
            if ($request->hasFile($key)) {
                // Ambil setting lama untuk cek apakah ada gambar sebelumnya
                $oldSetting = Setting::where('key', $key)->first();
                
                // Jika ada gambar lama, hapus dari storage
                if ($oldSetting && $oldSetting->value && Storage::disk('public')->exists($oldSetting->value)) {
                    Storage::disk('public')->delete($oldSetting->value);
                }

                // Upload gambar baru
                $path = $request->file($key)->store('settings', 'public');
                $value = $path;
            }

            // 3. Simpan ke database
            // Kita skip jika value kosong agar data yang tidak diubah tidak tertimpa
            if ($value !== null) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}