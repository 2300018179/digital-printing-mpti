<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statistik (Card)
        $totalOrder = Pesanan::count();
        $totalProduk = Product::count();
        $totalPelanggan = User::where('role', 'customer')->count();

        // 2. Data Tabel (5 Pesanan Terbaru)
        $latestOrders = Pesanan::latest()->paginate(5);

        // 3. Data Status (Untuk grafik/list status)
        $statusCounts = [
            'menunggu' => Pesanan::where('status', 'menunggu')->count(),
            'diproses' => Pesanan::where('status', 'diproses')->count(),
            'dicetak'  => Pesanan::where('status', 'dicetak')->count(),
            'dikirim'  => Pesanan::where('status', 'dikirim')->count(),
            'selesai'  => Pesanan::where('status', 'selesai')->count(),
        ];

        // Query Produk Terlaris
        $produkTerlaris = DB::table('detail_pesanan')
            ->join('products', 'detail_pesanan.nama_produk', '=', 'products.name') // Sesuaikan join ini jika menggunakan nama produk
            ->select('products.name', DB::raw('SUM(detail_pesanan.jumlah) as total_sold')) // Ganti 'quantity' menjadi 'jumlah'
            ->groupBy('products.name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact('totalOrder', 'totalProduk', 'totalPelanggan', 'latestOrders', 'statusCounts', 'produkTerlaris'));
    }
}