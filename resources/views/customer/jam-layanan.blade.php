<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jam Layanan - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white px-8 py-4 flex justify-between items-center max-w-7xl w-full mx-auto shadow-sm">
        <div class="flex items-center">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-12 object-contain">
        </div>
        
        <div class="flex-1 max-w-md mx-8 relative">
            <input type="text" placeholder="Mau Print Apa Hari Ini ?" class="w-full bg-gray-100 border border-gray-300 rounded-full pl-4 pr-10 py-1.5 text-xs focus:outline-none">
            <button class="absolute right-3 top-2 text-red-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </div>

        <div class="flex items-center gap-4">
            <button class="text-gray-700 relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </button>
            <button class="text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </button>
            <a href="{{ route('login') }}" class="border border-red-500 text-red-500 font-semibold px-5 py-1.5 rounded-full text-xs hover:bg-red-50 transition">Log In</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 text-white font-semibold px-5 py-1.5 rounded-full text-xs hover:bg-red-700 transition">Log Out</button>
            </form>
        </div>
    </header>

    <nav class="bg-red-600 text-white text-sm font-semibold sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-1">
                <button class="bg-red-800 px-6 py-3 flex items-center gap-2 text-xs uppercase tracking-wider font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    Pilih Kategori
                </button>
                <div class="flex items-center text-xs space-x-6 pl-6">
                    <a href="{{ route('customer.dashboard') }}" class="hover:text-gray-200 transition">Beranda</a>
                    <a href="#" class="hover:text-gray-200 transition">Semua Produk</a>
                    <a href="#" class="hover:text-gray-200 transition">Promo</a>
                    <a href="{{ route('customer.jam-layanan') }}" class="text-gray-200 underline decoration-2 underline-offset-4 font-bold">Jam Layanan</a>
                    <a href="#" class="hover:text-gray-200 transition">Tentang Kami</a>
                </div>
            </div>
            <div class="text-xs flex items-center gap-2">
                <span>📞 Pusat Bantuan :</span>
                <a href="#" class="bg-white text-red-600 font-bold px-4 py-1 rounded-full text-[11px] border border-white hover:bg-red-50 transition">Customer Service</a>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl w-full mx-auto px-4 py-8 space-y-6">
        
        <div class="bg-red-600 rounded-2xl text-white py-10 flex flex-col justify-center items-center shadow-sm">
            <div class="flex items-center gap-3">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h1 class="text-3xl font-bold tracking-wide">Jam Layanan</h1>
            </div>
            <p class="text-sm font-medium mt-1 text-red-100">Siap Melayani Anda</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-3xl p-10 max-w-4xl mx-auto shadow-sm flex flex-col md:flex-row items-center gap-10">
            <div class="flex-shrink-0">
                <div class="bg-red-600 text-white p-6 rounded-full shadow-md">
                    <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m9-7a3 3 0 01-3 3H9a3 3 0 01-3-3V7a3 3 0 013-3h5a3 3 0 013 3v5z"></path>
                    </svg>
                </div>
            </div>

            <div class="flex-1 w-full space-y-5">
                <h2 class="text-2xl font-bold text-gray-800 tracking-wide">Fantastic Digital Printing</h2>
                
                <div class="border-b border-gray-200 pb-3 flex justify-between items-center">
                    <span class="text-gray-700 font-semibold text-lg">Senin - Sabtu</span>
                    <span class="text-red-600 font-bold text-xl tracking-wide">09.00 - 21.00</span>
                </div>

                <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
                    <span class="text-gray-700 font-semibold text-lg">Minggu</span>
                    <span class="text-red-500 font-bold text-xl tracking-wide">Tutup</span>
                </div>

                <div class="space-y-2 text-xs font-medium text-gray-600 pt-2">
                    <div class="flex items-start gap-2.5">
                        <span class="text-red-600 mt-0.5">📍</span>
                        <p class="leading-relaxed">Jl. Raya Timur Wanadadi, Dusun Dua, Wanadadi, Kec. Wanadadi, Kab. Banjarnegara, Jawa Tengah</p>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="text-red-600">📞</span>
                        <p>+62 851-1962-2615</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-red-700 text-white mt-12 pt-10 pb-4 text-xs">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-5 gap-8 border-b border-red-600 pb-8 mb-4">
            <div class="md:col-span-1 space-y-3">
                <div class="bg-white inline-block px-3 py-1.5 rounded-xl shadow-sm">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-8 object-contain">
                </div>
                <p class="text-red-100 text-[11px] leading-relaxed font-medium">FantasticDigitalPrinting adalah layanan digital printing online terpercaya yang melayani berbagai kebutuhan cetak Anda dengan kualitas terbaik dan harga terjangkau.</p>
            </div>
            <div>
                <h4 class="font-bold text-sm uppercase mb-3 tracking-wider">Kategori Produk</h4>
                <ul class="space-y-1.5 text-red-200 font-medium text-[11px]">
                    <li>Print On Paper</li><li>Print Stiker</li><li>Kalender</li><li>Banner & Spanduk</li><li>Sablon</li><li>Souvenir</li><li>Undangan</li><li>Papan Informasi</li><li>Tanda Pengenal</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-sm uppercase mb-3 tracking-wider">Tentang Kami</h4>
                <ul class="space-y-2 text-red-200 font-medium text-[11px]">
                    <li><a href="#" class="hover:underline">Profil Perusahaan</a></li>
                </ul>
                <h4 class="font-bold text-sm uppercase mt-4 mb-2 tracking-wider">Ikuti Kami</h4>
                <a href="#" class="text-lg bg-white/10 px-2.5 py-1.5 rounded-full hover:bg-white/20 transition">📸</a>
            </div>
            <div>
                <h4 class="font-bold text-sm uppercase mb-3 tracking-wider">Jam Layanan</h4>
                <div class="space-y-2 text-red-200 text-[11px] font-medium">
                    <p>🕒 <span class="font-semibold">Senin - Sabtu</span><br><span class="pl-5">09.00 - 21.00</span></p>
                    <p>🕒 <span class="font-semibold">Minggu</span><br><span class="pl-5">Tutup</span></p>
                </div>
            </div>
            <div class="space-y-2 text-[11px] text-red-200 font-medium">
                <h4 class="font-bold text-sm uppercase mb-3 text-white tracking-wider">Hubungi Kami</h4>
                <p>📍 Jl. Raya Timur Wanadadi, Dusun Dua, Wanadadi, Kec. Wanadadi, Kab. Banjarnegara, Jawa Tengah</p>
                <p>📞 +62 812-2978-3247</p>
                <p>📞 +62 851-1962-2615</p>
                <p>✉️ fantasticwnd@gmail.com</p>
            </div>
        </div>
        <div class="text-center text-red-300 text-[11px] font-medium">
            &copy; 2026 Fantastic Digital Printing. Kelompok MPTI - All Rights Reserved.
        </div>
    </footer>

</body>
</html>