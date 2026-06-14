<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan - Fantastic Digital Printing</title>
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
                    <a href="{{ route('admin.pesanan') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
                        <span>📦</span> Pesanan
                    </a>
                    <a href="{{ route('admin.pembayaran') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>💳</span> Pembayaran
                    </a>
                    <a href="{{ route('admin.promo') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🏷️</span> Promo
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
            <div>
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">Data Pesanan</h2>
                <p class="text-xs text-gray-500 mt-1">Kelola dan pantau seluruh status pesanan masuk pelanggan.</p>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="relative w-full max-w-xs">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-red-600">🔍</span>
                    <input type="text" id="search-input" onkeyup="filterPesanan()" placeholder="Cari order ID atau pelanggan..." 
                        class="w-full pl-9 pr-4 py-2 text-xs font-medium bg-white border border-red-400 rounded-full focus:outline-none focus:border-red-600 text-gray-700 shadow-sm transition">
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <select id="status-filter" onchange="filterPesanan()" class="px-4 py-2 text-xs font-medium bg-white border border-red-400 rounded-full text-gray-700 shadow-sm focus:outline-none transition">
                        <option value="">Semua Status</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Dicetak">Dicetak</option>
                        <option value="Dikirim">Dikirim</option>
                        <option value="Selesai">Selesai</option>
                    </select>

                    <select id="date-filter" class="px-4 py-2 text-xs font-medium bg-white border border-red-400 rounded-full text-gray-700 shadow-sm focus:outline-none transition">
                        <option value="">Semua Tanggal</option>
                        <option value="hari-ini">Hari Ini</option>
                        <option value="bulan-ini">Bulan Ini</option>
                    </select>
                </div>
            </div>

            <div class="bg-white border border-red-400 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 uppercase text-[10px] tracking-wider font-bold">
                                <th class="p-4 text-center w-16">No</th>
                                <th class="p-4">Order ID</th>
                                <th class="p-4">Pelanggan</th>
                                <th class="p-4">Tanggal</th>
                                <th class="p-4">Total</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-center gap-1.5 text-xs pt-2">
                <button onclick="changePage('prev')" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded flex items-center justify-center transition shadow-sm font-bold">‹</button>
                <div id="pagination-numbers" class="flex gap-1.5">
                    </div>
                <button onclick="changePage('next')" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded flex items-center justify-center transition shadow-sm font-bold">›</button>
            </div>
        </main>
    </div>

    <script>
        let currentPage = 1;
        const itemsPerPage = 5;

        // Data Mockup Sesuai Persis dengan Screenshot 2026-06-13 161826.png
        const dataPesanan = [
            { id: "#ORD-00152", nama: "Budi Santoso", tgl: "20 Mei 2026", total: "Rp 350.000", status: "Menunggu" },
            { id: "#ORD-00151", nama: "Siti Aisyah", tgl: "20 Mei 2026", total: "Rp 240.000", status: "Diproses" },
            { id: "#ORD-00150", nama: "Andi Wijaya", tgl: "19 Mei 2026", total: "Rp 125.000", status: "Dicetak" },
            { id: "#ORD-00149", nama: "Dinda Amelia", tgl: "18 Mei 2026", total: "Rp 870.000", status: "Dikirim" },
            { id: "#ORD-00148", nama: "Rian Pratama", tgl: "18 Mei 2026", total: "Rp 320.000", status: "Selesai" },
            { id: "#ORD-00147", nama: "Eko Prasetyo", tgl: "17 Mei 2026", total: "Rp 150.000", status: "Selesai" },
            { id: "#ORD-00146", nama: "Dewi Lestari", tgl: "16 Mei 2026", total: "Rp 540.000", status: "Diproses" }
        ];

        let filteredData = [...dataPesanan];

        function renderTable() {
            const tbody = document.getElementById('table-body');
            tbody.innerHTML = '';

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageItems = filteredData.slice(startIndex, endIndex);

            pageItems.forEach((item, index) => {
                const no = startIndex + index + 1;
                
                // Menentukan warna badge status dinamis
                let statusClass = "bg-gray-100 text-gray-700";
                if (item.status === "Menunggu") statusClass = "bg-amber-50 text-amber-600 border border-amber-200";
                else if (item.status === "Diproses") statusClass = "bg-blue-50 text-blue-600 border border-blue-200";
                else if (item.status === "Dicetak") statusClass = "bg-purple-50 text-purple-600 border border-purple-200";
                else if (item.status === "Dikirim") statusClass = "bg-indigo-50 text-indigo-600 border border-indigo-200";
                else if (item.status === "Selesai") statusClass = "bg-green-50 text-green-600 border border-green-200";

                const tr = document.createElement('tr');
                tr.className = "hover:bg-gray-50/50 border-b border-gray-100 transition";
                tr.innerHTML = `
                    <td class="p-4 text-center text-gray-400 font-medium">${no}</td>
                    <td class="p-4 font-mono text-xs font-bold text-gray-700">${item.id}</td>
                    <td class="p-4 font-semibold text-gray-800">${item.nama}</td>
                    <td class="p-4 text-gray-500 font-medium text-xs">${item.tgl}</td>
                    <td class="p-4 font-bold text-gray-800 text-xs">${item.total}</td>
                    <td class="p-4 text-center">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold ${statusClass}">${item.status}</span>
                    </td>
                    <td class="p-4 text-center">
                        <button onclick="window.location.href='{{ route('admin.pesanan.detail') }}'" class="px-4 py-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white text-gray-600 rounded-lg text-[11px] font-bold shadow-sm transition">
                            Detail
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            renderPagination();
        }

        function filterPesanan() {
            const searchKeyword = document.getElementById('search-input').value.toLowerCase();
            const selectedStatus = document.getElementById('status-filter').value;

            filteredData = dataPesanan.filter(item => {
                const matchesSearch = item.id.toLowerCase().includes(searchKeyword) || item.nama.toLowerCase().includes(searchKeyword);
                const matchesStatus = selectedStatus === "" || item.status === selectedStatus;
                return matchesSearch && matchesStatus;
            });

            currentPage = 1;
            renderTable();
        }

        function renderPagination() {
            const container = document.getElementById('pagination-numbers');
            container.innerHTML = '';
            
            const totalPages = Math.ceil(filteredData.length / itemsPerPage) || 1;

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.innerText = i;
                if (i === currentPage) {
                    btn.className = "w-7 h-7 bg-red-700 text-white rounded flex items-center justify-center shadow-sm font-bold";
                } else {
                    btn.className = "w-7 h-7 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded flex items-center justify-center transition";
                }
                btn.onclick = () => {
                    currentPage = i;
                    renderTable();
                };
                container.appendChild(btn);
            }
        }

        function changePage(direction) {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage) || 1;
            if (direction === 'prev' && currentPage > 1) currentPage--;
            else if (direction === 'next' && currentPage < totalPages) currentPage++;
            renderTable();
        }

        document.addEventListener("DOMContentLoaded", renderTable);
    </script>
</body>
</html>