<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Promo - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href="{{ route('admin.promo') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
                        <span>%</span> Promo
                    </a>
                    <a href="{{ route('admin.pelanggan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>👥</span> Pelanggan
                    </a>
                    <a href="{{ route('admin.laporan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
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

        <!-- KANAN: KONTEN UTAMA DATA PROMO -->
        <main class="flex-1 p-8 space-y-6">
            <!-- HEADER DATA PROMO & TOMBOL TAMBAH -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 tracking-wide">Data Promo</h2>
                    <p class="text-xs text-gray-500 mt-1">Kelola kode voucher potongan harga dan diskon cetak.</p>
                </div>
                <!-- Tombol Tambah Sesuai Desain Maroon -->
                <button onclick="alert('Membuka form tambah promo baru')" class="px-5 py-2.5 bg-red-700 hover:bg-red-800 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center gap-2">
                    <span>+</span> Tambah Promo
                </button>
            </div>

            <!-- KOTAK TABEL PROMO (SESUAI WIREFRAME) -->
            <div class="bg-white border border-red-400 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 uppercase text-[10px] tracking-wider font-bold">
                                <th class="p-4 text-center w-16">No</th>
                                <th class="p-4">Nama Promo</th>
                                <th class="p-4">Kode Promo</th>
                                <th class="p-4">Diskon</th>
                                <th class="p-4">Berlaku</th>
                                <th class="p-4 text-center w-28">Status</th>
                                <th class="p-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs">
                            <!-- Baris 1 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-4 text-center text-gray-400 font-medium">1</td>
                                <td class="p-4 font-semibold text-gray-800">Diskon 10%</td>
                                <td class="p-4 font-mono font-bold text-red-700 bg-red-50/50 px-2 py-1 rounded inline-block mt-2">ALLPROD10</td>
                                <td class="p-4 font-medium text-gray-700">10%</td>
                                <td class="p-4 text-gray-500 font-medium">01 Mei 2026 - 31 Mei 2026</td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 bg-green-50 border border-green-200 text-green-600 rounded-full text-[10px] font-bold">Aktif</span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <button onclick="alert('Edit Promo 1')" class="p-1.5 border border-gray-300 hover:border-blue-600 hover:text-blue-600 bg-white rounded-lg transition shadow-sm" title="Edit">📝</button>
                                        <button onclick="alert('Hapus Promo 1')" class="p-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white rounded-lg transition shadow-sm" title="Hapus">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Baris 2 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-4 text-center text-gray-400 font-medium">2</td>
                                <td class="p-4 font-semibold text-gray-800">Gratis Ongkir</td>
                                <td class="p-4 font-mono font-bold text-red-700 bg-red-50/50 px-2 py-1 rounded inline-block mt-2">ONGKIRGRATIS</td>
                                <td class="p-4 font-medium text-gray-700">-</td>
                                <td class="p-4 text-gray-500 font-medium">01 Mei 2026 - 31 Mei 2026</td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 bg-green-50 border border-green-200 text-green-600 rounded-full text-[10px] font-bold">Aktif</span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <button onclick="alert('Edit Promo 2')" class="p-1.5 border border-gray-300 hover:border-blue-600 hover:text-blue-600 bg-white rounded-lg transition shadow-sm" title="Edit">📝</button>
                                        <button onclick="alert('Hapus Promo 2')" class="p-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white rounded-lg transition shadow-sm" title="Hapus">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Baris 3 -->
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-4 text-center text-gray-400 font-medium">3</td>
                                <td class="p-4 font-semibold text-gray-800">Cashback 5%</td>
                                <td class="p-4 font-mono font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded inline-block mt-2">CASHBACK5</td>
                                <td class="p-4 font-medium text-gray-700">5%</td>
                                <td class="p-4 text-gray-500 font-medium">01 Juni 2026 - 30 Juni 2026</td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 bg-gray-100 border border-gray-200 text-gray-500 rounded-full text-[10px] font-bold">Nonaktif</span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <button onclick="alert('Edit Promo 3')" class="p-1.5 border border-gray-300 hover:border-blue-600 hover:text-blue-600 bg-white rounded-lg transition shadow-sm" title="Edit">📝</button>
                                        <button onclick="alert('Hapus Promo 3')" class="p-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white rounded-lg transition shadow-sm" title="Hapus">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PAGINATION BAWAH (SESUAI DESAIN MAROON) -->
            <div class="flex items-center justify-center gap-1.5 text-xs pt-2">
                <button class="w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded flex items-center justify-center transition shadow-sm font-bold">‹</button>
                <button class="w-7 h-7 bg-red-700 text-white rounded flex items-center justify-center shadow-sm font-bold">1</button>
                <button class="w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded flex items-center justify-center transition">2</button>
                <button class="w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded flex items-center justify-center transition">3</button>
                <span class="text-gray-400 px-1">...</span>
                <button class="w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded flex items-center justify-center transition">10</button>
                <button class="w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded flex items-center justify-center transition shadow-sm font-bold">›</button>
            </div>
        </main>
    </div>

</body>
</html>