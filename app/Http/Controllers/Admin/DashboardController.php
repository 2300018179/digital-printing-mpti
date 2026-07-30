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
        $totalOrder = Pesanan::count();
        $totalProduk = Product::count();
        $totalPelanggan = User::where('role', 'customer')->count();

        $latestOrders = Pesanan::latest()->paginate(5);

        $statuses = Pesanan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statusCounts = [
            'diproses'  => $statuses['diproses'] ?? $statuses['Diproses'] ?? 0,
            'dicetak'   => $statuses['dicetak'] ?? $statuses['Dicetak'] ?? 0,
            'selesai'   => $statuses['selesai'] ?? $statuses['Selesai'] ?? 0,
            'batal'     => $statuses['batal'] ?? $statuses['Batal'] ?? $statuses['dibatalkan'] ?? $statuses['Dibatalkan'] ?? 0,
        ];

        $produkTerlaris = DB::table('detail_pesanan')
            ->join('products', 'detail_pesanan.product_id', '=', 'products.id') 
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->where('pesanan.status', 'selesai')
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