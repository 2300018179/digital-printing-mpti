<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran - Fantastic Digital Printing</title>
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
                    <a href="{{ route('admin.pembayaran') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
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
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">Verifikasi Pembayaran</h2>
                <p class="text-xs text-gray-500 mt-1">Periksa bukti transfer dan konfirmasi pembayaran dari pelanggan.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button id="tab-menunggu" onclick="switchTab('Menunggu')" class="px-5 py-2.5 bg-white border-2 border-red-600 text-red-700 font-bold text-xs rounded-full shadow-sm transition">
                    Menunggu Verifikasi (<span id="count-menunggu">4</span>)
                </button>
                <button id="tab-disetujui" onclick="switchTab('Disetujui')" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-600 font-bold text-xs rounded-full transition">
                    Sudah Diverifikasi
                </button>
                <button id="tab-ditolak" onclick="switchTab('Ditolak')" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-600 font-bold text-xs rounded-full transition">
                    Ditolak
                </button>
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
                                <th class="p-4 text-center w-32">Bukti Transfer</th>
                                <th id="th-aksi" class="p-4 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pembayaran-table-body">
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-center gap-1.5 text-xs pt-2">
                <button class="w-7 h-7 bg-gray-100 text-gray-400 rounded flex items-center justify-center font-bold cursor-not-allowed">‹</button>
                <button class="w-7 h-7 bg-red-700 text-white rounded flex items-center justify-center shadow-sm font-bold">1</button>
                <button class="w-7 h-7 bg-gray-100 text-gray-400 rounded flex items-center justify-center font-bold cursor-not-allowed">›</button>
            </div>
        </main>
    </div>

    <script>
        let currentTab = 'Menunggu';

        // Data Mentah Berdasarkan Gambar Ketiga (Wireframe)
        let dataPembayaran = [
            { id: "#ORD-00152", nama: "Budi Santoso", tgl: "20 Mei 2026", total: "Rp 350.000", status: "Menunggu" },
            { id: "#ORD-00151", nama: "Siti Aisyah", tgl: "20 Mei 2026", total: "Rp 240.000", status: "Menunggu" },
            { id: "#ORD-00150", nama: "Andi Wijaya", tgl: "19 Mei 2026", total: "Rp 125.000", status: "Menunggu" },
            { id: "#ORD-00149", nama: "Dinda Amelia", tgl: "18 Mei 2026", total: "Rp 870.000", status: "Menunggu" }
        ];

        function renderPembayaran() {
            const tbody = document.getElementById('pembayaran-table-body');
            const thAksi = document.getElementById('th-aksi');
            tbody.innerHTML = '';

            // Filter data berdasarkan tab aktif
            const filtered = dataPembayaran.filter(item => item.status === currentTab);
            
            // Update jumlah counter angka di tab Menunggu Verifikasi
            const totalMenunggu = dataPembayaran.filter(item => item.status === 'Menunggu').length;
            document.getElementById('count-menunggu').innerText = totalMenunggu;

            // Sembunyikan kolom aksi jika berada di tab 'Sudah Diverifikasi' atau 'Ditolak'
            if (currentTab === 'Menunggu') {
                thAksi.style.display = '';
            } else {
                thAksi.style.display = 'none';
            }

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="p-8 text-center text-xs font-medium text-gray-400">Tidak ada data pembayaran dengan status ini.</td></tr>`;
                return;
            }

            filtered.forEach((item, index) => {
                const tr = document.createElement('tr');
                tr.className = "hover:bg-gray-50/50 border-b border-gray-100 transition";
                
                let aksiHTML = '';
                if (currentTab === 'Menunggu') {
                    aksiHTML = `
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="prosesVerifikasi('${item.id}', 'Disetujui')" class="w-8 h-8 bg-white border border-gray-300 hover:border-green-600 text-green-600 rounded-lg text-xs font-bold shadow-sm transition flex items-center justify-center">✔️</button>
                                <button onclick="prosesVerifikasi('${item.id}', 'Ditolak')" class="w-8 h-8 bg-white border border-gray-300 hover:border-red-600 text-red-600 rounded-lg text-xs font-bold shadow-sm transition flex items-center justify-center">❌</button>
                            </div>
                        </td>
                    `;
                }

                tr.innerHTML = `
                    <td class="p-4 text-center text-gray-400 font-medium text-xs">${index + 1}</td>
                    <td class="p-4 font-mono text-xs font-bold text-gray-700">${item.id}</td>
                    <td class="p-4 font-semibold text-gray-800 text-xs">${item.nama}</td>
                    <td class="p-4 text-gray-500 font-medium text-xs">${item.tgl}</td>
                    <td class="p-4 font-bold text-gray-800 text-xs">${item.total}</td>
                    <td class="p-4 text-center">
                        <button onclick="openModal('${item.id}')" class="w-8 h-8 bg-white border border-gray-300 hover:border-red-600 text-gray-600 hover:text-red-600 rounded-lg shadow-sm transition inline-flex items-center justify-center text-xs">
                            📄
                        </button>
                    </td>
                    ${aksiHTML}
                `;
                tbody.appendChild(tr);
            });
        }

        function switchTab(tabName) {
            currentTab = tabName;
            
            // Atur gaya tombol agar berubah warna sesuai tab aktif
            const btnMenunggu = document.getElementById('tab-menunggu');
            const btnDisetujui = document.getElementById('tab-disetujui');
            const btnDitolak = document.getElementById('tab-ditolak');

            // Reset class semua tombol jadi mode pasif
            [btnMenunggu, btnDisetujui, btnDitolak].forEach(btn => {
                btn.className = "px-5 py-2.5 bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-600 font-bold text-xs rounded-full transition";
            });

            // Beri warna merah maroon aktif pada tab yang diklik
            if (tabName === 'Menunggu') {
                btnMenunggu.className = "px-5 py-2.5 bg-white border-2 border-red-600 text-red-700 font-bold text-xs rounded-full shadow-sm transition";
            } else if (tabName === 'Disetujui') {
                btnDisetujui.className = "px-5 py-2.5 bg-white border-2 border-red-600 text-red-700 font-bold text-xs rounded-full shadow-sm transition";
            } else if (tabName === 'Ditolak') {
                btnDitolak.className = "px-5 py-2.5 bg-white border-2 border-red-600 text-red-700 font-bold text-xs rounded-full shadow-sm transition";
            }

            renderPembayaran();
        }

        function prosesVerifikasi(orderId, statusBaru) {
            const index = dataPembayaran.findIndex(item => item.id === orderId);
            if (index !== -1) {
                dataPembayaran[index].status = statusBaru;
                alert(`Pembayaran untuk order ${orderId} telah berhasil diadopsi ke status: ${statusBaru}!`);
                renderPembayaran();
            }
        }

        document.addEventListener("DOMContentLoaded", renderPembayaran);

        // Fungsi untuk Membuka Pop-up Gambar Bukti Transfer
        function openModal(orderId) {
            const modal = document.getElementById('buktiModal');
            const modalIdText = document.getElementById('modalOrderId');
            
            // Set teks Order ID sesuai baris yang diklik
            modalIdText.innerText = orderId;
            
            // Tampilkan modal dengan efek transisi halus
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        }

        // Fungsi untuk Menutup Pop-up Gambar Bukti Transfer
        function closeModal() {
            const modal = document.getElementById('buktiModal');
            
            modal.classList.add('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Menunggu animasi transisi selesai sebelum disembunyikan
        }
    </script>
    <!-- ========================================== -->
    <!-- POP-UP MODAL BUKTI TRANSFER (TAMBAHAN BARU) -->
    <!-- ========================================== -->
    <div id="buktiModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-2xl max-w-sm w-full overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300 border border-gray-100">
            <!-- Header Modal -->
            <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <div>
                    <h3 class="text-xs font-bold text-gray-800">Bukti Transfer Pelanggan</h3>
                    <p id="modalOrderId" class="text-[10px] font-mono text-red-600 font-bold mt-0.5">#ORD-XXXXX</p>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-lg font-bold focus:outline-none transition p-1">
                    ✕
                </button>
            </div>
            <!-- Konten Foto Resi -->
            <div class="p-5 bg-gray-100 flex items-center justify-center">
                <!-- Di sini gambar mockup resi struk bank dipasang -->
                <img id="modalImage" src="https://i.pinimg.com/736x/8a/05/89/8a0589df464972e391b1580f4f9f40dc.jpg" 
                     alt="Bukti Transfer Mockup" class="max-h-96 w-auto object-contain rounded-lg shadow-sm border border-gray-200">
            </div>
            <!-- Footer Modal -->
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex justify-end">
                <button onclick="closeModal()" class="px-4 py-1.5 bg-red-700 hover:bg-red-800 text-white rounded-xl text-xs font-bold transition shadow-sm">
                    Tutup Pratinjau
                </button>
            </div>
        </div>
    </div>
</body>
</html>