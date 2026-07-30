<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Kategori;

class DashboardCSController extends Controller
{
    public function index()
    {
        // 1. Ambil kategori beserta sub-kategori
        $categories = Kategori::with('subKategoris')->get();

        // 2. Ambil 5 produk terlaris HANYA dari pesanan ber-status 'selesai'
        $products = Product::where('status', '1')
            ->withSum(['detailPesanan' => function ($query) {
                $query->whereHas('pesanan', function ($q) {
                    // Hanya hitung pesanan yang statusnya sudah 'selesai'
                    // (Sesuaikan kata 'selesai' jika di DB Anda memakai huruf kapital/istilah lain)
                    $q->where('status', 'selesai'); 
                });
            }], 'jumlah')
            ->orderByDesc('detail_pesanan_sum_jumlah')
            ->take(5)
            ->get();

        // 3. Ambil settings dari database
        $appSettings = DB::table('settings')->pluck('value', 'key')->toArray();

        // 4. Kirim data ke view
        return view('customer.dashboard', compact('categories', 'products', 'appSettings'));
    }
}