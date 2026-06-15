<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - Fantastic Digital Printing</title>
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
                    <a href="{{ route('admin.promo') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>%</span> Promo
                    </a>
                    <a href="{{ route('admin.pelanggan') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
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
            <div>
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">Data Pelanggan</h2>
                <p class="text-xs text-gray-500 mt-1">Melihat daftar pelanggan yang terdaftar dan riwayat total orderan mereka.</p>
            </div>

            <div class="flex items-center gap-2 max-w-md">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 text-xs">
                        🔍
                    </span>
                    <input type="text" id="inputCariPelanggan" onkeyup="cariPelanggan()" placeholder="Cari nama, email, atau no. telp..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-red-400 rounded-xl text-xs font-medium text-gray-700 placeholder-gray-400 focus:outline-none focus:border-red-600 transition shadow-sm">
                </div>
                <button class="p-2.5 bg-white border border-gray-300 hover:border-red-600 rounded-xl text-xs transition shadow-sm" title="Filter Tambahan">
                    👥
                </button>
            </div>

            <div class="bg-white border border-red-400 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 uppercase text-[10px] tracking-wider font-bold">
                                <th class="p-4 text-center w-16">No</th>
                                <th class="p-4">Nama</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">No. Telp</th>
                                <th class="p-4 text-center w-32">Total Order</th>
                                <th class="p-4 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTabelPelanggan" class="divide-y divide-gray-100 text-xs text-gray-700 font-medium">
                            <tr class="hover:bg-gray-50/50 transition baris-pelanggan">
                                <td class="p-4 text-center text-gray-400 font-normal">1</td>
                                <td class="p-4 font-semibold text-gray-800 kolom-nama">Budi Santoso</td>
                                <td class="p-4 text-gray-500 kolom-email">budi@email.com</td>
                                <td class="p-4 font-mono text-gray-600 kolom-telp">081234567890</td>
                                <td class="p-4 text-center font-bold text-gray-800">12</td>
                                <td class="p-4 text-center">
                                    <button onclick="window.location.href='{{ route('admin.pelanggan.detail', ['id' => 1]) }}'" class="px-4 py-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white text-gray-600 rounded-lg text-[11px] font-bold shadow-sm transition">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition baris-pelanggan">
                                <td class="p-4 text-center text-gray-400 font-normal">2</td>
                                <td class="p-4 font-semibold text-gray-800 kolom-nama">Siti Aisyah</td>
                                <td class="p-4 text-gray-500 kolom-email">siti@email.com</td>
                                <td class="p-4 font-mono text-gray-600 kolom-telp">081298765432</td>
                                <td class="p-4 text-center font-bold text-gray-800">8</td>
                                <td class="p-4 text-center">
                                    <button onclick="window.location.href='{{ route('admin.pelanggan.detail', ['id' => 2]) }}'" class="px-4 py-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white text-gray-600 rounded-lg text-[11px] font-bold shadow-sm transition">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition baris-pelanggan">
                                <td class="p-4 text-center text-gray-400 font-normal">3</td>
                                <td class="p-4 font-semibold text-gray-800 kolom-nama">Andi Wijaya</td>
                                <td class="p-4 text-gray-500 kolom-email">andi@email.com</td>
                                <td class="p-4 font-mono text-gray-600 kolom-telp">081278945612</td>
                                <td class="p-4 text-center font-bold text-gray-800">5</td>
                                <td class="p-4 text-center">
                                    <button onclick="window.location.href='{{ route('admin.pelanggan.detail', ['id' => 3]) }}'" class="px-4 py-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white text-gray-600 rounded-lg text-[11px] font-bold shadow-sm transition">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition baris-pelanggan">
                                <td class="p-4 text-center text-gray-400 font-normal">4</td>
                                <td class="p-4 font-semibold text-gray-800 kolom-nama">Dinda Amelia</td>
                                <td class="p-4 text-gray-500 kolom-email">dinda@email.com</td>
                                <td class="p-4 font-mono text-gray-600 kolom-telp">081212345678</td>
                                <td class="p-4 text-center font-bold text-gray-800">7</td>
                                <td class="p-4 text-center">
                                    <button onclick="window.location.href='{{ route('admin.pelanggan.detail', ['id' => 4]) }}'" class="px-4 py-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white text-gray-600 rounded-lg text-[11px] font-bold shadow-sm transition">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition baris-pelanggan">
                                <td class="p-4 text-center text-gray-400 font-normal">5</td>
                                <td class="p-4 font-semibold text-gray-800 kolom-nama">Rian Pratama</td>
                                <td class="p-4 text-gray-500 kolom-email">rian@email.com</td>
                                <td class="p-4 font-mono text-gray-600 kolom-telp">081244556677</td>
                                <td class="p-4 text-center font-bold text-gray-800">3</td>
                                <td class="p-4 text-center">
                                    <button onclick="window.location.href='{{ route('admin.pelanggan.detail', ['id' => 5]) }}'" class="px-4 py-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white text-gray-600 rounded-lg text-[11px] font-bold shadow-sm transition">
                                        Detail
                                    </button>
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
        function cariPelanggan() {
            // Ambil text input kunci pencarian
            let input = document.getElementById("inputCariPelanggan").value.toLowerCase();
            // Ambil semua elemen baris data tabel pelanggan
            let barisPelanggan = document.getElementsByClassName("baris-pelanggan");

            for (let i = 0; i < barisPelanggan.length; i++) {
                // Ambil text content dari kolom nama, email, dan telepon
                let nama = barisPelanggan[i].getElementsByClassName("kolom-nama")[0].textContent.toLowerCase();
                let email = barisPelanggan[i].getElementsByClassName("kolom-email")[0].textContent.toLowerCase();
                let telp = barisPelanggan[i].getElementsByClassName("kolom-telp")[0].textContent.toLowerCase();

                // Cek jika kata kunci cocok dengan salah satu kolom data
                if (nama.includes(input) || email.includes(input) || telp.includes(input)) {
                    barisPelanggan[i].style.display = ""; // Tampilkan baris
                } else {
                    barisPelanggan[i].style.display = "none"; // Sembunyikan baris
                }
            }
        }
    </script>
</body>
</html>