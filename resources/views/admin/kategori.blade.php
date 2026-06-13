<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 object-contain">
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
                    <a href="{{ route('admin.kategori') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
                        <span>🏷️</span> Kategori
                    </a>
                    <a href="#" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>📦</span> Pesanan
                    </a>
                    <a href="#" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>💳</span> Pembayaran
                    </a>
                    <a href="#" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🏷️</span> Promo
                    </a>
                    <a href="#" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>👥</span> Pelanggan
                    </a>
                    <a href="#" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>📊</span> Laporan
                    </a>
                    <a href="#" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
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
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">Data Kategori</h2>
                <a href="{{ route('admin.kategori.tambah') }}" class="bg-red-700 hover:bg-red-800 text-white font-bold text-xs px-5 py-2.5 rounded-full shadow-sm transition flex items-center gap-2">
                    <span>+</span> Tambah Kategori
                </a>
            </div>

            <div class="bg-white border border-red-400 rounded-2xl shadow-sm overflow-hidden p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs" id="category-table">
                        <thead>
                            <tr class="bg-red-50 text-red-700 font-bold border-b border-red-100">
                                <th class="p-4 w-16 text-center">No</th>
                                <th class="p-4">Nama Kategori</th>
                                <th class="p-4 w-40 text-center">Jumlah Produk</th>
                                <th class="p-4 w-32 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-medium text-gray-600" id="table-body">
                            <tr class="category-row hover:bg-gray-50/50 transition" data-page="1">
                                <td class="p-4 text-center text-gray-400 row-number">1</td>
                                <td class="p-4 font-semibold text-gray-800 category-name">Kartu Nama</td>
                                <td class="p-4 text-center bg-gray-50/30 font-bold text-gray-700">15</td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-4.5 text-base">
                                        <a href="{{ route('admin.kategori.tambah') }}" class="text-blue-600 hover:text-blue-800 text-sm">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 transition">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="category-row hover:bg-gray-50/50 transition" data-page="1">
                                <td class="p-4 text-center text-gray-400 row-number">2</td>
                                <td class="p-4 font-semibold text-gray-800 category-name">Brosur</td>
                                <td class="p-4 text-center bg-gray-50/30 font-bold text-gray-700">18</td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-4.5 text-base">
                                        <a href="#" class="text-blue-600 hover:text-blue-800 transition">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 transition">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="category-row hover:bg-gray-50/50 transition" data-page="1">
                                <td class="p-4 text-center text-gray-400 row-number">3</td>
                                <td class="p-4 font-semibold text-gray-800 category-name">Banner</td>
                                <td class="p-4 text-center bg-gray-50/30 font-bold text-gray-700">12</td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-4.5 text-base">
                                        <a href="#" class="text-blue-600 hover:text-blue-800 transition">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 transition">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="category-row hover:bg-gray-50/50 transition" data-page="1">
                                <td class="p-4 text-center text-gray-400 row-number">4</td>
                                <td class="p-4 font-semibold text-gray-800 category-name">Stiker</td>
                                <td class="p-4 text-center bg-gray-50/30 font-bold text-gray-700">10</td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-4.5 text-base">
                                        <a href="#" class="text-blue-600 hover:text-blue-800 transition">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 transition">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="category-row hover:bg-gray-50/50 transition" data-page="1">
                                <td class="p-4 text-center text-gray-400 row-number">5</td>
                                <td class="p-4 font-semibold text-gray-800 category-name">Undangan</td>
                                <td class="p-4 text-center bg-gray-50/30 font-bold text-gray-700">8</td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-4.5 text-base">
                                        <a href="#" class="text-blue-600 hover:text-blue-800 transition">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 transition">🗑️</button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="category-row hover:bg-gray-50/50 transition" data-page="2">
                                <td class="p-4 text-center text-gray-400 row-number">6</td>
                                <td class="p-4 font-semibold text-gray-800 category-name">Kaos Sablon</td>
                                <td class="p-4 text-center bg-gray-50/30 font-bold text-gray-700">7</td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-4.5 text-base">
                                        <a href="#" class="text-blue-600 hover:text-blue-800 transition">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 transition">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-center items-center gap-1.5 pt-2 text-xs font-semibold text-gray-600">
                <button onclick="changePage('prev')" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-center transition">‹</button>
                
                <button onclick="changePage(1)" id="page-1" class="page-number w-7 h-7 bg-red-700 text-white rounded flex items-center justify-center shadow-sm font-bold">1</button>
                <button onclick="changePage(2)" id="page-2" class="page-number w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-center transition">2</button>
                
                <span class="px-1 text-gray-400">...</span>
                <button class="w-7 h-7 bg-gray-100 text-gray-400 rounded flex items-center justify-center cursor-not-allowed">10</button>
                <button onclick="changePage('next')" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-center transition">›</button>
            </div>

        </main>
    </div>

    <script>
        let currentPage = 1;

        function updateTable() {
            const rows = document.querySelectorAll('.category-row');
            
            rows.forEach(row => {
                const rowPage = parseInt(row.getAttribute('data-page'));
                if (rowPage === currentPage) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            updatePaginationUI();
        }

        function changePage(page) {
            if (page === 'prev') {
                if (currentPage > 1) currentPage--;
            } else if (page === 'next') {
                if (currentPage < 2) currentPage++; 
            } else {
                currentPage = page;
            }
            updateTable();
        }

        function updatePaginationUI() {
            const p1 = document.getElementById('page-1');
            const p2 = document.getElementById('page-2');

            if (!p1 || !p2) return;

            if (currentPage === 1) {
                p1.className = "page-number w-7 h-7 bg-red-700 text-white rounded flex items-center justify-center shadow-sm font-bold";
                p2.className = "page-number w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded flex items-center justify-center transition";
            } else {
                p2.className = "page-number w-7 h-7 bg-red-700 text-white rounded flex items-center justify-center shadow-sm font-bold";
                p1.className = "page-number w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded flex items-center justify-center transition";
            }
        }

        function deleteRow(button) {
            if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                button.closest('.category-row').remove();
                updateTable();
            }
        }

        // Jalankan pembagian halaman saat pertama kali dibuka
        document.addEventListener("DOMContentLoaded", function() {
            updateTable();
        });
    </script>
</body>
</html>