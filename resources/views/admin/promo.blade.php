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

        <main class="flex-1 p-8 space-y-6">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">Data Promo</h2>
                <a href="{{ route('admin.promo.tambah') }}" class="bg-red-700 hover:bg-red-800 text-white font-bold text-xs px-5 py-2.5 rounded-full shadow-sm transition flex items-center gap-2">
                    <span>+</span> Tambah Promo
                </a>
            </div>

            <div class="bg-white border border-gray-200 p-4 rounded-2xl shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between text-xs">
                <div class="w-full sm:w-72 relative">
                    <input type="text" id="inputCari" onkeyup="jalankanFilter()" placeholder="Cari nama atau kode promo..." class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-normal">
                    <span class="absolute left-3.5 top-3 text-gray-400">🔍</span>
                </div>
                
                <div class="w-full sm:w-auto flex items-center gap-2 justify-end">
                    <span class="text-gray-500 font-medium">Status:</span>
                    <select id="filterStatus" onchange="jalankanFilter()" class="border border-gray-200 p-2.5 rounded-xl focus:outline-none focus:border-red-500 bg-white font-semibold text-gray-700 cursor-pointer">
                        <option value="Semua">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>

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
                        <tbody id="bodyTabelPromo" class="divide-y divide-gray-100 text-xs">
                            <tr class="hover:bg-gray-50/50 transition baris-promo">
                                <td class="p-4 text-center text-gray-400 font-medium angka-no">1</td>
                                <td class="p-4 font-semibold text-gray-800 kolom-nama">Diskon 10%</td>
                                <td class="p-4 font-mono font-bold text-red-700 bg-red-50/50 px-2 py-1 rounded inline-block mt-2 kolom-kode">ALLPROD10</td>
                                <td class="p-4 font-medium text-gray-700">10%</td>
                                <td class="p-4 text-gray-500 font-medium">01 Mei 2026 - 31 Mei 2026</td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 bg-green-50 border border-green-200 text-green-600 rounded-full text-[10px] font-bold kolom-status">Aktif</span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('admin.promo.tambah', ['id' => 1]) }}" class="p-1.5 border border-gray-300 hover:border-blue-600 hover:text-blue-600 bg-white rounded-lg transition shadow-sm text-center flex items-center justify-center" title="Edit">📝</a>
                                        <button onclick="hapusPromo(this, 'Diskon 10%')" class="p-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white rounded-lg transition shadow-sm" title="Hapus">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition baris-promo">
                                <td class="p-4 text-center text-gray-400 font-medium angka-no">2</td>
                                <td class="p-4 font-semibold text-gray-800 kolom-nama">Gratis Ongkir</td>
                                <td class="p-4 font-mono font-bold text-red-700 bg-red-50/50 px-2 py-1 rounded inline-block mt-2 kolom-kode">ONGKIRGRATIS</td>
                                <td class="p-4 font-medium text-gray-700">-</td>
                                <td class="p-4 text-gray-500 font-medium">01 Mei 2026 - 31 Mei 2026</td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 bg-green-50 border border-green-200 text-green-600 rounded-full text-[10px] font-bold kolom-status">Aktif</span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('admin.promo.tambah', ['id' => 2]) }}" class="p-1.5 border border-gray-300 hover:border-blue-600 hover:text-blue-600 bg-white rounded-lg transition shadow-sm text-center flex items-center justify-center" title="Edit">📝</a>
                                        <button onclick="hapusPromo(this, 'Gratis Ongkir')" class="p-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white rounded-lg transition shadow-sm" title="Hapus">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition baris-promo">
                                <td class="p-4 text-center text-gray-400 font-medium angka-no">3</td>
                                <td class="p-4 font-semibold text-gray-800 kolom-nama">Cashback 5%</td>
                                <td class="p-4 font-mono font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded inline-block mt-2 kolom-kode">CASHBACK5</td>
                                <td class="p-4 font-medium text-gray-700">5%</td>
                                <td class="p-4 text-gray-500 font-medium">01 Juni 2026 - 30 Juni 2026</td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 bg-gray-100 border border-gray-200 text-gray-500 rounded-full text-[10px] font-bold kolom-status">Nonaktif</span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('admin.promo.tambah', ['id' => 3]) }}" class="p-1.5 border border-gray-300 hover:border-blue-600 hover:text-blue-600 bg-white rounded-lg transition shadow-sm text-center flex items-center justify-center" title="Edit">📝</a>
                                        <button onclick="hapusPromo(this, 'Cashback 5%')" class="p-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white rounded-lg transition shadow-sm" title="Hapus">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

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

    <script>
        // 1. FUNGSI FILTER PENCARIAN & STATUS
        function jalankanFilter() {
            let inputCari = document.getElementById("inputCari").value.toLowerCase();
            let filterStatus = document.getElementById("filterStatus").value;
            let barisPromo = document.getElementsByClassName("baris-promo");

            for (let i = 0; i < barisPromo.length; i++) {
                let namaPromo = barisPromo[i].getElementsByClassName("kolom-nama")[0].textContent.toLowerCase();
                let kodePromo = barisPromo[i].getElementsByClassName("kolom-kode")[0].textContent.toLowerCase();
                let statusPromo = barisPromo[i].getElementsByClassName("kolom-status")[0].textContent.trim();

                let cocokKeyword = namaPromo.includes(inputCari) || kodePromo.includes(inputCari);
                let cocokStatus = filterStatus === "Semua" || statusPromo === filterStatus;

                if (cocokKeyword && cocokStatus) {
                    barisPromo[i].style.display = "";
                } else {
                    barisPromo[i].style.display = "none";
                }
            }
        }

        // 2. FUNGSI BARU: HAPUS BARIS TABEL PROMO & UPDATE NOMOR OTOMATIS
        function hapusPromo(button, namaPromo) {
            // Memunculkan dialog konfirmasi terlebih dahulu
            let konfirmasi = confirm("Apakah Anda yakin ingin menghapus promo '" + namaPromo + "'?");
            
            if (konfirmasi) {
                // Mencari baris <tr> terdekat dari tombol yang diklik lalu menghapusnya
                let baris = button.closest('.baris-promo');
                baris.remove();
                
                // Menyusun kembali urutan nomor (No) pada kolom pertama agar tetap berurutan (1, 2, 3...)
                let sisaBaris = document.getElementsByClassName("angka-no");
                for (let i = 0; i < sisaBaris.length; i++) {
                    sisaBaris[i].textContent = i + 1;
                }

                alert("Promo '" + namaPromo + "' berhasil dihapus!");
            }
        }
    </script>
</body>
</html>