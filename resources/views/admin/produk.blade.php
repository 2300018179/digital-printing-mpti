<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - Fantastic Digital Printing</title>
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
                    <a href="{{ route('admin.produk') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
                        <span>🛍️</span> Produk
                    </a>
                    <a href="{{ route('admin.kategori') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🏷️</span> Kategori
                    </a>
                    <a href="{{ route('admin.pesanan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
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
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">Data Produk</h2>
                <a href="{{ route('admin.produk.tambah') }}" class="bg-red-700 hover:bg-red-800 text-white font-bold text-xs px-5 py-2.5 rounded-full shadow-sm transition flex items-center gap-2">
                    <span>+</span> Tambah Produk
                </a>
            </div>

            <div class="flex flex-wrap gap-4 items-center">
                <div class="relative w-full max-w-xs">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-red-500">🔍</span>
                    <input type="text" id="search-input" oninput="resetPageAndFilter()" placeholder="Cari Produk" class="w-full pl-10 pr-4 py-2 text-xs font-medium bg-white border border-red-400 rounded-xl focus:outline-none focus:ring-1 focus:ring-red-500 text-gray-700 placeholder-gray-400 shadow-sm">
                </div>

                <div class="relative">
                    <select id="category-filter" onchange="resetPageAndFilter()" class="appearance-none bg-white border border-red-400 rounded-xl pl-4 pr-10 py-2 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-1 focus:ring-red-500 shadow-sm min-w-[150px]">
                        <option value="all">Semua Kategori</option>
                        <option value="Kartu Nama">Kartu Nama</option>
                        <option value="Brosur">Brosur</option>
                        <option value="Banner">Banner</option>
                        <option value="Stiker">Stiker</option>
                        <option value="Undangan">Undangan</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500 text-[10px]">▼</span>
                </div>

                <div class="relative">
                    <select id="status-filter" onchange="resetPageAndFilter()" class="appearance-none bg-white border border-red-400 rounded-xl pl-4 pr-10 py-2 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-1 focus:ring-red-500 shadow-sm min-w-[140px]">
                        <option value="all">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500 text-[10px]">▼</span>
                </div>
            </div>

            <div class="bg-white border border-red-400 rounded-2xl shadow-sm overflow-hidden p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs" id="product-table">
                        <thead>
                            <tr class="bg-red-50 text-red-700 font-bold border-b border-red-100">
                                <th class="p-3 w-12 text-center">No</th>
                                <th class="p-3 w-24">Gambar</th>
                                <th class="p-3">Nama Produk</th>
                                <th class="p-3">Kategori</th>
                                <th class="p-3">Harga</th>
                                <th class="p-3 w-20 text-center">Stok</th>
                                <th class="p-3 w-24 text-center">Status</th>
                                <th class="p-3 w-24 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-medium text-gray-600" id="table-body">
                            <tr class="product-row hover:bg-gray-50/50 transition" data-page="1">
                                <td class="p-3 text-center text-gray-400 row-number">1</td>
                                <td class="p-3"><div class="w-12 h-12 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-lg font-bold">📄</div></td>
                                <td class="p-3 font-semibold text-gray-800 product-name">Kartu Nama Premium</td>
                                <td class="p-3 product-category">Kartu Nama</td>
                                <td class="p-3 font-semibold text-gray-900">Rp 50.000</td>
                                <td class="p-3 text-center">120</td>
                                <td class="p-3 text-center"><span class="product-status bg-green-100 text-green-700 text-[10px] px-3 py-0.5 rounded-full font-bold">Aktif</span></td>
                                <td class="p-3 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('admin.produk.edit') }}" class="text-blue-600 hover:text-blue-800 text-sm">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 text-sm">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="product-row hover:bg-gray-50/50 transition" data-page="1">
                                <td class="p-3 text-center text-gray-400 row-number">2</td>
                                <td class="p-3"><div class="w-12 h-12 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-lg font-bold">📄</div></td>
                                <td class="p-3 font-semibold text-gray-800 product-name">Brosur A4 Silky</td>
                                <td class="p-3 product-category">Brosur</td>
                                <td class="p-3 font-semibold text-gray-900">Rp 150.000</td>
                                <td class="p-3 text-center">80</td>
                                <td class="p-3 text-center"><span class="product-status bg-green-100 text-green-700 text-[10px] px-3 py-0.5 rounded-full font-bold">Aktif</span></td>
                                <td class="p-3 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('admin.produk.edit') }}" class="text-blue-600 hover:text-blue-800 text-sm">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 text-sm">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="product-row hover:bg-gray-50/50 transition" data-page="1">
                                <td class="p-3 text-center text-gray-400 row-number">3</td>
                                <td class="p-3"><div class="w-12 h-12 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-lg font-bold">📄</div></td>
                                <td class="p-3 font-semibold text-gray-800 product-name">Banner 60x160 Flexi</td>
                                <td class="p-3 product-category">Banner</td>
                                <td class="p-3 font-semibold text-gray-900">Rp 85.000</td>
                                <td class="p-3 text-center">60</td>
                                <td class="p-3 text-center"><span class="product-status bg-green-100 text-green-700 text-[10px] px-3 py-0.5 rounded-full font-bold">Aktif</span></td>
                                <td class="p-3 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('admin.produk.edit') }}" class="text-blue-600 hover:text-blue-800 text-sm">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 text-sm">🗑️</button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="product-row hover:bg-gray-50/50 transition" data-page="2">
                                <td class="p-3 text-center text-gray-400 row-number">4</td>
                                <td class="p-3"><div class="w-12 h-12 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-lg font-bold">📄</div></td>
                                <td class="p-3 font-semibold text-gray-800 product-name">Stiker Die Cut Glossy</td>
                                <td class="p-3 product-category">Stiker</td>
                                <td class="p-3 font-semibold text-gray-900">Rp 35.000</td>
                                <td class="p-3 text-center">200</td>
                                <td class="p-3 text-center"><span class="product-status bg-red-100 text-red-700 text-[10px] px-3 py-0.5 rounded-full font-bold">Non-Aktif</span></td>
                                <td class="p-3 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('admin.produk.edit') }}" class="text-blue-600 hover:text-blue-800 text-sm">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 text-sm">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="product-row hover:bg-gray-50/50 transition" data-page="2">
                                <td class="p-3 text-center text-gray-400 row-number">5</td>
                                <td class="p-3"><div class="w-12 h-12 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-lg font-bold">📄</div></td>
                                <td class="p-3 font-semibold text-gray-800 product-name">Undangan Softcover Craft</td>
                                <td class="p-3 product-category">Undangan</td>
                                <td class="p-3 font-semibold text-gray-900">Rp 3.500</td>
                                <td class="p-3 text-center">150</td>
                                <td class="p-3 text-center"><span class="product-status bg-green-100 text-green-700 text-[10px] px-3 py-0.5 rounded-full font-bold">Aktif</span></td>
                                <td class="p-3 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('admin.produk.edit') }}" class="text-blue-600 hover:text-blue-800 text-sm">✏️</a>
                                        <button onclick="deleteRow(this)" class="text-red-600 hover:text-red-800 text-sm">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div id="no-data" class="hidden text-center py-8 text-xs font-medium text-gray-400">
                        ❌ Data produk tidak ditemukan yang cocok dengan filter.
                    </div>
                </div>
            </div>

            <div id="pagination-container" class="flex justify-center items-center gap-1.5 pt-2 text-xs font-semibold text-gray-600">
                <button onclick="changePage('prev')" id="btn-prev" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-center transition">‹</button>
                
                <button onclick="changePage(1)" id="page-1" class="page-number w-7 h-7 bg-red-700 text-white rounded flex items-center justify-center shadow-sm">1</button>
                <button onclick="changePage(2)" id="page-2" class="page-number w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-center transition">2</button>
                
                <span class="px-1 text-gray-400">...</span>
                <button class="w-7 h-7 bg-gray-100 text-gray-400 rounded flex items-center justify-center cursor-not-allowed">10</button>
                <button onclick="changePage('next')" id="btn-next" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-center transition">›</button>
            </div>

        </main>
    </div>

    <script>
        let currentPage = 1;
        const itemsPerPage = 3; // Jumlah item mockup figma per halaman

        function resetPageAndFilter() {
            currentPage = 1; // Kembalikan ke halaman 1 jika filter diganti
            filterTable();
        }

        function filterTable() {
            const searchQuery = document.getElementById('search-input').value.toLowerCase();
            const selectedCategory = document.getElementById('category-filter').value;
            const selectedStatus = document.getElementById('status-filter').value;
            
            const rows = document.querySelectorAll('.product-row');
            let filteredRows = [];

            // Tahap 1: Saring baris yang memenuhi kriteria pencarian dan dropdown filter
            rows.forEach(row => {
                const productName = row.querySelector('.product-name').textContent.toLowerCase();
                const productCategory = row.querySelector('.product-category').textContent;
                const productStatus = row.querySelector('.product-status').textContent;

                const matchesSearch = productName.includes(searchQuery);
                const matchesCategory = (selectedCategory === 'all' || productCategory === selectedCategory);
                const matchesStatus = (selectedStatus === 'all' || productStatus === selectedStatus);

                if (matchesSearch && matchesCategory && matchesStatus) {
                    filteredRows.push(row);
                } else {
                    row.style.display = 'none';
                }
            });

            // Tahap 2: Terapkan pembagian halaman (Pagination) pada data yang sudah lolos filter
            const isFilteringActive = (searchQuery !== '' || selectedCategory !== 'all' || selectedStatus !== 'all');
            
            if (!isFilteringActive) {
                // Skenario Normal (Tanpa Filter) -> Bagi data secara ketat menggunakan atribut data-page bawaan html
                document.getElementById('pagination-container').style.opacity = '1';
                document.getElementById('pagination-container').style.pointerEvents = 'auto';

                rows.forEach(row => {
                    const rowPage = parseInt(row.getAttribute('data-page'));
                    if (rowPage === currentPage) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            } else {
                // Skenario Saat Ada Filter -> Tampilkan semua hasil pencarian sekaligus & matikan tombol halaman
                document.getElementById('pagination-container').style.opacity = '0.3';
                document.getElementById('pagination-container').style.pointerEvents = 'none';

                filteredRows.forEach((row, index) => {
                    row.style.display = '';
                    row.querySelector('.row-number').textContent = index + 1; // Atur urutan nomor live
                });
            }

            // Tampilkan pesan jika tabel kosong total
            const noDataMessage = document.getElementById('no-data');
            if (filteredRows.length === 0) {
                noDataMessage.classList.remove('hidden');
            } else {
                noDataMessage.classList.add('hidden');
            }

            updatePaginationUI();
        }

        function changePage(page) {
            if (page === 'prev') {
                if (currentPage > 1) currentPage--;
            } else if (page === 'next') {
                if (currentPage < 2) currentPage++; // Batas halaman dummy maksimal 2 sesuai data kamu
            } else {
                currentPage = page;
            }
            filterTable();
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
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                button.closest('.product-row').remove();
                filterTable();
            }
        }

        // Jalankan kalkulasi halaman saat awal dimuat
        document.addEventListener("DOMContentLoaded", function() {
            filterTable();
        });
    </script>
</body>
</html>