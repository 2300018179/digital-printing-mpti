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

        // HANYA menghitung status 'selesai'
        $validStatus = ['selesai']; 

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
        $validStatus = ['selesai'];

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
        $validStatus = ['selesai'];

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Ambil data pesanan sesuai bulan, tahun, dan HANYA status selesai
        $pesanans = Pesanan::with('items')
            ->whereIn('status', $validStatus)
            ->whereMonth('tanggal_pesanan', $bulan)
            ->whereYear('tanggal_pesanan', $tahun)
            ->latest('tanggal_pesanan')
            ->get();

        $fileName = "Laporan_Penjualan_" . $namaBulan[$bulan] . "_{$tahun}.xls";

        $headers = [
            "Content-Type" => "application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($pesanans, $bulan, $tahun, $namaBulan) {
            echo '
            <table border="1">
                <thead>
                    <tr>
                        <th colspan="6" style="font-size: 16px; font-weight: bold; text-align: center;">LAPORAN PENJUALAN - FANTASTIC DIGITAL PRINTING</th>
                    </tr>
                    <tr>
                        <th colspan="6" style="text-align: center;">Periode: ' . $namaBulan[(int)$bulan] . ' ' . $tahun . '</th>
                    </tr>
                    <tr><th colspan="6"></th></tr>
                    <tr style="background-color: #f3f4f6; font-weight: bold;">
                        <th>No</th>
                        <th>No Order</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th>Total Pembayaran</th>
                    </tr>
                </thead>
                <tbody>';
            
            $totalKeseluruhan = 0;
            foreach ($pesanans as $index => $p) {
                $totalKeseluruhan += $p->total;
                echo '
                    <tr>
                        <td style="text-align: center;">' . ($index + 1) . '</td>
                        <td>' . $p->order_id . '</td>
                        <td>' . date('d/m/Y', strtotime($p->tanggal_pesanan)) . '</td>
                        <td>' . $p->nama_pelanggan . '</td>
                        <td>' . $p->status . '</td>
                        <td style="text-align: right;">' . number_format($p->total, 0, ',', '.') . '</td>
                    </tr>';
            }

            echo '
                    <tr style="background-color: #fee2e2; font-weight: bold;">
                        <td colspan="5" style="text-align: right;">TOTAL PENJUALAN:</td>
                        <td style="text-align: right;">Rp ' . number_format($totalKeseluruhan, 0, ',', '.') . '</td>
                    </tr>
                </tbody>
            </table>';
        };

        return response()->stream($callback, 200, $headers);
    }
}