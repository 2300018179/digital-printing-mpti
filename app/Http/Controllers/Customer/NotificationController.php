<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Promo;
use App\Models\Pengumuman;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationController extends Controller
{
    /**
     * Menampilkan halaman Pusat Notifikasi
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $notificationsList = collect();

        // Ambil daftar ID notifikasi yang sudah dibaca oleh user dari session
        $readIds = session()->get("read_notifications_{$userId}", []);

        // 1. AMBIL NOTIFIKASI DARI STATUS PESANAN
        if ($userId) {
            $pesanans = Pesanan::where('user_id', $userId)->latest()->get();
            foreach ($pesanans as $pesanan) {
                $id = 'order_' . $pesanan->id;
                
                $pesan = "Pesanan Anda <strong>#{$pesanan->order_id}</strong> saat ini berstatus: <span class='font-semibold text-brandRed'>{$pesanan->status}</span>.";
                if ($pesanan->status === 'Selesai') {
                    $pesan = "Pesanan <strong>#{$pesanan->order_id}</strong> telah selesai dan siap diambil/dikirim!";
                } elseif ($pesanan->status === 'Dicetak') {
                    $pesan = "Pesanan <strong>#{$pesanan->order_id}</strong> sedang dalam proses pencetakan oleh tim kami.";
                }

                $notificationsList->push([
                    'id'          => $id,
                    'created_at'  => $pesanan->updated_at ?? $pesanan->created_at,
                    'read_at'     => in_array($id, $readIds) ? now() : null,
                    'data' => [
                        'type'        => 'pesanan',
                        'title'       => 'Update Status Pesanan',
                        'message'     => $pesan,
                        'url'         => route('customer.pesanan-saya'),
                        'action_text' => 'Cek Pesanan Saya'
                    ]
                ]);
            }
        }

        // 2. AMBIL NOTIFIKASI PROMO AKTIF
        $promos = Promo::where('status', 'Aktif')->latest()->get();
        foreach ($promos as $promo) {
            $id = 'promo_' . $promo->id;

            $notificationsList->push([
                'id'          => $id,
                'created_at'  => $promo->created_at,
                'read_at'     => in_array($id, $readIds) ? now() : null,
                'data' => [
                    'type'        => 'promo',
                    'title'       => $promo->judul ?? $promo->nama_promo ?? 'Promo Spesial Cetak!',
                    'message'     => $promo->deskripsi ?? 'Ada promo menarik untuk kamu, cek sekarang sebelum kehabisan!',
                    'url'         => route('customer.promo'),
                    'action_text' => 'Lihat Promo'
                ]
            ]);
        }

        // 3. AMBIL NOTIFIKASI PENGUMUMAN / INFORMASI TERBARU
        $pengumumans = Pengumuman::where('status', 'Aktif')->latest()->get();
        foreach ($pengumumans as $info) {
            $id = 'info_' . $info->id;

            $notificationsList->push([
                'id'          => $id,
                'created_at'  => $info->created_at,
                'read_at'     => in_array($id, $readIds) ? now() : null,
                'data' => [
                    'type'        => 'info',
                    'title'       => $info->judul ?? 'Informasi Terbaru Toko',
                    'message'     => $info->isi ?? $info->keterangan ?? 'Ada pengumuman terbaru dari Fantastic Digital Printing.',
                    'url'         => route('customer.informasi'),
                    'action_text' => 'Baca Selengkapnya'
                ]
            ]);
        }

        // 4. FITUR FILTER "BELUM DIBACA"
        if ($request->get('filter') === 'unread') {
            $notificationsList = $notificationsList->filter(function ($item) {
                return is_null($item['read_at']);
            });
        }

        // 5. URUTKAN SEMUA NOTIFIKASI BERDASARKAN TANGGAL TERBARU
        $sortedList = $notificationsList->sortByDesc('created_at')->values();

        // 6. PAGINASI DATA
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $sortedList->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $formattedItems = collect($currentItems)->map(function ($item) {
            return (object) [
                'id'         => $item['id'],
                'created_at' => \Carbon\Carbon::parse($item['created_at']),
                'read_at'    => $item['read_at'],
                'data'       => $item['data']
            ];
        });

        $notifications = new LengthAwarePaginator(
            $formattedItems,
            $sortedList->count(),
            $perPage,
            $currentPage,
            [
                'path'  => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query() // Mempertahankan query parameter saat paginasi (seperti ?filter=unread)
            ]
        );

        return view('customer.notifikasi', compact('notifications'));
    }

    /**
     * =============================================================
     * METHOD BARU: Tandai Satu Notifikasi Dibaca Lalu Redirect
     * =============================================================
     */
    public function readAndRedirect(Request $request, $id)
    {
        $userId = auth()->id();
        $targetUrl = $request->get('target', route('customer.notifikasi'));

        if ($userId) {
            $readIds = session()->get("read_notifications_{$userId}", []);
            
            // Masukkan ID notifikasi ke daftar session jika belum ada
            if (!in_array($id, $readIds)) {
                $readIds[] = $id;
                session()->put("read_notifications_{$userId}", $readIds);
            }
        }

        return redirect()->to($targetUrl);
    }

    /**
     * Tandai Semua Notifikasi Sudah Dibaca
     */
    public function markAllRead()
    {
        $userId = auth()->id();
        $readIds = [];

        // Kumpulkan semua ID notifikasi yang ada
        if ($userId) {
            $pesananIds = Pesanan::where('user_id', $userId)->pluck('id')->map(fn($id) => 'order_' . $id)->toArray();
            $readIds = array_merge($readIds, $pesananIds);
        }

        $promoIds = Promo::where('status', 'Aktif')->pluck('id')->map(fn($id) => 'promo_' . $id)->toArray();
        $infoIds = Pengumuman::where('status', 'Aktif')->pluck('id')->map(fn($id) => 'info_' . $id)->toArray();

        $readIds = array_merge($readIds, $promoIds, $infoIds);

        // Simpan seluruh ID ke dalam session user
        session()->put("read_notifications_{$userId}", $readIds);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}