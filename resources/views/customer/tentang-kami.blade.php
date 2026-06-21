<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantastic Digital Printing</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inclusive+Sans:ital@0;1&family=Inder&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandRed: '#c40000',
                        brandBgGray: '#f0f0f0',
                        brandTextDark: '#444444'
                    },
                    fontFamily: {
                        sans: ['Inclusive Sans', 'sans-serif'],
                        inder: ['Inder', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans m-0 p-0 box-border text-gray-800 bg-white">

    <div class="fixed top-0 left-0 w-full z-[9999] shadow-[0_4px_10px_rgba(0,0,0,0.1)]">
        <header class="bg-white py-[10px]">
            <div class="max-w-[1350px] mx-auto px-[15px] w-full flex items-center gap-5">
                <div class="flex-shrink-0">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo Fantastic" class="h-[55px] w-auto">
                </div>
                <div class="hidden md:flex flex-[0_1_320px] bg-brandBgGray rounded-[25px] p-[0_5px] border border-[#ddd] ml-5 items-center">
                    <input type="text" placeholder="Mau Print Apa Hari ini?" class="flex-1 border-none bg-transparent p-[8px_15px] outline-none">
                    <button aria-label="Cari" class="bg-brandRed text-white w-[35px] h-[35px] rounded-full flex items-center justify-center cursor-pointer">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <div class="ml-auto flex items-center gap-5">
                    <div class="flex gap-5 text-xl">
                        @auth
                            <div class="relative inline-block">
                                <button onclick="toggleCartPopup()" class="text-black bg-transparent border-none p-0 transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1] relative" title="Keranjang">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="absolute -top-1.5 -right-2 bg-brandRed text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">0</span>
                                </button>

                                <div id="cartDropdown" class="hidden absolute right-0 mt-3 w-[320px] bg-white rounded-[15px] shadow-[0_10px_25px_rgba(0,0,0,0.15)] border border-gray-100 z-[99999] flex flex-col overflow-hidden origin-top-right">
                                    <div class="flex justify-between items-center p-4 border-b border-gray-100">
                                        <span class="font-bold text-gray-800 text-sm">Keranjang</span>
                                        <a href="#" class="text-brandRed text-xs font-semibold hover:underline">Lihat Semua</a>
                                    </div>

                                    <div class="flex flex-col items-center justify-center py-8 px-4">
                                        <p class="text-gray-400 text-xs mb-3 font-medium">Keranjang Masih kosong</p>
                                        <button class="bg-brandRed text-white text-xs font-bold p-[6px_20px] rounded-full hover:bg-red-700 transition">
                                            Mulai Belanja
                                        </button>
                                    </div>

                                    <div class="bg-gray-50 p-4 flex gap-2 border-t border-gray-100">
                                        <button class="flex-1 p-[8px_10px] border border-brandRed text-brandRed rounded-full text-xs font-bold hover:bg-red-50 transition">
                                            Lanjut Order
                                        </button>
                                        <button class="flex-1 p-[8px_10px] bg-brandRed text-white rounded-full text-xs font-bold hover:bg-red-700 transition">
                                            Checkout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        @guest
                            <button onclick="openLoginModal()" class="text-black bg-transparent border-none p-0 transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1]" title="Keranjang">
                                <i class="fa fa-shopping-cart"></i>
                            </button>
                        @endguest
                        <div class="relative inline-block mx-2">
                            <button onclick="toggleNotificationPopup()" class="text-black bg-transparent border-none p-0 transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1] relative" title="Notifikasi">
                                <i class="fa fa-bell text-xl"></i>
                                <span class="absolute top-0 right-0 bg-brandRed w-2 h-2 rounded-full"></span>
                            </button>

                            <div id="notificationDropdown" class="hidden absolute right-0 mt-3 w-[340px] bg-white rounded-[15px] shadow-[0_10px_25px_rgba(0,0,0,0.15)] border border-gray-100 z-[99999] flex flex-col overflow-hidden origin-top-right">
                                <div class="flex justify-between items-center p-4 border-b border-gray-100">
                                    <span class="font-bold text-gray-800 text-sm">Notifikasi</span>
                                    <a href="#" class="text-brandRed text-xs font-semibold hover:underline">Lihat Semua</a>
                                </div>

                                <div class="flex justify-around items-center py-6 px-2 bg-white">
                                    <a href="#" class="flex flex-col items-center gap-2 group decoration-none">
                                        <div class="w-12 h-12 rounded-full bg-brandRed flex items-center justify-center transition group-hover:scale-105 shadow-sm">
                                            <i class="fa fa-shopping-bag text-white text-lg"></i> 
                                        </div>
                                        <span class="text-[11px] font-medium text-gray-700 text-center">Pesanan</span>
                                    </a>

                                    <a href="#" class="flex flex-col items-center gap-2 group decoration-none">
                                        <div class="w-12 h-12 rounded-full bg-brandRed flex items-center justify-center transition group-hover:scale-105 shadow-sm">
                                            <i class="fa fa-info-circle text-white text-lg"></i>
                                        </div>
                                        <span class="text-[11px] font-medium text-gray-700 text-center">Informasi Terbaru</span>
                                    </a>

                                    <a href="#" class="flex flex-col items-center gap-2 group decoration-none">
                                        <div class="w-12 h-12 rounded-full bg-brandRed flex items-center justify-center transition group-hover:scale-105 shadow-sm">
                                            <i class="fa fa-tags text-white text-lg"></i>
                                        </div>
                                        <span class="text-[11px] font-medium text-gray-700 text-center">Promo</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:flex items-center gap-5">
                        @auth
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-brandBgGray rounded-full border border-gray-300 flex items-center justify-center text-gray-600 shadow-sm" title="{{ Auth::user()->name }}">
                                    <i class="fa-solid fa-user text-lg"></i>
                                </div>
                                
                                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="p-[8px_20px] bg-[#c40000] text-white border border-[#c40000] rounded-[20px] cursor-pointer font-semibold transition-all duration-300 ease-in-out hover:bg-white hover:text-[#c40000] hover:border-[#c40000] hover:shadow-[0_4px_12px_rgba(0,0,0,0.15)] hover:-translate-y-0.5 active:translate-y-0">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}">
                                <button class="p-[8px_20px] bg-[#c40000] text-white border border-[#c40000] rounded-[20px] cursor-pointer font-semibold transition-all duration-300 ease-in-out hover:bg-white hover:text-[#c40000] hover:border-[#c40000] hover:shadow-[0_4px_12px_rgba(0,0,0,0.15)] hover:-translate-y-0.5 active:translate-y-0">
                                    Log In
                                </button>
                            </a>
                            <a href="{{ route('register') }}">
                                <button class="p-[8px_20px] bg-[#c40000] text-white border border-[#c40000] rounded-[20px] cursor-pointer font-semibold transition-all duration-300 ease-in-out hover:bg-white hover:text-[#c40000] hover:border-[#c40000] hover:shadow-[0_4px_12px_rgba(0,0,0,0.15)] hover:-translate-y-0.5 active:translate-y-0">
                                    Registration
                                </button>
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </header>

        <nav class="bg-brandRed h-[50px]">
            <div class="max-w-[1350px] mx-auto px-[15px] w-full flex h-full items-center">
                <div class="bg-brandRed text-white h-full w-[280px] flex items-center font-bold text-sm rounded-[15px_15px_0_0] gap-15 cursor-default pointer-events-none user-select-none] relative z-10 pl-5">
                    <i class="fa fa-bars mr-3"></i> Pilih Kategori
                </div>
                <ul class="hidden md:flex list-none gap-[50px] ml-30 flex-1 pl-8">
                    <li><a href="/" class="text-white no-underline text-sm cursor-pointer inline-block">Beranda</a></li>
                    <li><a href="{{ route('customer.semua-produk') }}" class="text-white no-underline text-sm cursor-pointer inline-block">Semua Produk</a></li>
                    <li><a href="{{ route('customer.promo') }}" class="text-white no-underline text-sm cursor-pointer inline-block">Promo</a></li>
                    <li><a href="{{ route('customer.jam-layanan') }}" class="text-white no-underline text-sm cursor-pointer inline-block">Jam Layanan</a></li>
                    <li><a href="{{ route('customer.tentang-kami') }}" class="text-white no-underline text-sm cursor-pointer inline-block">Tentang Kami</a></li>
                </ul>
                <div class="hidden md:flex items-center gap-[10px] text-white ml-auto">
                    <img src="{{ asset('assets/icons/wa-icon.png') }}" alt="WA" class="w-5 h-5">
                    <span class="text-xs">Pusat Bantuan :</span>
                    <button class="p-[6px_15px] bg-brandRed text-white border border-white rounded-[20px] text-xs font-bold cursor-pointer transition-all duration-300 ease-in-out ml-5 hover:bg-white hover:text-brandRed hover:border-brandRed hover:shadow-[0_4px_12px_rgba(0,0,0,0.15)] hover:-translate-y-0.5 active:translate-y-0">Customer Service</button>
                </div>
            </div>
        </nav>
    </div> 

    <main class="pt-[140px]">
        <div class="max-w-[1350px] mx-auto px-[15px] w-full flex flex-col items-center mb-16 mt-4">
            
            <div class="w-full bg-brandRed text-white rounded-[20px] p-6 flex items-center justify-center gap-4 shadow-[0_4px_15px_rgba(196,0,0,0.15)] mb-8">
                <div>
                    <h1 class="text-2xl font-bold tracking-wide leading-tight">Tentang Kami</h1>
                </div>
            </div>

            <div class="w-full max-w-[850px] bg-white border border-gray-200 rounded-[30px] p-10 md:p-14 shadow-[0_4px_25px_rgba(0,0,0,0.03)] flex flex-col items-center">
                
                <div class="flex items-center gap-4 mb-10 w-full justify-center border-b border-gray-100 pb-6">
                    <div class="w-14 h-14 bg-brandRed rounded-full flex items-center justify-center text-white text-2xl shadow-sm">
                        <i class="fas fa-store"></i>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-wide text-center">
                        Fantastic Digital Printing
                    </h2>
                </div>

                <div class="w-full max-w-[750px] text-center">
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed font-inder">
                        Fantastic Digital Printing adalah penyedia layanan percetakan digital terdepan yang berkomitmen memberikan solusi cetak berkualitas tinggi, cepat, dan terjangkau untuk segala kebutuhan bisnis maupun personal Anda. Berlokasi strategis di Wanadadi, kami menggunakan teknologi mesin cetak mutakhir demi memastikan ketajaman warna dan daya tahan hasil cetak terbaik di setiap lembar karya Anda.
                    </p>
                </div>

            </div>

        </div>

        <footer class="bg-[#c40000] text-white py-[25px] mt-[50px] text-[13px] [line-height:1.6] font-sans">
            <div class="max-w-[1350px] mx-auto px-[20px] grid grid-cols-1 md:grid-cols-5 gap-[30px] items-start">
                
                <div class="w-full">
                    <img src="{{ asset('assets/logo.png') }}" alt="Fantastic Digital Printing" class="w-[180px] mb-[20px] p-[5px] rounded-[5px]">
                    <p class="text-white/90">Fantastic Digital Printing adalah layanan digital printing online terpercaya yang melayani berbagai kebutuhan cetak Anda dengan kualitas terbaik dan harga terjangkau.</p>
                </div>

                <div class="w-full">
                    <h3 class="text-[16px] mb-[20px] font-bold text-left">Kategori</h3>
                    <div class="flex gap-[20px] text-left">
                        <ul class="list-none p-0 flex-1">
                            <li class="mb-[8px]"><a href="#" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px]">Print On Paper</a></li>
                            <li class="mb-[8px]"><a href="#" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px]">Print Stiker</a></li>
                            <li class="mb-[8px]"><a href="#" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px]">Kalender</a></li>
                            <li class="mb-[8px]"><a href="#" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px]">Banner & Spanduk</a></li>
                            <li class="mb-[8px]"><a href="#" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px]">Sablon</a></li>
                        </ul>
                        <ul class="list-none p-0 flex-1">
                            <li class="mb-[8px]"><a href="#" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px] inline-block">Sovenir</a></li>
                            <li class="mb-[8px]"><a href="#" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px] inline-block">Undangan</a></li>
                            <li class="mb-[8px]"><a href="#" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px] inline-block">Papan Informasi</a></li>
                            <li class="mb-[8px]"><a href="#" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px] inline-block">Tanda Pengenal</a></li>
                        </ul>
                    </div>
                </div>

                <div class="w-full">
                    <h3 class="text-[16px] mb-[20px] font-bold text-left">Tentang Kami</h3>
                    <ul class="list-none p-0 mb-[20px]">
                        <li class="mb-[8px]"><a href="#" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px]">Profil Perusahaan</a></li>
                    </ul>
                    <h3 class="text-[16px] mb-[20px] font-bold text-left">Ikuti Kami</h3>
                    <div class="mt-[10px]">
                        <a href="https://www.instagram.com/akun_kamu" target="_blank" aria-label="Ikuti kami di Instagram" class="inline-block transition-all duration-300 hover:scale-[1.1]">
                            <img src="{{ asset('assets/icons/instagram_.png') }}" alt="Instagram" class="w-[30px] h-[30px] align-middle">
                        </a>
                    </div>
                </div>

                <div class="w-full">
                    <h3 class="text-[16px] mb-[20px] font-bold text-left">Jam Layanan</h3>
                    <div class="flex gap-[12px] mb-[15px] items-start">
                        <i class="far fa-clock text-[16px] mt-[3px]"></i>
                        <span>Senin - Sabtu<br>09.00 - 21.00</span>
                    </div>
                    <div class="flex gap-[12px] mb-[15px] items-start">
                        <i class="far fa-clock text-[16px] mt-[3px]"></i>
                        <span>Minggu<br>Tutup</span>
                    </div>
                </div>

                <div class="w-full">
                    <h3 class="text-[16px] mb-[20px] font-bold text-left">Hubungi Kami</h3>
                    <div class="flex gap-[12px] mb-[15px] items-start">
                        <i class="fas fa-map-marker-alt text-[16px] mt-[3px]"></i>
                        <span class="text-white/90">Fantastic Digital Printing<br>Jl. Raya Timur Wanadadi, Dusun Dua, Wanadadi, Kec. Wanadadi, Kab. Banjarnegara, Jawa Tengah</span>
                    </div>
                    <div class="flex gap-[12px] mb-[15px] items-start">
                        <img src="{{ asset('assets/icons/wa-icon.png') }}" alt="WA" class="w-[16px] h-[16px] align-middle mt-[3px]"> 
                        <div>
                            <span>+62 881-3962-2615</span><br>
                            <span>+62 812-2973-5247</span>
                        </div>
                    </div>
                    <div class="flex gap-[12px] mb-[15px] items-start">
                        <i class="far fa-envelope text-[16px] mt-[3px]"></i>
                        <span>fantasticwnd@gmail.com</span>
                    </div>
                </div>

            </div>
        </footer>
    </main>
</body>
</html>