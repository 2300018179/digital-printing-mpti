@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Fantastic Digital Printing')

@section('content')
<div class="flex flex-col max-w-7xl space-y-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">Laporan Penjualan</h2>
        <p class="text-xs text-gray-500 mt-1">Ringkasan performa penjualan, statistik pesanan, dan tren grafik harian.</p>
    </div>
    <div class="flex flex-wrap items-center justify-between gap-4 bg-white border border-red-200 p-4 rounded-2xl shadow-sm">
        <form action="{{ route('admin.laporan') }}" method="GET" class="flex flex-wrap gap-4 items-center">
            @php
                $namaBulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                $daftarTahun = range(2026, 2031);
            @endphp
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-gray-600">Bulan:</span>
                <select name="bulan" class="px-3 py-2 border border-gray-300 focus:border-red-600 text-xs rounded-xl font-bold text-gray-700 focus:outline-none transition">
                    @foreach($namaBulan as $m => $bulanText)
                        <option value="{{ $m }}" {{ (int)$bulan === $m ? 'selected' : '' }}>
                            {{ $bulanText }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold text-gray-600">Tahun:</span>
                <select name="tahun" class="px-3 py-2 border border-gray-300 focus:border-red-600 text-xs rounded-xl font-bold text-gray-700 focus:outline-none transition">
                    @foreach($daftarTahun as $y)
                        <option value="{{ $y }}" {{ (int)$tahun === $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-5 py-2 bg-red-700 hover:bg-red-800 text-white text-xs font-bold rounded-xl transition shadow-sm active:scale-95">
                Tampilkan
            </button>
        </form>
        <div class="flex items-center gap-2">
            {{-- Tombol PDF --}}
            <a href="{{ route('admin.laporan.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="px-4 py-2 bg-red-700 hover:bg-red-800 text-white text-xs font-bold rounded-xl transition shadow-sm active:scale-95 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
                </svg>
                Cetak PDF
            </a>
            <a href="{{ route('admin.laporan.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="px-4 py-2 bg-red-700 hover:bg-red-800 text-white text-xs font-bold rounded-xl transition shadow-sm active:scale-95 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                Cetak Excel
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-red-200 p-5 rounded-2xl shadow-sm">
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Total Penjualan</p>
            <h3 class="text-lg font-bold text-red-700 mt-1">Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white border border-red-200 p-5 rounded-2xl shadow-sm">
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Total Pesanan</p>
            <h3 class="text-lg font-bold text-gray-800 mt-1">{{ $totalPesanan ?? 0 }}</h3>
        </div>
        <div class="bg-white border border-red-200 p-5 rounded-2xl shadow-sm">
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Produk Terjual</p>
            <h3 class="text-lg font-bold text-gray-800 mt-1">{{ $produkTerjual ?? 0 }} pcs</h3>
        </div>
        <div class="bg-white border border-red-200 p-5 rounded-2xl shadow-sm">
            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Rata-rata / Pesanan</p>
            <h3 class="text-lg font-bold text-gray-800 mt-1">Rp {{ number_format($rataRataPesanan ?? 0, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="bg-white border border-red-200 rounded-2xl p-6 shadow-sm">
        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4 border-b pb-3 border-gray-100 flex items-center gap-2">
            <span>🔥</span> Produk Terlaris
        </h4>
        <ul class="divide-y divide-gray-100 text-xs">
            @forelse($produkTerlaris ?? [] as $index => $prod)
            <li class="py-3 flex justify-between items-center hover:bg-gray-50 px-3 rounded-lg transition">
                <span class="font-medium text-gray-700">{{ $index + 1 }}. {{ $prod->nama_produk }}</span>
                <span class="font-bold text-red-700 bg-red-50 px-3 py-1 rounded-full border border-red-100">
                    {{ $prod->total_qty }} pcs
                </span>
            </li>
            @empty
            <li class="py-4 text-gray-400 italic text-center">Belum ada data penjualan pada periode ini.</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white border border-red-200 p-6 rounded-2xl shadow-sm">
        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4 border-b pb-3 border-gray-100 flex items-center gap-2">
            <span>📈</span> Grafik Penjualan Harian
        </h4>
        <div class="relative w-full" style="height: 250px;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels ?? []) !!}, 
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: {!! json_encode($dataPoints ?? []) !!}, 
                    backgroundColor: '#b91c1c', 
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return 'Tanggal ' + context[0].label;
                            },
                            label: function(context) {
                                let value = context.raw || 0;
                                return ' Penjualan: Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: { borderDash: [4, 4] },
                        ticks: { 
                            font: { size: 10 },
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        title: {
                            display: true,
                            text: 'Tanggal',
                            font: { size: 11, weight: 'bold' },
                            color: '#4b5563'
                        },
                        ticks: { font: { size: 10 } }
                    }
                }
            }
        });
    });
</script>
@endpush