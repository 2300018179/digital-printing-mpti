<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Toko - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- ATAS: NAVBAR ADMIN -->
    <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-4">
            <!-- Tombol Kembali ke Dashboard Utama -->
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-red-700 font-bold text-xs flex items-center gap-1 transition" title="Kembali ke Dashboard Utama">
                ⬅️ Kembali
            </a>
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
        <!-- KIRI: SIDEBAR KHUSUS FITUR PENGATURAN -->
        <aside class="w-64 bg-red-700 text-white flex flex-col min-h-[calc(100vh-57px)] sticky top-[57px]">
            <div class="py-6 px-3">
                <nav class="space-y-1">
                    <button onclick="switchTab('informasi-toko', this)" class="tab-btn w-full text-left bg-red-800 font-bold flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Informasi Toko
                    </button>
                    <button onclick="switchTab('alamat-toko', this)" class="tab-btn w-full text-left hover:bg-red-600/40 font-medium flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Alamat Toko
                    </button>
                    <button onclick="switchTab('jam-operasional', this)" class="tab-btn w-full text-left hover:bg-red-600/40 font-medium flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Jam Operasional
                    </button>
                    <button onclick="switchTab('sosial-media', this)" class="tab-btn w-full text-left hover:bg-red-600/40 font-medium flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Sosial Media
                    </button>
                    <button onclick="switchTab('metode-pembayaran', this)" class="tab-btn w-full text-left hover:bg-red-600/40 font-medium flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Metode Pembayaran
                    </button>
                    <button onclick="switchTab('notifikasi', this)" class="tab-btn w-full text-left hover:bg-red-600/40 font-medium flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Notifikasi
                    </button>
                </nav>
            </div>
        </aside>

        <!-- KANAN: KONTEN UTAMA YANG BERGANTI DINAMIS -->
        <main class="flex-1 p-10 relative flex flex-col justify-between min-h-[calc(100vh-57px)]">
            
            <form id="form-pengaturan" onsubmit="handleSimpan(event)" class="space-y-8 flex-1">
                
                <!-- TAB 1: INFORMASI TOKO (DEFAULT / PERSIS SCREENSHOT) -->
                <div id="content-informasi-toko" class="tab-content grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <!-- Kolom Kiri Kuesioner Teks -->
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 tracking-wide">Informasi Toko</h2>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Nama Toko</label>
                            <input type="text" placeholder="Masukkan Nama Toko" class="w-full px-4 py-3 bg-white border border-gray-300 focus:border-red-500 rounded-xl text-xs font-medium text-gray-700 placeholder-gray-400 focus:outline-none transition shadow-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Deskripsi Toko</label>
                            <textarea rows="8" placeholder="Masukkan Deskripsi Toko" class="w-full px-4 py-3 bg-white border border-red-400 focus:border-red-600 rounded-2xl text-xs font-medium text-gray-700 placeholder-gray-400 focus:outline-none transition shadow-sm resize-none"></textarea>
                        </div>
                    </div>

                    <!-- Kolom Kanan Upload Media -->
                    <div class="space-y-6 lg:mt-9">
                        <!-- Upload Logo -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Logo Toko</label>
                            <div class="border border-red-400 rounded-2xl p-6 text-center bg-white hover:bg-red-50/30 transition cursor-pointer flex flex-col items-center justify-center h-32">
                                <span class="text-lg mb-1">🖼️</span>
                                <p class="text-[10px] font-medium text-gray-600 leading-relaxed">Klik atau drag file untuk upload<br><span class="text-gray-400">JPG dan PNG</span></p>
                            </div>
                        </div>

                        <!-- Upload Banner -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Banner Toko</label>
                            <div class="border border-red-400 rounded-2xl p-6 text-center bg-white hover:bg-red-50/30 transition cursor-pointer flex flex-col items-center justify-center h-32">
                                <span class="text-lg mb-1">✨</span>
                                <p class="text-[10px] font-medium text-gray-600 leading-relaxed">Klik atau drag file untuk upload<br><span class="text-gray-400">JPG dan PNG</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: ALAMAT TOKO (INTERAKTIF EXTRA) -->
                <div id="content-alamat-toko" class="tab-content hidden space-y-6 max-w-xl">
                    <h2 class="text-xl font-bold text-gray-900 tracking-wide">Alamat Toko</h2>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-800">Alamat Lengkap Lengkap Workshop</label>
                        <input type="text" placeholder="Jl. Raya Digital Printing No. 88, Kota" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-red-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Kota / Kabupaten</label>
                            <input type="text" placeholder="Surabaya" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-xs">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Kode Pos</label>
                            <input type="text" placeholder="60111" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-xs">
                        </div>
                    </div>
                </div>

                <!-- TAB 3: JAM OPERASIONAL -->
                <div id="content-jam-operasional" class="tab-content hidden space-y-6 max-w-xl">
                    <h2 class="text-xl font-bold text-gray-900 tracking-wide">Jam Operasional Toko</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl text-xs">
                            <span class="font-semibold text-gray-700">Senin - Jumat</span>
                            <input type="text" value="08:00 - 21:00" class="border border-gray-300 rounded px-2 py-1 text-center w-32 focus:outline-none focus:border-red-500">
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl text-xs">
                            <span class="font-semibold text-gray-700">Sabtu</span>
                            <input type="text" value="09:00 - 17:00" class="border border-gray-300 rounded px-2 py-1 text-center w-32 focus:outline-none focus:border-red-500">
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl text-xs">
                            <span class="font-semibold text-gray-700">Minggu / Hari Libur</span>
                            <span class="text-red-600 font-bold uppercase tracking-wider text-[10px] bg-red-50 px-3 py-1 rounded-full">Tutup</span>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: SOSIAL MEDIA -->
                <div id="content-sosial-media" class="tab-content hidden space-y-6 max-w-xl">
                    <h2 class="text-xl font-bold text-gray-900 tracking-wide">Tautan Sosial Media</h2>
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">WhatsApp Bisnis</label>
                            <input type="text" value="https://wa.me/628123456789" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-xs font-mono text-gray-600">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Instagram Toko</label>
                            <input type="text" value="@fantastic.print" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-xs font-mono text-gray-600">
                        </div>
                    </div>
                </div>

                <!-- TAB 5: METODE PEMBAYARAN -->
                <div id="content-metode-pembayaran" class="tab-content hidden space-y-6 max-w-xl">
                    <h2 class="text-xl font-bold text-gray-900 tracking-wide">Metode Pembayaran Aktif</h2>
                    <p class="text-xs text-gray-500">Pilih gerbang pembayaran yang dapat digunakan pelanggan di sistem utama.</p>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl cursor-pointer text-xs font-semibold">
                            <input type="checkbox" checked class="accent-red-600 w-4 h-4"> Transfer Bank Manual (BCA, Mandiri, BNI)
                        </label>
                        <label class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl cursor-pointer text-xs font-semibold">
                            <input type="checkbox" checked class="accent-red-600 w-4 h-4"> QRIS Otomatis (Gopay, OVO, Dana)
                        </label>
                    </div>
                </div>

                <!-- TAB 6: NOTIFIKASI -->
                <div id="content-notifikasi" class="tab-content hidden space-y-6 max-w-xl">
                    <h2 class="text-xl font-bold text-gray-900 tracking-wide">Sistem Notifikasi</h2>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl cursor-pointer text-xs font-semibold">
                            <input type="checkbox" checked class="accent-red-600 w-4 h-4"> Kirim struk otomatis ke email pelanggan setelah bayar
                        </label>
                        <label class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl cursor-pointer text-xs font-semibold">
                            <input type="checkbox" checked class="accent-red-600 w-4 h-4"> Beritahu Admin via email jika ada orderan masuk baru
                        </label>
                    </div>
                </div>

                <!-- DUA TOMBOL AKSI FIX (PERSIS DI GAMBAR BAWAH KANAN) -->
                <div class="flex items-center justify-end gap-3 pt-10 border-t border-gray-100 mt-12">
                    <button type="button" onclick="handleBatal()" class="px-8 py-2.5 border border-red-500 text-red-700 hover:bg-red-50 font-bold text-xs rounded-full transition shadow-sm min-w-[110px] text-center">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-2.5 bg-red-700 hover:bg-red-800 text-white font-bold text-xs rounded-full transition shadow-sm min-w-[110px] text-center">
                        Simpan
                    </button>
                </div>

            </form>
        </main>
    </div>

    <!-- JAVASCRIPT LOGIK TABS INTERACTION & ALERT FUNGSIONAL -->
    <script>
        // Fungsi memindahkan Tab Konten Tanpa Reload Halaman
        function switchTab(tabId, element) {
            // Hapus semua tampilan aktif pada tab content
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.add('hidden'));

            // Tampilkan konten tab yang dituju
            document.getElementById('content-' + tabId).classList.remove('hidden');

            // Reset style seluruh tombol sidebar menjadi tidak aktif
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => {
                btn.classList.remove('bg-red-800', 'font-bold');
                btn.classList.add('hover:bg-red-600/40', 'font-medium');
            });

            // Aktifkan style tombol yang baru saja diklik
            element.classList.remove('hover:bg-red-600/40', 'font-medium');
            element.classList.add('bg-red-800', 'font-bold');
        }

        // Interaksi Tombol Simpan
        function handleSimpan(event) {
            event.preventDefault(); // menahan reload form asli
            alert('Sukses! Konfigurasi perubahan pengaturan toko berhasil disimpan ke dalam basis data.');
        }

        // Interaksi Tombol Batal
        function handleBatal() {
            if(confirm('Apakah Anda yakin ingin membatalkan perubahan dan mereset form pengaturan?')) {
                document.getElementById('form-pengaturan').reset();
            }
        }
    </script>
</body>
</html>