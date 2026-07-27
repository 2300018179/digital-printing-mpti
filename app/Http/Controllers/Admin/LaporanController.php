<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller 
{
    public function index(Request $request)
    {
        // Ambil input dengan default bulan dan tahun saat ini
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        // Status pesanan yang dianggap sebagai Penjualan Valid
        $validStatus = ['selesai', 'diproses', 'dikirim']; 

        // 1. Total Penjualan
        $totalPenjualan = Pesanan::whereIn('status', $validStatus)
                                 ->whereMonth('tanggal_pesanan', $bulan)
                                 ->whereYear('tanggal_pesanan', $tahun)
                                 ->sum('total');

        // 2. Total Pesanan
        $totalPesanan = Pesanan::whereIn('status', $validStatus)
                               ->whereMonth('tanggal_pesanan', $bulan)
                               ->whereYear('tanggal_pesanan', $tahun)
                               ->count();

        // 3. Total Produk Terjual
        $produkTerjual = DetailPesanan::whereHas('pesanan', function($q) use ($bulan, $tahun, $validStatus) {
                                            $q->whereIn('status', $validStatus)
                                              ->whereMonth('tanggal_pesanan', $bulan)
                                              ->whereYear('tanggal_pesanan', $tahun);
                                        })->sum('jumlah');

        // 4. Top 5 Produk Terlaris (Perbaikan GroupBy aman untuk MySQL Strict Mode)
        $produkTerlaris = DetailPesanan::whereHas('pesanan', function($q) use ($bulan, $tahun, $validStatus) {
                                            $q->whereIn('status', $validStatus)
                                              ->whereMonth('tanggal_pesanan', $bulan)
                                              ->whereYear('tanggal_pesanan', $tahun);
                                        })
                                        ->select('nama_produk', DB::raw('SUM(jumlah) as total_qty'))
                                        ->groupBy('nama_produk')
                                        ->orderBy('total_qty', 'desc')
                                        ->limit(5)
                                        ->get();

        // 5. Rata-rata Nilai Pesanan
        $rataRataPesanan = ($totalPesanan > 0) ? ($totalPenjualan / $totalPesanan) : 0;

        // 6. Grafik Penjualan Harian
        $grafikData = Pesanan::select(
                                    DB::raw('DAY(tanggal_pesanan) as hari'),
                                    DB::raw('SUM(total) as total_harian')
                                )
                                ->whereIn('status', $validStatus)
                                ->whereMonth('tanggal_pesanan', $bulan)
                                ->whereYear('tanggal_pesanan', $tahun)
                                ->groupBy(DB::raw('DAY(tanggal_pesanan)'))
                                ->pluck('total_harian', 'hari');

        // Generasi rentang tanggal 1 s/d akhir bulan
        $jumlahHari = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $labels = [];
        $dataPoints = [];

        for ($d = 1; $d <= $jumlahHari; $d++) {
            $labels[] = (string) $d; // Hanya angka 1, 2, 3 ...
            $dataPoints[] = (int) ($grafikData[$d] ?? 0);
        }

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