<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantastic Digital Printing - Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white px-8 py-4 flex justify-between items-center max-w-7xl w-full mx-auto">
        <div class="flex items-center">
            <img src="{{ asset('img/logo.png') }}" alt="FANTASTIC DIGITAL PRINTING" class="h-14 object-contain" onerror="this.onerror=null; this.outerHTML='<div class=\'text-center border-2 border-red-600 px-3 py-1 bg-red-50 rounded-lg\'><span class=\'text-xs font-black text-red-600 block leading-none\'>FANTASTIC</span><span class=\'text-[9px] text-gray-700 tracking-widest font-bold uppercase\'>Digital Printing</span></div>';">
        </div>

        <div class="w-2/5 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" placeholder="Mau Print Apa Hari ini ?" class="w-full bg-gray-100 border border-transparent rounded-full pl-10 pr-4 py-2 text-sm focus:outline-none focus:bg-white focus:border-red-500 transition duration-200">
        </div>

        <div class="flex items-center gap-6">
            <button class="text-gray-700 hover:text-red-600 relative transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </button>
            <button class="text-gray-700 hover:text-red-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </button>
            <div class="flex gap-2">
                <a href="{{ route('login') }}" class="border border-red-500 text-red-500 font-semibold px-5 py-1.5 rounded-full text-xs hover:bg-red-50 transition">Log In</a>
                
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white font-semibold px-5 py-1.5 rounded-full text-xs hover:bg-red-700 transition">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <nav class="bg-red-600 text-white text-sm font-semibold sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex">
                <div class="bg-red-800 px-6 py-3.5 flex items-center gap-3 cursor-pointer select-none">
                    <span class="text-base">☰</span> Pilih Kategori
                </div>
                <div class="flex items-center gap-1 pl-4">
                    <a href="#" class="py-3.5 px-4 hover:bg-red-700 transition duration-150">Beranda</a>
                    <a href="#" class="py-3.5 px-4 hover:bg-red-700 transition duration-150">Semua Produk</a>
                    <a href="#" class="py-3.5 px-4 hover:bg-red-700 transition duration-150">Promo</a>
                    <a href="{{ route('customer.jam-layanan') }}" class="hover:text-gray-200 transition">Jam Layanan</a>
                    <a href="#" class="py-3.5 px-4 hover:bg-red-700 transition duration-150">Tentang Kami</a>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs font-medium">
                <span>💬 Pusat Bantuan :</span>
                <a href="https://wa.me/6285119622615" target="_blank" class="bg-white text-red-600 px-4 py-1.5 rounded-full font-bold hover:bg-gray-100 transition shadow-sm">Customer Service</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl w-full mx-auto px-4 py-6 flex gap-6 flex-1">
        
        <aside class="w-1/4 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden h-fit">
            <ul class="text-xs text-gray-700 font-semibold">
                <li><a href="#" class="flex justify-between items-center px-4 py-3 border-b hover:bg-red-50 hover:text-red-600 transition"><span>📄 Print On Paper</span> <span class="text-gray-400">›</span></a></li>
                <li><a href="#" class="flex justify-between items-center px-4 py-3 border-b hover:bg-red-50 hover:text-red-600 transition"><span>🏷️ Print Stiker</span> <span class="text-gray-400">›</span></a></li>
                <li><a href="#" class="flex justify-between items-center px-4 py-3 border-b hover:bg-red-50 hover:text-red-600 transition"><span>📅 Kalender</span> <span class="text-gray-400">›</span></a></li>
                <li><a href="#" class="flex justify-between items-center px-4 py-3 border-b hover:bg-red-50 hover:text-red-600 transition flex bg-red-50 text-red-600"><span>🚩 Banner & Spanduk</span> <span>›</span></a></li>
                <li><a href="#" class="flex justify-between items-center px-4 py-3 border-b hover:bg-red-50 hover:text-red-600 transition"><span>👕 Sablon</span> <span class="text-gray-400">›</span></a></li>
                <li><a href="#" class="flex justify-between items-center px-4 py-3 border-b hover:bg-red-50 hover:text-red-600 transition"><span>🎁 Souvenir</span> <span class="text-gray-400">›</span></a></li>
                <li><a href="#" class="flex justify-between items-center px-4 py-3 border-b hover:bg-red-50 hover:text-red-600 transition"><span>💌 Undangan</span> <span class="text-gray-400">›</span></a></li>
                <li><a href="#" class="flex justify-between items-center px-4 py-3 border-b hover:bg-red-50 hover:text-red-600 transition"><span>📋 Papan Informasi</span> <span class="text-gray-400">›</span></a></li>
                <li><a href="#" class="flex justify-between items-center px-4 py-3 hover:bg-red-50 hover:text-red-600 transition"><span>🪪 Tanda Pengenal</span> <span class="text-gray-400">›</span></a></li>
            </ul>
        </aside>

        <main class="w-3/4">
            <div class="bg-gray-300 w-full h-72 rounded-3xl shadow-inner relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-400 to-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm">
                    [ Tempat File Banner Slider Utama Utama ]
                </div>
                <button class="absolute left-4 top-1/2 -translate-y-1/2 bg-black text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-black opacity-70 hover:opacity-100 transition">‹</button>
                <button class="absolute right-4 top-1/2 -translate-y-1/2 bg-black text-white w-8 h-8 rounded-full flex items-center justify-center text-sm font-black opacity-70 hover:opacity-100 transition">›</button>
            </div>
        </main>
    </div>

    <section class="max-w-7xl w-full mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-50 border border-blue-200 p-4 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="bg-blue-600 text-white p-3 rounded-xl text-xl">🚚</div>
            <div>
                <h4 class="font-bold text-xs text-gray-800">Kirim Kemanapun</h4>
                <p class="text-[10px] text-gray-500 mt-0.5">Tersedia pilihan pengiriman dari instan hingga kargo</p>
            </div>
        </div>
        <div class="bg-gray-100 border border-gray-200 p-4 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="bg-red-600 text-white p-3 rounded-xl text-xl">⭐</div>
            <div>
                <h4 class="font-bold text-xs text-gray-800">Berkualitas</h4>
                <p class="text-[10px] text-gray-500 mt-0.5">Dicetak dengan mesin berteknologi tinggi</p>
            </div>
        </div>
        <div class="bg-gray-100 border border-gray-200 p-4 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="bg-red-600 text-white p-3 rounded-xl text-xl">⏱️</div>
            <div>
                <h4 class="font-bold text-xs text-gray-800">Proses Cepat</h4>
                <p class="text-[10px] text-gray-500 mt-0.5">Proses produksi cepat, bahkan bisa ditunggu</p>
            </div>
        </div>
        <div class="bg-gray-100 border border-gray-200 p-4 rounded-2xl flex items-center gap-4 shadow-sm">
            <div class="bg-red-600 text-white p-3 rounded-xl text-xl">🎧</div>
            <div>
                <h4 class="font-bold text-xs text-gray-800">Online Support</h4>
                <p class="text-[10px] text-gray-500 mt-0.5">Pesan hanya lewat online saja tanpa datang ke lokasi</p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl w-full mx-auto px-4 mb-12">
        <div class="flex justify-between items-center border-b pb-2 border-red-200 mb-6">
            <h3 class="text-xs font-bold text-red-600 uppercase tracking-wider border-l-4 border-red-600 pl-2">Produk Unggulan</h3>
            <a href="#" class="text-xs text-gray-600 font-bold hover:text-red-600 flex items-center gap-1 transition">Lihat Semua ›</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-5">
            @foreach($products as $product)
                <div class="bg-white rounded-3xl border border-red-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition duration-200">
                    <div class="bg-white p-4 h-36 flex items-center justify-center relative">
                        <span class="text-5xl opacity-80">{{ $product['icon'] }}</span>
                    </div>
                    <div class="bg-red-600 p-3 text-center flex flex-col gap-2">
                        <h4 class="font-bold text-white text-xs truncate">{{ $product['name'] }}</h4>
                        <div class="bg-white rounded-full py-1 px-3 mx-auto inline-block shadow-inner">
                            <p class="text-gray-800 font-black text-[10px]">{{ $product['price'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <footer class="bg-red-700 text-white text-[11px] pt-10 pb-6 border-t border-red-800 mt-auto">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div>
                <div class="font-black text-sm tracking-tight mb-3">FANTASTIC DIGITAL PRINTING</div>
                <p class="text-red-100 leading-relaxed text-justify">FantasticDigitalPrinting adalah layanan digital printing online terpercaya yang melayani berbagai kebutuhan cetak Anda dengan kualitas terbaik dan harga terjangkau.</p>
            </div>
            <div class="pl-4">
                <h5 class="font-bold text-xs mb-3 uppercase tracking-wide">Kategori Produk</h5>
                <div class="grid grid-cols-1 gap-1.5 text-red-200">
                    <a href="#" class="hover:text-white transition">Print On Paper</a>
                    <a href="#" class="hover:text-white transition">Print Stiker</a>
                    <a href="#" class="hover:text-white transition">Kalender</a>
                    <a href="#" class="hover:text-white transition">Banner & Spanduk</a>
                    <a href="#" class="hover:text-white transition">Sablon</a>
                    <a href="#" class="hover:text-white transition">Undangan</a>
                </div>
            </div>
            <div>
                <h5 class="font-bold text-xs mb-3 uppercase tracking-wide">Tentang Kami</h5>
                <div class="grid grid-cols-1 gap-1.5 text-red-200">
                    <a href="#" class="hover:text-white transition">Profil Perusahaan</a>
                </div>
                <h5 class="font-bold text-xs mt-4 mb-2 uppercase tracking-wide">Ikuti Kami</h5>
                <a href="#" class="text-lg hover:opacity-80 transition">📸 <span class="text-xs text-red-200 hover:text-white ml-1">Instagram</span></a>
            </div>
            <div>
                <h5 class="font-bold text-xs mb-3 uppercase tracking-wide">Jam Layanan</h5>
                <p class="text-red-100">🕒 Senin - Sabtu : 09.00 - 21.00</p>
                <p class="text-red-100 mt-1">🕒 Minggu : Tutup</p>
                
                <h5 class="font-bold text-xs mt-4 mb-2 uppercase tracking-wide">Hubungi Kami</h5>
                <p class="text-red-100 leading-tight">📍 Jl. Raya Timur Wanadadi, Dusun Dua, Wanadadi, Kec. Wanadadi, Kab. Banjarnegara, Jawa Tengah</p>
                <p class="text-red-100 mt-2">📞 +62 812-2978-3247</p>
                <p class="text-red-100">🟩 +62 851-1962-2615</p>
                <p class="text-red-100">✉️ fantasticwnd@gmail.com</p>
            </div>
        </div>
        <div class="text-center text-red-300 border-t border-red-600/50 mt-6 pt-4 max-w-7xl mx-auto px-4">
            &copy; 2026 Fantastic Digital Printing. Kelompok MPTI - All Rights Reserved.
        </div>
    </footer>

</body>
</html>