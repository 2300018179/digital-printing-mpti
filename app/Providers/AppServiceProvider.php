<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang; // Ganti dengan App\Models\Cart jika nama modelmu Cart

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
            if (Auth::check()) {
                $userId = Auth::id();
                
                // Ambil semua item keranjang milik user beserta data produknya
                // CONTOH: Ubah baris query keranjang kamu
                $cartItemsData = Keranjang::where('user_id', Auth::id())
                    ->with('product') // Eager loading produk agar tidak N+1 query
                    ->latest()        // <--- KUNCINYA DI SINI (Mengurutkan dari yang paling baru dibuat/id terbesar)
                    ->get();
                // Menghitung jumlah jenis produk/baris item yang masuk ke keranjang
                $cartCount = $cartItemsData->count();
            } else {
                $cartItemsData = collect(); // Koleksi kosong jika belum login
                $cartCount = 0;
            }

            // Kirim variabel ke Blade
            $view->with([
                'cartItemsData' => $cartItemsData,
                'cartCount'     => $cartCount
            ]);
        });
    }
}