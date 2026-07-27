<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <--- 1. Pastikan facade DB di-import
use App\Models\Keranjang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Membagikan data ke seluruh file blade (* berarti global)
        View::composer('*', function ($view) {
            // Ambil data settings dari database
            $appSettings = DB::table('settings')->pluck('value', 'key')->toArray(); // <--- 2. Tambahkan ini

            if (Auth::check()) {
                $userId = Auth::id();
                
                // Ambil semua item keranjang milik user beserta data produknya
                $cartItemsData = Keranjang::where('user_id', Auth::id())
                    ->with('product')
                    ->latest()
                    ->get();

                // Menghitung jumlah jenis produk/baris item yang masuk ke keranjang
                $cartCount = $cartItemsData->count();
            } else {
                $cartItemsData = collect(); // Koleksi kosong jika belum login
                $cartCount = 0;
            }

            // Kirim variabel ke Blade
            $view->with([
                'settings'      => $appSettings, // <--- TAMBAHKAN BARIS INI
                'appSettings'   => $appSettings, 
                'cartItemsData' => $cartItemsData,
                'cartCount'     => $cartCount
            ]);
        });
    }
}