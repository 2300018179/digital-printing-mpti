<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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

        // 4. Top 5 Produk Terlaris
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
            $labels[] = (string) $d;
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

    public function cetakPdf(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));
        $validStatus = ['selesai', 'diproses', 'dikirim'];

        $totalPenjualan = Pesanan::whereIn('status', $validStatus)
                                 ->whereMonth('tanggal_pesanan', $bulan)
                                 ->whereYear('tanggal_pesanan', $tahun)
                                 ->sum('total');

        $totalPesanan = Pesanan::whereIn('status', $validStatus)
                               ->whereMonth('tanggal_pesanan', $bulan)
                               ->whereYear('tanggal_pesanan', $tahun)
                               ->count();

        $produkTerjual = DetailPesanan::whereHas('pesanan', function($q) use ($bulan, $tahun, $validStatus) {
                                            $q->whereIn('status', $validStatus)
                                              ->whereMonth('tanggal_pesanan', $bulan)
                                              ->whereYear('tanggal_pesanan', $tahun);
                                        })->sum('jumlah');

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

        $rataRataPesanan = ($totalPesanan > 0) ? ($totalPenjualan / $totalPesanan) : 0;

        // --- 1. TAMBAHKAN KODE INI UNTUK GRAFIK ---
        $grafikData = Pesanan::select(
                                    DB::raw('DAY(tanggal_pesanan) as hari'),
                                    DB::raw('SUM(total) as total_harian')
                                )
                                ->whereIn('status', $validStatus)
                                ->whereMonth('tanggal_pesanan', $bulan)
                                ->whereYear('tanggal_pesanan', $tahun)
                                ->groupBy(DB::raw('DAY(tanggal_pesanan)'))
                                ->pluck('total_harian', 'hari');

        $jumlahHari = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $labels = [];
        $dataPoints = [];

        for ($d = 1; $d <= $jumlahHari; $d++) {
            $labels[] = (string) $d;
            $dataPoints[] = (int) ($grafikData[$d] ?? 0);
        }
        // ------------------------------------------

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // --- 2. TAMBAHKAN 'labels' DAN 'dataPoints' DI COMPACT ---
        $pdf = Pdf::loadView('admin.laporan_pdf', compact(
            'totalPenjualan', 
            'totalPesanan', 
            'produkTerjual', 
            'produkTerlaris', 
            'rataRataPesanan', 
            'bulan', 
            'tahun',
            'namaBulan',
            'labels',      // <-- Ditambahkan
            'dataPoints'   // <-- Ditambahkan
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Penjualan_' . $namaBulan[$bulan] . '_' . $tahun . '.pdf');
    }
}