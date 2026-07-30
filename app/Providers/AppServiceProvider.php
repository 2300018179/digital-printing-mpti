<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Promo;
use App\Models\Pengumuman;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $appSettings = DB::table('settings')->pluck('value', 'key')->toArray();

            if (Auth::check()) {
                $userId = Auth::id();
                
                // 1. Keranjang
                $cartItemsData = Keranjang::where('user_id', $userId)
                    ->with('product')
                    ->latest()
                    ->get();
                $cartCount = $cartItemsData->count();

                // 2. Total Notifikasi Unread (Lonceng Atas)
                $readIds = session()->get("read_notifications_{$userId}", []);
                $orderIds = Pesanan::where('user_id', $userId)->pluck('id')->map(fn($id) => 'order_' . $id)->toArray();
                $promoIds = Promo::where('status', 'Aktif')->pluck('id')->map(fn($id) => 'promo_' . $id)->toArray();
                $infoIds  = Pengumuman::where('status', 'Aktif')->pluck('id')->map(fn($id) => 'info_' . $id)->toArray();

                $allNotifIds = array_merge($orderIds, $promoIds, $infoIds);
                $unreadNotificationsCount = count(array_diff($allNotifIds, $readIds));

                // 3. JUMLAH PESANAN (Berdasarkan Total Transaksi Pesanan User)
                $orderNotifCount = Pesanan::where('user_id', $userId)->count(); 
                // *Catatan: Jika hanya ingin hitung pesanan yang sedang diproses, ganti baris atas dengan:
                // $orderNotifCount = Pesanan::where('user_id', $userId)->whereNotIn('status', ['Selesai', 'Batal'])->count();

            } else {
                $cartItemsData = collect();
                $cartCount = 0;
                $unreadNotificationsCount = 0;
                $orderNotifCount = 0;
            }

            $view->with([
                'settings'                 => $appSettings,
                'appSettings'              => $appSettings, 
                'cartItemsData'            => $cartItemsData,
                'cartCount'                => $cartCount,
                'unreadNotificationsCount' => $unreadNotificationsCount,
                'orderNotifCount'          => $orderNotifCount, // Pass ke view
            ]);
        });
    }
}