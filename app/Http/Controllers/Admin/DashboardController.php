<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller; 
use App\Models\Pesanan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statistik (Card)
        $totalOrder = Pesanan::count();
        $totalProduk = Product::count();
        $totalPelanggan = User::where('role', 'customer')->count();

        // 2. Data Tabel (5 Pesanan Terbaru)
        $latestOrders = Pesanan::latest()->paginate(5);

        // 3. Data Status
        $statuses = Pesanan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statusCounts = [
            'diproses' => $statuses['diproses'] ?? $statuses['Diproses'] ?? 0,
            'dicetak'  => $statuses['dicetak'] ?? $statuses['Dicetak'] ?? 0,
            'selesai'  => $statuses['selesai'] ?? $statuses['Selesai'] ?? 0,
        ];

        // 4. Query Produk Terlaris (Hanya menghitung dari Pesanan yang SELESAI)
        // 4. Query Produk Terlaris (Hanya menghitung dari Pesanan yang SELESAI)
        $produkTerlaris = DB::table('detail_pesanan')
            ->join('products', 'detail_pesanan.product_id', '=', 'products.id') 
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id') // <-- UBAH 'pesanans' MENJADI 'pesanan'
            ->where('pesanan.status', 'selesai')                             // <-- UBAH 'pesanans.status' MENJADI 'pesanan.status'
            ->select('products.name', DB::raw('SUM(detail_pesanan.jumlah) as total_sold')) 
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalOrder', 
            'totalProduk', 
            'totalPelanggan', 
            'latestOrders', 
            'statusCounts', 
            'produkTerlaris'
        ));
    }
}