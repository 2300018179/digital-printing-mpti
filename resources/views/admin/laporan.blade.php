@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Fantastic Digital Printing')

@section('content')
<div class="flex flex-col max-w-7xl space-y-6">

    {{-- Header Halaman --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">Laporan Penjualan</h2>
        <p class="text-xs text-gray-500 mt-1">Ringkasan performa penjualan, statistik pesanan, dan tren grafik harian.</p>
    </div>

    {{-- Filter Bulan & Tahun --}}
    <form action="{{ route('admin.laporan') }}" method="GET" class="bg-white border border-red-200 p-4 rounded-2xl flex flex-wrap gap-4 items-center shadow-sm w-fit">
        @php
            $namaBulan = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            // Daftar Tahun 2026 s/d 2031
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

    {{-- Stat Cards (4 Kolom) --}}
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

    {{-- Box Produk Terlaris --}}
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

    {{-- Grafik Penjualan Harian --}}
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