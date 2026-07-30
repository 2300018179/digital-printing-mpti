<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Setting;
use App\Mail\NotifikasiPesananMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        // Status default dari URL / Tab saat pertama masuk adalah 'Menunggu'
        $status = $request->query('status', 'Menunggu');
        
        // Map status filter URL ke database
        if ($status === 'Menunggu') {
            $dbStatuses = ['Diproses', 'Menunggu'];
        } elseif ($status === 'Disetujui') {
            $dbStatuses = ['Dicetak', 'Selesai', 'Disetujui'];
        } else {
            $dbStatuses = ['Ditolak'];
        }

        // Ambil data dengan paginasi 5 data per halaman
        $pesanans = Pesanan::with('user')
            ->whereIn('status', $dbStatuses)
            ->latest()
            ->paginate(5)
            ->appends(['status' => $status]); // Agar status filter tetap terbawa saat ganti halaman paginasi
            
        // Hitung total data per kategori
        $counts = [
            'Menunggu'  => Pesanan::whereIn('status', ['Diproses', 'Menunggu'])->count(),
            'Disetujui' => Pesanan::whereIn('status', ['Dicetak', 'Selesai', 'Disetujui'])->count(),
            'Ditolak'   => Pesanan::where('status', 'Ditolak')->count(),
        ];

        return view('admin.pembayaran', compact('pesanans', 'status', 'counts'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $pesanan = Pesanan::with('user')->findOrFail($id);
        
        // Ubah status ke 'Dicetak' jika disetujui, atau 'Ditolak' jika ditolak
        $isDisetujui = ($request->status === 'Disetujui');
        $pesanan->status = $isDisetujui ? 'Dicetak' : 'Ditolak';
        $pesanan->save();

        if ($isDisetujui) {
            try {
                $settings = Setting::pluck('value', 'key')->toArray();
                $recipientEmail = $pesanan->user->email ?? $pesanan->email ?? null;
                $isNotifActive = ($settings['notif_struk_email'] ?? 0) == 1;

                if ($isNotifActive && !empty($recipientEmail)) {
                    Mail::to($recipientEmail)->send(new NotifikasiPesananMail($pesanan, 'struk_pelanggan'));
                }
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email konfirmasi pembayaran: ' . $e->getMessage());
            }

            // Flash Message untuk Setuju (Mengarah ke session('success'))
            return redirect()->back()->with('success', 'Pembayaran order #' . $pesanan->order_id . ' berhasil disetujui!');
        }

        // Flash Message untuk Tolak (Mengarah ke session('error'))
        return redirect()->back()->with('error', 'Pembayaran order #' . $pesanan->order_id . ' telah ditolak.');
    }
}