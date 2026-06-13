<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Fantastic Digital Printing</title>
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

        <main class="flex-1 p-8 space-y-6 max-w-5xl">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 tracking-wide">Detail Pesanan <span class="font-mono text-red-700">#ORD-00152</span></h2>
                    <p class="text-xs text-gray-500 mt-1">Masuk pada tanggal 20 Mei 2026 pukul 14:22 WIB</p>
                </div>
                <a href="{{ route('admin.pesanan') }}" class="px-4 py-2 border border-gray-300 hover:bg-gray-100 rounded-full text-xs font-bold text-gray-600 transition shadow-sm">
                    ← Kembali ke Pesanan
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white border border-red-400 rounded-2xl shadow-sm p-6 space-y-4">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-100 pb-2">Item Cetakan</h3>
                        
                        <div class="flex items-start gap-4 py-2">
                            <div class="w-16 h-16 bg-gray-100 border border-gray-200 rounded-xl flex items-center justify-center text-2xl shadow-inner">
                                🖼️
                            </div>
                            <div class="flex-1 space-y-1">
                                <h4 class="text-xs font-bold text-gray-800">Cetak Banner MMT (Outdoor)</h4>
                                <p class="text-[11px] text-gray-500">Ukuran: 3x1 Meter &nbsp;|&nbsp; Bahan: Flexi Korea 340gr</p>
                                <p class="text-[11px] text-gray-500">Finishing: Mata ayam di setiap sudut (4 buah)</p>
                                <div class="pt-1">
                                    <span class="px-2 py-0.5 bg-gray-100 border border-gray-200 text-gray-600 text-[10px] rounded font-mono font-semibold">File: desain_banner_toko.pdf</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-gray-800">Rp 120.000</p>
                                <p class="text-[11px] text-gray-400">x 2 Pcs</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 py-2 border-t border-gray-50">
                            <div class="w-16 h-16 bg-gray-100 border border-gray-200 rounded-xl flex items-center justify-center text-2xl shadow-inner">
                                📄
                            </div>
                            <div class="flex-1 space-y-1">
                                <h4 class="text-xs font-bold text-gray-800">Brosur A5 Art Paper</h4>
                                <p class="text-[11px] text-gray-500">Cetak: 2 Sisi (Bolak-balik) &nbsp;|&nbsp; Bahan: Art Paper 150gr</p>
                                <div class="pt-1">
                                    <span class="px-2 py-0.5 bg-gray-100 border border-gray-200 text-gray-600 text-[10px] rounded font-mono font-semibold">File: brosur_promosi_v2.ai</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-gray-800">Rp 110.000</p>
                                <p class="text-[11px] text-gray-400">x 1 Paket (100 lbr)</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-red-400 rounded-2xl shadow-sm p-6 space-y-3">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-100 pb-2">Rincian Pembayaran</h3>
                        <div class="flex justify-between text-xs font-medium text-gray-500">
                            <span>Subtotal Item</span>
                            <span class="text-gray-800 font-semibold">Rp 350.000</span>
                        </div>
                        <div class="flex justify-between text-xs font-medium text-gray-500">
                            <span>Biaya Pengiriman (Kurir Toko)</span>
                            <span class="text-gray-800 font-semibold">Rp 0 (Free)</span>
                        </div>
                        <hr class="border-gray-100">
                        <div class="flex justify-between text-xs font-bold text-gray-800">
                            <span>Total Pembayaran</span>
                            <span class="text-red-700 text-sm">Rp 350.000</span>
                        </div>
                        <div class="flex justify-between text-[11px] font-medium text-gray-500 pt-2">
                            <span>Metode Pembayaran</span>
                            <span class="bg-green-50 border border-green-200 text-green-600 px-2 py-0.5 rounded font-bold uppercase">Transfer Bank (Lunas)</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white border border-red-400 rounded-2xl shadow-sm p-6 space-y-4">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-100 pb-2">Status Alur Cetak</h3>
                        
                        <div class="space-y-2">
                            <label for="update-status" class="block text-[11px] font-bold text-gray-500 uppercase">Perbarui Status</label>
                            <select id="update-status" class="w-full px-3 py-2 text-xs font-semibold bg-white border border-gray-300 rounded-xl text-gray-700 focus:outline-none focus:border-red-600 transition">
                                <option value="Menunggu" selected>Menunggu Konfirmasi</option>
                                <option value="Diproses">Diproses Admin</option>
                                <option value="Dicetak">Sedang Dicetak</option>
                                <option value="Dikirim">Siap Diambil / Dikirim</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>

                        <button onclick="alert('Status pesanan berhasil diperbarui!')" class="w-full py-2.5 bg-red-700 hover:bg-red-800 text-white rounded-xl text-xs font-bold transition shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>

                    <div class="bg-white border border-red-400 rounded-2xl shadow-sm p-6 space-y-3">
                        <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-100 pb-2">Informasi Pelanggan</h3>
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-800">Budi Santoso</p>
                            <p class="text-[11px] text-gray-500">📞 0812-3456-7890</p>
                            <p class="text-[11px] text-gray-500">✉️ budi.santoso@gmail.com</p>
                        </div>
                        <hr class="border-gray-100">
                        <div class="space-y-1">
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Alamat Pengiriman</p>
                            <p class="text-[11px] text-gray-600 leading-relaxed font-medium">Jl. Letjend Suprapto No. 45, Banjarnegara, Jawa Tengah, 53412.</p>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>