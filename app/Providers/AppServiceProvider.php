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

                // 2. Data Notifikasi Unread (Session Read IDs)
                $readIds = session()->get("read_notifications_{$userId}", []);

                // Hitung Unread Promo
                $promoIds = Promo::where('status', 'Aktif')->pluck('id')->map(fn($id) => 'promo_' . $id)->toArray();
                $promoNotifCount = count(array_diff($promoIds, $readIds));

                // Hitung Unread Info/Pengumuman
                $infoIds = Pengumuman::where('status', 'Aktif')->pluck('id')->map(fn($id) => 'info_' . $id)->toArray();
                $infoNotifCount = count(array_diff($infoIds, $readIds));

                // Hitung Unread Pesanan (jika notifikasi pesanan pakai session juga)
                $orderIds = Pesanan::where('user_id', $userId)->pluck('id')->map(fn($id) => 'order_' . $id)->toArray();
                $orderUnreadCount = count(array_diff($orderIds, $readIds));

                // Total Notifikasi Unread untuk Lonceng Atas
                $unreadNotificationsCount = $orderUnreadCount + $promoNotifCount + $infoNotifCount;

                // 3. Total Pesanan User (untuk badge tab pesanan)
                $orderNotifCount = Pesanan::where('user_id', $userId)->count();

            } else {
                $cartItemsData = collect();
                $cartCount = 0;
                $unreadNotificationsCount = 0;
                $orderNotifCount = 0;
                $promoNotifCount = 0; // <-- Tambahkan default
                $infoNotifCount = 0;  // <-- Tambahkan default
            }

            $view->with([
                'settings'                 => $appSettings,
                'appSettings'              => $appSettings, 
                'cartItemsData'            => $cartItemsData,
                'cartCount'                => $cartCount,
                'unreadNotificationsCount' => $unreadNotificationsCount,
                'orderNotifCount'          => $orderNotifCount,
                'promoNotifCount'          => $promoNotifCount, // <-- Kirim ke View
                'infoNotifCount'           => $infoNotifCount,  // <-- Kirim ke View
            ]);
        });
    }
}