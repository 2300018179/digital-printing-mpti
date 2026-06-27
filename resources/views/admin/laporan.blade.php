<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 object-contain">
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-gray-700">Selamat Datang, <strong class="text-gray-900">Admin</strong></span>
            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300">
                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
        </div>
    </header>

    <div class="flex flex-1">
        <aside class="w-64 bg-red-700 text-white flex flex-col justify-between min-h-[calc(100vh-57px)] sticky top-[57px]">
            <div class="py-4">
                <nav class="space-y-1 px-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🏠</span> Dashboard
                    </a>
                    <a href="{{ route('admin.produk') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🛍️</span> Produk
                    </a>
                    <a href="{{ route('admin.kategori') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🏷️</span> Kategori
                    </a>
                    <a href="{{ route('admin.pesanan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>📦</span> Pesanan
                    </a>
                    <a href="{{ route('admin.pembayaran') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>💳</span> Pembayaran
                    </a>
                    <a href="{{ route('admin.promo') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>%</span> Promo
                    </a>
                    <a href="{{ route('admin.pelanggan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
                        <span>👥</span> Pelanggan
                    </a>
                    <a href="{{ route('admin.laporan') }}" class="bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>📊</span> Laporan
                    </a>
                    <a href="{{ route('admin.pengaturan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>⚙️</span> Pengaturan
                    </a>
                </nav>
            </div>
            <div class="p-3 border-t border-red-800">
                <a href="#" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold bg-red-900 hover:bg-red-950 transition text-center justify-center uppercase tracking-wider">
                    <span>🚪</span> Log Out
                </a>
            </div>
        </aside>

        <main class="flex-1 p-8 space-y-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">Laporan Penjualan</h2>
            </div>

            <form action="{{ route('admin.laporan') }}" method="GET" class="bg-white border p-4 rounded-2xl flex gap-4 items-center">
                <select name="bulan" class="px-3 py-2 border border-red-400 rounded-xl font-bold focus:outline-none">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ (isset($bulan) && $bulan == $m) ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                        </option>
                    @endforeach
                </select>
                <select name="tahun" class="px-3 py-2 border border-red-400 rounded-xl font-bold">
                @foreach(range(date('Y'), date('Y')-2) as $y)
                    {{-- Gunakan isset agar tidak error --}}
                    <option value="{{ $y }}" {{ (isset($tahun) && $tahun == $y) ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
                <button type="submit" class="px-5 py-2 bg-red-700 text-white font-bold rounded-xl">Tampilkan</button>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white border p-5 rounded-2xl">
                    <p class="text-[10px] text-gray-400 uppercase">Total Penjualan</p>
                    <h3 class="text-base font-bold">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white border p-5 rounded-2xl">
                    <p class="text-[10px] text-gray-400 uppercase">Total Pesanan</p>
                    <h3 class="text-base font-bold">{{ $totalPesanan }}</h3>
                </div>
                <div class="bg-white border p-5 rounded-2xl">
                    <p class="text-[10px] text-gray-400 uppercase">Produk Terjual</p>
                    <h3 class="text-base font-bold">{{ $produkTerjual }} pcs</h3>
                </div>
            </div>

            <div class="bg-white border rounded-2xl p-5">
                <h4 class="font-bold mb-4">Produk Terlaris</h4>
                <ul class="divide-y">
                    @foreach($produkTerlaris as $index => $prod)
                    <li class="py-3 flex justify-between">
                        <span>{{ $index + 1 }}. {{ $prod->nama_produk }}</span>
                        <span class="font-bold">{{ $prod->total_qty }} pcs</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border p-6 rounded-2xl shadow-sm">
                    <p class="text-xs text-gray-500 uppercase font-semibold">Rata-rata Nilai Pesanan</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">
                        Rp {{ number_format($rataRataPesanan, 0, ',', '.') }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Per transaksi pada periode terpilih</p>
                </div>

                <div class="bg-white border p-6 rounded-2xl shadow-sm">
                    <h4 class="font-bold text-gray-800 mb-4">Grafik Penjualan Harian</h4>
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>
        </main>
    </div>    

    <script>
        // Inisialisasi Grafik
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!}, // Hari
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: {!! json_encode($dataPoints) !!}, // Nominal
                    backgroundColor: '#b91c1c', // Warna Merah (Tailwind red-700)
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</html>