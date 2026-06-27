<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input dengan default bulan dan tahun saat ini
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        // Pastikan variabel didefinisikan dengan nilai awal 0
        $totalPenjualan = \App\Models\Pesanan::whereMonth('created_at', $bulan)
                                         ->whereYear('created_at', $tahun)
                                         ->sum('total');

        $totalPesanan = \App\Models\Pesanan::whereMonth('created_at', $bulan)
                                        ->whereYear('created_at', $tahun)
                                        ->count();

        $produkTerjual = \App\Models\DetailPesanan::whereHas('pesanan', function($q) use ($bulan, $tahun) {
                                                    $q->whereMonth('created_at', $bulan)
                                                    ->whereYear('created_at', $tahun);
                                                })->sum('jumlah');

        $produkTerlaris = \App\Models\DetailPesanan::whereHas('pesanan', function($q) use ($bulan, $tahun) {
                                                $q->whereMonth('created_at', $bulan)
                                                  ->whereYear('created_at', $tahun);
                                            })->select('nama_produk', \DB::raw('SUM(jumlah) as total_qty'))
                                              ->groupBy('nama_produk')
                                              ->orderBy('total_qty', 'desc')
                                              ->limit(5)
                                              ->get();

        $jumlahPesanan = \App\Models\Pesanan::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        $rataRataPesanan = ($totalPesanan > 0) ? ($totalPenjualan / $totalPesanan) : 0;

        // Mengambil data penjualan per hari dalam bulan yang dipilih
        $grafikData = \App\Models\Pesanan::select(
            \Illuminate\Support\Facades\DB::raw('DAY(created_at) as hari'),
            \Illuminate\Support\Facades\DB::raw('SUM(total) as total_harian')
            )
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy('hari')
            ->orderBy('hari', 'ASC')
            ->get();

        // Format agar siap dikonsumsi oleh Chart.js
        $labels = $grafikData->pluck('hari');
        $dataPoints = $grafikData->pluck('total_harian');$grafikData = \App\Models\Pesanan::select(\DB::raw('DAY(created_at) as hari'), \DB::raw('SUM(total) as total_harian'))
                                     ->whereMonth('created_at', $bulan)
                                     ->whereYear('created_at', $tahun)
                                     ->groupBy('hari')
                                     ->orderBy('hari', 'ASC')
                                     ->get();

        $labels = $grafikData->pluck('hari');
        $dataPoints = $grafikData->pluck('total_harian');

        // Kirim semua variabel ke view
        return view('admin.laporan', compact(
            'totalPenjualan', 
            'totalPesanan', 
            'produkTerjual', 
            'produkTerlaris', 
            'rataRataPesanan', 
            'labels', 
            'dataPoints', 
            'bulan', 
            'tahun'
        ));
    }
}