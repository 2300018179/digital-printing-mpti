<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - {{ $namaBulan[$bulan] }} {{ $tahun }}</title>
    <style>
        body { font-family: sans-serif; color: #333; font-size: 11px; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #b91c1c; padding-bottom: 6px; }
        .header h2 { margin: 0; color: #b91c1c; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 2px 0 0; color: #666; font-size: 10px; }
        .stats-table { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .stats-table td { width: 50%; padding: 4px; vertical-align: top; }
        .card { border: 1px solid #fca5a5; background-color: #fff5f5; padding: 8px 10px; border-radius: 5px; }
        .card-title { font-size: 9px; text-transform: uppercase; color: #7f1d1d; font-weight: bold; }
        .card-value { font-size: 13px; font-weight: bold; color: #991b1b; margin-top: 2px; }
        .section-title { font-size: 11px; font-weight: bold; margin-bottom: 8px; color: #1f2937; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; padding-bottom: 3px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 5px; margin-bottom: 15px; }
        table.data-table th, table.data-table td { border: 1px solid #e5e7eb; padding: 6px; text-align: left; }
        table.data-table th { background-color: #f87171; color: white; font-size: 10px; text-transform: uppercase; }
        table.data-table tr:nth-child(even) { background-color: #f9fafb; }
        .chart-box {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px 5px 5px 5px;
            margin-bottom: 15px;
            background-color: #ffffff;
        }
        .chart-table { width: 100%; border-collapse: collapse; }
        .chart-cell { vertical-align: bottom; text-align: center; height: 90px; padding: 0 1px; }
        .bar-area { height: 75px; width: 100%; position: relative; }
        .bar-area table { width: 100%; height: 100%; border-collapse: collapse; }
        .bar-area td { vertical-align: bottom; text-align: center; padding: 0; }
        .bar-fill {
            background-color: #b91c1c;
            width: 70%;
            margin: 0 auto;
            border-radius: 2px 2px 0 0;
            display: block;
        }
        .x-label { font-size: 8px; color: #4b5563; border-top: 1px solid #d1d5db; padding-top: 3px; margin-top: 2px; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Fantastic Digital Printing</h2>
        <p>Laporan Penjualan Periode: <strong>{{ $namaBulan[$bulan] }} {{ $tahun }}</strong></p>
    </div>
    <div class="section-title">Ringkasan Statistik</div>
    <table class="stats-table">
        <tr>
            <td>
                <div class="card">
                    <div class="card-title">Total Penjualan</div>
                    <div class="card-value">Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</div>
                </div>
            </td>
            <td>
                <div class="card">
                    <div class="card-title">Total Pesanan</div>
                    <div class="card-value">{{ $totalPesanan ?? 0 }} Transaksi</div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="card">
                    <div class="card-title">Produk Terjual</div>
                    <div class="card-value">{{ $produkTerjual ?? 0 }} pcs</div>
                </div>
            </td>
            <td>
                <div class="card">
                    <div class="card-title">Rata-rata / Pesanan</div>
                    <div class="card-value">Rp {{ number_format($rataRataPesanan ?? 0, 0, ',', '.') }}</div>
                </div>
            </td>
        </tr>
    </table>
    @php
        $maxVal = max($dataPoints ?? [0]);
        if ($maxVal <= 0) { $maxVal = 1; }
        $chartHeight = 75; // Tinggi maksimal grafik dalam pixel (px)
    @endphp
    <div class="section-title">Grafik Penjualan Harian (Rp)</div>
    <div style="border: 1px solid #e5e7eb; border-radius: 6px; padding: 10px 5px 5px 5px; margin-bottom: 15px; background: #fff;">
        <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
            {{-- BARIS 1: AREA BATANG (VALIGN BOTTOM AGAR NEMPEL KEBOWA) --}}
            <tr style="height: {{ $chartHeight }}px;">
                @foreach($labels ?? [] as $idx => $tgl)
                    @php
                        $val = $dataPoints[$idx] ?? 0;
                        $barHeight = ($val > 0) ? max(round(($val / $maxVal) * $chartHeight), 3) : 0;
                        $spaceHeight = $chartHeight - $barHeight;
                    @endphp
                    <td style="vertical-align: bottom; text-align: center; padding: 0;">
                        @if($barHeight > 0)
                            {{-- Ruang Kosong Atas --}}
                            <div style="height: {{ $spaceHeight }}px;"></div>
                            {{-- Batang Merah Bawah --}}
                            <div style="height: {{ $barHeight }}px; background-color: #b91c1c; width: 70%; margin: 0 auto; border-radius: 2px 2px 0 0;"></div>
                        @else
                            <div style="height: {{ $chartHeight }}px;"></div>
                        @endif
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach($labels ?? [] as $tgl)
                    <td style="text-align: center; border-top: 1px solid #d1d5db; padding-top: 4px; font-size: 7.5px; color: #4b5563;">
                        {{ $tgl }}
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
    <div class="section-title">Top 5 Produk Terlaris</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 10%; text-align: center;">NO</th>
                <th style="width: 65%;">NAMA PRODUK</th>
                <th style="width: 25%; text-align: right;">TOTAL TERJUAL</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produkTerlaris ?? [] as $index => $prod)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $prod->nama_produk }}</td>
                <td style="text-align: right; font-weight: bold;">{{ $prod->total_qty }} pcs</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; color: #9ca3af; font-style: italic;">Belum ada data penjualan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i') }} WIB
    </div>
</body>
</html>