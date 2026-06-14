<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahan Chart.js untuk membuat grafik interaktif real-time -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- ATAS: NAVBAR ADMIN -->
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
        <!-- KIRI: SIDEBAR NAVIGASI -->
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
                    <a href="{{ route('admin.pelanggan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>👥</span> Pelanggan
                    </a>
                    <a href="{{ route('admin.laporan') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
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

        <!-- KANAN: KONTEN UTAMA LAPORAN -->
        <main class="flex-1 p-8 space-y-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">Laporan Penjualan</h2>
                <p class="text-xs text-gray-500 mt-1">Analisis performa bisnis, omzet cetak, dan statistik produk terlaris.</p>
            </div>

            <!-- BAGIAN BAR FILTER KONTROL (GABUNGAN WIREFRAME & UI DESIGN) -->
            <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm flex flex-wrap items-center gap-4 text-xs font-semibold text-gray-700">
                <div class="flex items-center gap-2">
                    <label for="jenis-laporan" class="whitespace-nowrap">Jenis Laporan:</label>
                    <select id="jenis-laporan" class="px-3 py-2 bg-white border border-gray-300 rounded-xl focus:outline-none focus:border-red-600 font-medium">
                        <option value="Penjualan" selected>Penjualan</option>
                        <option value="Produk">Per Produk</option>
                        <option value="Pelanggan">Per Pelanggan</option>
                    </select>
                </div>
                
                <div class="flex items-center gap-2">
                    <label for="periode-laporan" class="whitespace-nowrap">Periode:</label>
                    <select id="periode-laporan" class="px-3 py-2 bg-white border border-red-400 text-gray-800 rounded-xl focus:outline-none focus:border-red-600 font-bold">
                        <option value="Mei 2026" selected>Mei 2026</option>
                        <option value="April 2026">April 2026</option>
                        <option value="Maret 2026">Maret 2026</option>
                    </select>
                </div>

                <button onclick="updateLaporanData()" class="px-5 py-2 bg-red-700 hover:bg-red-800 text-white font-bold rounded-xl transition shadow-sm">
                    Tampilkan
                </button>
            </div>

            <!-- GRID SUMMARY CARDS (PERSIS GAMBAR) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1 -->
                <div class="bg-white border border-red-400 rounded-2xl p-5 shadow-sm space-y-1.5">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Penjualan</p>
                    <h3 id="card-total" class="text-base font-bold text-gray-800 tracking-wide">Rp 24.560.000</h3>
                </div>
                <!-- Card 2 -->
                <div class="bg-white border border-red-400 rounded-2xl p-5 shadow-sm space-y-1.5">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Pesanan</p>
                    <h3 id="card-pesanan" class="text-base font-bold text-gray-800 tracking-wide">152</h3>
                </div>
                <!-- Card 3 -->
                <div class="bg-white border border-red-400 rounded-2xl p-5 shadow-sm space-y-1.5">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Rata-rata Order</p>
                    <h3 id="card-rata" class="text-base font-bold text-gray-800 tracking-wide">Rp 161.580</h3>
                </div>
                <!-- Card 4 -->
                <div class="bg-white border border-red-400 rounded-2xl p-5 shadow-sm space-y-1.5">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Produk Terjual</p>
                    <h3 id="card-terjual" class="text-base font-bold text-gray-800 tracking-wide">320</h3>
                </div>
            </div>

            <!-- GRID GRAFIK & PRODUK TERLARIS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Sisi Kiri (2/3): Grafik Line Chart -->
                <div class="lg:col-span-2 bg-white border border-red-400 rounded-2xl p-5 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-50 pb-2">Grafik Penjualan</h4>
                    <div class="relative w-full h-64">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Sisi Kanan (1/3): Daftar Produk Terlaris -->
                <div class="bg-white border border-red-400 rounded-2xl p-5 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-50 pb-2">Produk Terlaris</h4>
                    <div class="overflow-hidden">
                        <ul id="list-terlaris" class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
                            <li class="py-3 flex justify-between items-center bg-gray-50/70 px-2 rounded-lg">
                                <span class="text-gray-800"><strong class="text-gray-400 mr-2">1</strong> Kartu Nama</span>
                                <span class="font-bold text-gray-900 bg-white border border-gray-200 px-2 py-0.5 rounded shadow-2inner">120 <span class="text-[10px] font-normal text-gray-400">di-fkrtori</span></span>
                            </li>
                            <li class="py-3 flex justify-between items-center px-2">
                                <span class="text-gray-800"><strong class="text-gray-400 mr-2">2</strong> Brosur A4</span>
                                <span class="font-bold text-gray-600">80</span>
                            </li>
                            <li class="py-3 flex justify-between items-center px-2">
                                <span class="text-gray-800"><strong class="text-gray-400 mr-2">3</strong> Banner 60x160</span>
                                <span class="font-bold text-gray-600">60</span>
                            </li>
                            <li class="py-3 flex justify-between items-center px-2">
                                <span class="text-gray-800"><strong class="text-gray-400 mr-2">4</strong> Stiker Die Cut</span>
                                <span class="font-bold text-gray-600">40</span>
                            </li>
                            <li class="py-3 flex justify-between items-center px-2">
                                <span class="text-gray-800"><strong class="text-gray-400 mr-2">5</strong> Undangan Softcover</span>
                                <span class="font-bold text-gray-600">20</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- BUTTON EXPORT DI BAGIAN BAWAH -->
            <div class="flex items-center gap-3 pt-2">
                <button onclick="triggerExport('PDF')" class="px-5 py-2 border border-red-400 hover:bg-red-50 text-red-700 font-bold text-xs rounded-xl transition shadow-sm flex items-center gap-2">
                    📥 Export PDF
                </button>
                <button onclick="triggerExport('Excel')" class="px-5 py-2 border border-red-400 hover:bg-red-50 text-red-700 font-bold text-xs rounded-xl transition shadow-sm flex items-center gap-2">
                    📥 Export Excel
                </button>
            </div>
        </main>
    </div>

    <!-- LOGIKA INTERAKSI INTERAKTIF (LIVE MOCKUP DATA) -->
    <script>
        let salesChart;

        // Data Dinamis Saat Tombol "Tampilkan" Ditekan
        const dataPeriode = {
            "Mei 2026": {
                total: "Rp 24.560.000", pesanan: "152", rata: "Rp 161.580", terjual: "320",
                chartData: [15, 28, 20, 28, 18, 12, 22, 32, 42, 32, 22, 14, 16, 35, 38, 48, 38, 32, 25, 18, 28, 35, 39, 40, 32, 25, 22, 30, 48],
                products: [
                    { name: "Kartu Nama", qty: "120 di-fkrtori" },
                    { name: "Brosur A4", qty: "80" },
                    { name: "Banner 60x160", qty: "60" },
                    { name: "Stiker Die Cut", qty: "40" },
                    { name: "Undangan Softcover", qty: "20" }
                ]
            },
            "April 2026": {
                total: "Rp 19.840.000", pesanan: "115", rata: "Rp 172.520", terjual: "260",
                chartData: [20, 24, 15, 30, 22, 25, 19, 34, 28, 40, 31, 29, 36, 42, 30, 22, 18, 25, 34, 38, 29, 21, 19, 26, 33, 41, 35, 28, 44],
                products: [
                    { name: "Banner 60x160", qty: "95" },
                    { name: "Kartu Nama", qty: "85" },
                    { name: "Stiker Die Cut", qty: "50" },
                    { name: "Brosur A4", qty: "20" },
                    { name: "Undangan Softcover", qty: "10" }
                ]
            },
            "Maret 2026": {
                total: "Rp 15.320.000", pesanan: "98", rata: "Rp 156.325", terjual: "195",
                chartData: [10, 15, 18, 12, 25, 30, 22, 16, 14, 20, 28, 35, 30, 24, 19, 15, 22, 34, 40, 33, 26, 21, 18, 29, 32, 27, 21, 36, 39],
                products: [
                    { name: "Stiker Die Cut", qty: "70" },
                    { name: "Kartu Nama", qty: "50" },
                    { name: "Brosur A4", qty: "45" },
                    { name: "Banner 60x160", qty: "20" },
                    { name: "Undangan Softcover", qty: "10" }
                ]
            }
        };

        // Fungsi Init / Render Awal Chart.js Grafik Penjualan
        function initChart(dataPoints) {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            if (salesChart) {
                salesChart.destroy(); // Hancurkan chart lama jika ada pembaruan periode
            }

            salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['1 Mei', '', '', '', '', '6 Mei', '', '', '', '', '11 Mei', '', '', '', '', '16 Mei', '', '', '', '', '21 Mei', '', '', '', '', '', '', '', '31 Mei'],
                    datasets: [{
                        label: 'Penjualan (dalam Juta)',
                        data: dataPoints,
                        borderColor: '#b91c1c', // Merah Maroon Tailwind text-red-700
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#b91c1c',
                        pointHoverRadius: 5,
                        tension: 0.3,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            min: 0, max: 60,
                            ticks: { stepSize: 20, callback: value => value ? value + 'M' : '0' }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        // Fungsi Aksi Interaksi ketika Admin Klik "Tampilkan"
        function updateLaporanData() {
            const periode = document.getElementById('periode-laporan').value;
            const targetData = dataPeriode[periode];

            if (targetData) {
                // 1. Update text di Card Atas
                document.getElementById('card-total').innerText = targetData.total;
                document.getElementById('card-pesanan').innerText = targetData.pesanan;
                document.getElementById('card-rata').innerText = targetData.rata;
                document.getElementById('card-terjual').innerText = targetData.terjual;

                // 2. Update Grafik Line Chart
                initChart(targetData.chartData);

                // 3. Update List Produk Terlaris Sisi Kanan
                const listContainer = document.getElementById('list-terlaris');
                listContainer.innerHTML = '';
                targetData.products.forEach((prod, index) => {
                    const li = document.createElement('li');
                    li.className = `py-3 flex justify-between items-center ${index === 0 ? 'bg-gray-50/70 px-2 rounded-lg' : 'px-2'}`;
                    li.innerHTML = `
                        <span class="text-gray-800"><strong class="text-gray-400 mr-2">${index + 1}</strong> ${prod.name}</span>
                        <span class="${index === 0 ? 'font-bold text-gray-900 bg-white border border-gray-200 px-2 py-0.5 rounded shadow-inner' : 'font-bold text-gray-600'}">${prod.qty}</span>
                    `;
                    listContainer.appendChild(li);
                });

                alert(`Data laporan berhasil diperbarui untuk periode: ${periode}`);
            }
        }

        // Fungsi Simulasi Tombol Export Dokumen
        function triggerExport(type) {
            const periode = document.getElementById('periode-laporan').value;
            alert(`Sistem melakukan proses ekspor dokumen Laporan Penjualan periode ${periode} ke format *.${type.toLowerCase()}`);
        }

        // Jalankan render otomatis saat pertama kali halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            initChart(dataPeriode["Mei 2026"].chartData);
        });
    </script>
</body>
</html>