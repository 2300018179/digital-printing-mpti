<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Promo - Fantastic Digital Printing</title>
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
            <div>
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">Tambah Promo Baru</h2>
                <p class="text-[11px] text-gray-400 mt-1">Dashboard &nbsp;/&nbsp; Data Promo &nbsp;/&nbsp; Tambah Promo</p>
            </div>

            <div class="bg-white border border-red-400 rounded-2xl shadow-sm p-6 max-w-4xl">
                <form id="formPromo" onsubmit="simulasiSimpan(event)">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs font-medium text-gray-700">
                        
                        <div class="md:col-span-2 flex flex-col gap-2">
                            <label for="nama_promo" class="font-semibold text-gray-800">Nama Promo</label>
                            <input type="text" id="nama_promo" placeholder="Contoh: Promo Grand Opening" required class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-normal text-gray-600">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="kode_promo" class="font-semibold text-gray-800">Kode Promo</label>
                            <input type="text" id="kode_promo" placeholder="Contoh: OPENING10" required style="text-transform: uppercase;" class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-bold tracking-wider text-red-700">
                            <span class="text-[10px] text-gray-400 font-normal">Kode unik kupon saat checkout pelanggan.</span>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="font-semibold text-gray-800">Tipe Diskon</label>
                            <div class="flex gap-3 h-full items-center">
                                <label id="lbl-persen" class="flex-1 flex items-center gap-2 p-3 border border-red-500 bg-red-50/50 text-red-700 rounded-xl cursor-pointer font-bold justify-center transition">
                                    <input type="radio" name="tipe_diskon" value="Persentase" checked onclick="gantiTipeDiskon('persen')" class="accent-red-700"> Persentase (%)
                                </label>
                                <label id="lbl-nominal" class="flex-1 flex items-center gap-2 p-3 border border-gray-200 text-gray-500 rounded-xl cursor-pointer justify-center transition">
                                    <input type="radio" name="tipe_diskon" value="Nominal" onclick="gantiTipeDiskon('nominal')" class="accent-red-700"> Nominal (Rp)
                                </label>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label id="lbl-nilai-diskon" for="nilai_diskon" class="font-semibold text-gray-800">Besar Diskon (%)</label>
                            <input type="number" id="nilai_diskon" placeholder="10" min="1" max="100" required class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-normal text-gray-600">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="min_transaksi" class="font-semibold text-gray-800">Minimal Transaksi (Optional)</label>
                            <input type="number" id="min_transaksi" placeholder="0" min="0" class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-normal text-gray-600">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="tgl_mulai" class="font-semibold text-gray-800">Tanggal Mulai</label>
                            <input type="date" id="tgl_mulai" required class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-normal text-gray-600">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="tgl_selesai" class="font-semibold text-gray-800">Tanggal Berakhir</label>
                            <input type="date" id="tgl_selesai" required class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-normal text-gray-600">
                        </div>

                        <div class="md:col-span-2 flex flex-col gap-2 pt-2">
                            <label class="font-semibold text-gray-800">Status Promo</label>
                            <div class="flex gap-4">
                                <label id="status-aktif" class="flex items-center gap-2 px-4 py-2.5 border border-red-500 bg-red-50/50 text-red-700 font-bold rounded-xl cursor-pointer text-xs transition">
                                    <input type="radio" name="status" value="Aktif" checked onclick="gantiStatusStyle('aktif')" class="accent-red-700"> <span class="text-green-500">●</span> Aktif
                                </label>
                                <label id="status-nonaktif" class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 text-gray-500 rounded-xl cursor-pointer text-xs transition">
                                    <input type="radio" name="status" value="Nonaktif" onclick="gantiStatusStyle('nonaktif')" class="accent-red-700"> <span class="text-gray-400">●</span> Nonaktif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 border-t border-gray-100 mt-6 pt-4 text-xs font-bold">
                        <a href="{{ route('admin.promo') }}" class="px-5 py-2.5 border border-gray-300 text-gray-600 rounded-full hover:bg-gray-100 transition shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-red-700 hover:bg-red-800 text-white rounded-full shadow-sm transition">
                            Simpan Promo
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <div id="toast" class="fixed top-5 right-[-400px] bg-gray-900 text-white px-5 py-4 rounded-xl shadow-lg flex items-center gap-3 transition-all duration-300 z-50 text-xs">
        <span class="text-green-400 text-base">✔</span>
        <div>
            <strong class="block text-white mb-0.5">Berhasil!</strong>
            <span id="toast-text" class="text-gray-300">Data promo divalidasi oleh sistem view.</span>
        </div>
    </div>

    <script>
        // Set default tanggal hari ini
        document.getElementById('tgl_mulai').valueAsDate = new Date();

        // Ganti Tipe Diskon (Persen atau Rupiah)
        function gantiTipeDiskon(tipe) {
            const p = document.getElementById('lbl-persen');
            const n = document.getElementById('lbl-nominal');
            const label = document.getElementById('lbl-nilai-diskon');
            const input = document.getElementById('nilai_diskon');

            if (tipe === 'persen') {
                p.className = "flex-1 flex items-center gap-2 p-3 border border-red-500 bg-red-50/50 text-red-700 rounded-xl cursor-pointer font-bold justify-center transition";
                n.className = "flex-1 flex items-center gap-2 p-3 border border-gray-200 text-gray-500 rounded-xl cursor-pointer justify-center transition";
                label.innerText = "Besar Diskon (%)";
                input.placeholder = "10";
                input.max = "100";
            } else {
                n.className = "flex-1 flex items-center gap-2 p-3 border border-red-500 bg-red-50/50 text-red-700 rounded-xl cursor-pointer font-bold justify-center transition";
                p.className = "flex-1 flex items-center gap-2 p-3 border border-gray-200 text-gray-500 rounded-xl cursor-pointer justify-center transition";
                label.innerText = "Besar Diskon (Nominal Rp)";
                input.placeholder = "25000";
                input.removeAttribute('max');
            }
        }

        // Ganti Style Border Radio Button Status
        function gantiStatusStyle(status) {
            const a = document.getElementById('status-aktif');
            const na = document.getElementById('status-nonaktif');

            if (status === 'aktif') {
                a.className = "flex items-center gap-2 px-4 py-2.5 border border-red-500 bg-red-50/50 text-red-700 font-bold rounded-xl cursor-pointer text-xs transition";
                na.className = "flex items-center gap-2 px-4 py-2.5 border border-gray-200 text-gray-500 rounded-xl cursor-pointer text-xs transition";
            } else {
                na.className = "flex items-center gap-2 px-4 py-2.5 border border-red-500 bg-red-50/50 text-red-700 font-bold rounded-xl cursor-pointer text-xs transition";
                a.className = "flex items-center gap-2 px-4 py-2.5 border border-gray-200 text-gray-500 rounded-xl cursor-pointer text-xs transition";
            }
        }

        // Simulasi validasi submit form di tahap View
        function simulasiSimpan(e) {
            e.preventDefault();
            const nama = document.getElementById('nama_promo').value;
            
            document.getElementById('toast-text').innerText = `Promo "${nama}" sukses divalidasi!`;
            const toast = document.getElementById('toast');
            toast.style.right = '20px';

            setTimeout(() => {
                toast.style.right = '-400px';
                alert("Simulasi Aksi Menyimpan Sukses! Semua elemen form berfungsi dengan baik di sisi tampilan.");
            }, 3000);
        }
    </script>
</body>
</html>