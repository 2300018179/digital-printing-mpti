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
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $validStatus = ['selesai', 'dp', 'lunas']; 

        // PERBAIKAN: Hitung 50% jika status DP, hitung 100% jika Selesai/Lunas
        $totalPenjualan = Pesanan::whereIn('status', $validStatus)
                                 ->whereMonth('tanggal_pesanan', $bulan)
                                 ->whereYear('tanggal_pesanan', $tahun)
                                 ->selectRaw("SUM(CASE WHEN status = 'dp' THEN total * 0.5 ELSE total END) as total_real")
                                 ->value('total_real') ?? 0;

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

        // PERBAIKAN: Hitung grafik berdasarkan status DP
        $grafikData = Pesanan::select(
                                    DB::raw('DAY(tanggal_pesanan) as hari'),
                                    DB::raw("SUM(CASE WHEN status = 'dp' THEN total * 0.5 ELSE total END) as total_harian")
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
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));
        $validStatus = ['selesai', 'dp', 'lunas'];

        $totalPenjualan = Pesanan::whereIn('status', $validStatus)
                                 ->whereMonth('tanggal_pesanan', $bulan)
                                 ->whereYear('tanggal_pesanan', $tahun)
                                 ->selectRaw("SUM(CASE WHEN status = 'dp' THEN total * 0.5 ELSE total END) as total_real")
                                 ->value('total_real') ?? 0;

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

        $grafikData = Pesanan::select(
                                    DB::raw('DAY(tanggal_pesanan) as hari'),
                                    DB::raw("SUM(CASE WHEN status = 'dp' THEN total * 0.5 ELSE total END) as total_harian")
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

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $pdf = Pdf::loadView('admin.laporan_pdf', compact(
            'totalPenjualan', 
            'totalPesanan', 
            'produkTerjual', 
            'produkTerlaris', 
            'rataRataPesanan', 
            'bulan', 
            'tahun',
            'namaBulan',
            'labels',
            'dataPoints'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Penjualan_' . $namaBulan[$bulan] . '_' . $tahun . '.pdf');
    }

    public function cetakExcel(Request $request)
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));
        $validStatus = ['selesai', 'dp', 'lunas'];

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $fileName = "Laporan_Penjualan_" . $namaBulan[$bulan] . "_{$tahun}.xls";

        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($bulan, $tahun, $validStatus, $namaBulan) {
            echo '
            <table border="1">
                <thead>
                    <tr>
                        <th colspan="7" style="font-size: 16px; font-weight: bold; text-align: center;">LAPORAN PENJUALAN - FANTASTIC DIGITAL PRINTING</th>
                    </tr>
                    <tr>
                        <th colspan="7" style="text-align: center;">Periode: ' . $namaBulan[(int)$bulan] . ' ' . $tahun . '</th>
                    </tr>
                    <tr><th colspan="7"></th></tr>
                    <tr style="background-color: #f3f4f6; font-weight: bold;">
                        <th>No</th>
                        <th>No Order</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th>Grand Total</th>
                        <th>Real Uang Masuk</th>
                    </tr>
                </thead>
                <tbody>';
            
            $totalKeseluruhan = 0;
            $index = 1;

            $query = Pesanan::whereIn('status', $validStatus)
                ->whereMonth('tanggal_pesanan', $bulan)
                ->whereYear('tanggal_pesanan', $tahun)
                ->latest('tanggal_pesanan');

            foreach ($query->cursor() as $p) {
                // PERBAIKAN: Hitung nominal masuk secara dinamis berdasarkan status DP
                $uangMasuk = ($p->status === 'dp') ? ($p->total * 0.5) : $p->total;
                $totalKeseluruhan += $uangMasuk;

                echo '
                    <tr>
                        <td style="text-align: center;">' . $index++ . '</td>
                        <td>' . $p->order_id . '</td>
                        <td>' . date('d/m/Y', strtotime($p->tanggal_pesanan)) . '</td>
                        <td>' . $p->nama_pelanggan . '</td>
                        <td>' . strtoupper($p->status) . '</td>
                        <td style="text-align: right;">' . number_format($p->total, 0, ',', '.') . '</td>
                        <td style="text-align: right; font-weight: bold;">' . number_format($uangMasuk, 0, ',', '.') . '</td>
                    </tr>';
            }

            echo '
                    <tr style="background-color: #fee2e2; font-weight: bold;">
                        <td colspan="6" style="text-align: right;">TOTAL UANG MASUK REAL:</td>
                        <td style="text-align: right;">Rp ' . number_format($totalKeseluruhan, 0, ',', '.') . '</td>
                    </tr>
                </tbody>
            </table>';
        };

        return response()->stream($callback, 200, $headers);
    }
}