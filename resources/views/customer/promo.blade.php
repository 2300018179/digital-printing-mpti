<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo - Fantastic Digital Printing</title>

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
                        <a href="/keranjang" class="text-black no-underline transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1]" title="Keranjang"><i class="fa fa-shopping-cart"></i></a>
                        <a href="/notifikasi" class="text-black no-underline transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1]" title="Notifikasi"><i class="fa fa-bell"></i></a>
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
                <div class="bg-brandRed text-white h-full w-[280px] flex items-center font-bold text-sm rounded-[15px_15px_0_0] gap-15 cursor-default pointer-events-none user-select-none shadow-[6px_0_10px_rgba(0,0,0,0.15)] relative z-10 pl-5">
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
        <div class="max-w-[1350px] mx-auto px-[15px] w-full flex flex-col md:flex-row gap-5 items-start mb-12">
            <aside class="hidden md:flex w-[280px] shrink-0 bg-white rounded-[0_0_20px_20px] shadow-[6px_10px_20px_rgba(0,0,0,0.05)] flex-col">
                <ul class="list-none m-0 p-0">
                    <li class="flex justify-between items-center p-[6.3px_20px] border-b border-[#f0f0f0] cursor-pointer hover:bg-[#fff5f5]">
                        <div class="flex items-center gap-[15px]">
                            <i class="fas fa-file-alt text-brandRed text-[18px] w-5 text-center"></i> 
                            <span class="text-[13px] font-medium text-brandTextDark">Print On Paper</span>
                        </div>
                        <i class="fa fa-chevron-right text-[12px] text-[#999]"></i>
                    </li>
                    <li class="flex justify-between items-center p-[6.3px_20px] border-b border-[#f0f0f0] cursor-pointer hover:bg-[#fff5f5]">
                        <div class="flex items-center gap-[15px]">
                            <i class="fas fa-sticky-note text-brandRed text-[18px] w-5 text-center"></i> 
                            <span class="text-[13px] font-medium text-brandTextDark">Print Stiker</span>
                        </div>
                        <i class="fa fa-chevron-right text-[12px] text-[#999]"></i>
                    </li>
                    <li class="flex justify-between items-center p-[6.3px_20px] border-b border-[#f0f0f0] cursor-pointer hover:bg-[#fff5f5]">
                        <div class="flex items-center gap-[15px]">
                            <i class="far fa-calendar-alt text-brandRed text-[18px] w-5 text-center"></i> 
                            <span class="text-[13px] font-medium text-brandTextDark">Kalender</span>
                        </div>
                        <i class="fa fa-chevron-right text-[12px] text-[#999]"></i>
                    </li>
                    <li class="flex justify-between items-center p-[6.3px_20px] border-b border-[#f0f0f0] cursor-pointer hover:bg-[#fff5f5]">
                        <div class="flex items-center gap-[15px]">
                            <i class="fas fa-scroll text-brandRed text-[18px] w-5 text-center"></i> 
                            <span class="text-[13px] font-medium text-brandTextDark">Banner & Spanduk</span>
                        </div>
                        <i class="fa fa-chevron-right text-[12px] text-[#999]"></i>
                    </li>
                    <li class="flex justify-between items-center p-[6.3px_20px] border-b border-[#f0f0f0] cursor-pointer hover:bg-[#fff5f5]">
                        <div class="flex items-center gap-[15px]">
                            <i class="fas fa-tshirt text-brandRed text-[18px] w-5 text-center"></i> 
                            <span class="text-[13px] font-medium text-brandTextDark">Sablon</span>
                        </div>
                        <i class="fa fa-chevron-right text-[12px] text-[#999]"></i>
                    </li>
                    <li class="flex justify-between items-center p-[6.3px_20px] border-b border-[#f0f0f0] cursor-pointer hover:bg-[#fff5f5]">
                        <div class="flex items-center gap-[15px]">
                            <i class="fas fa-gift text-brandRed text-[18px] w-5 text-center"></i> 
                            <span class="text-[13px] font-medium text-brandTextDark">Sovenir</span>
                        </div>
                        <i class="fa fa-chevron-right text-[12px] text-[#999]"></i>
                    </li>
                    <li class="flex justify-between items-center p-[6.3px_20px] border-b border-[#f0f0f0] cursor-pointer hover:bg-[#fff5f5]">
                        <div class="flex items-center gap-[15px]">
                            <i class="fas fa-envelope-open-text text-brandRed text-[18px] w-5 text-center"></i>
                            <span class="text-[13px] font-medium text-brandTextDark">Undangan</span>
                        </div>
                        <i class="fa fa-chevron-right text-[12px] text-[#999]"></i>
                    </li>
                    <li class="flex justify-between items-center p-[6.3px_20px] border-b border-[#f0f0f0] cursor-pointer hover:bg-[#fff5f5]">
                        <div class="flex items-center gap-[15px]">
                            <i class="fas fa-info-circle text-brandRed text-[18px] w-5 text-center"></i> 
                            <span class="text-[13px] font-medium text-brandTextDark">Papan Informasi</span>
                        </div>
                        <i class="fa fa-chevron-right text-[12px] text-[#999]"></i>
                    </li>
                    <li class="flex justify-between items-center p-[6.3px_20px] border-none cursor-pointer hover:bg-[#fff5f5]">
                        <div class="flex items-center gap-[15px]">
                            <i class="fas fa-id-card text-brandRed text-[18px] w-5 text-center"></i> 
                            <span class="text-[13px] font-medium text-brandTextDark">Tanda Pengenal</span>
                        </div>
                        <i class="fa fa-chevron-right text-[12px] text-[#999]"></i>
                    </li>
                </ul>
            </aside>

            <section class="flex-1 w-full flex flex-col pl-0 md:pl-8 pt-4">
                
                <h1 class="text-xl font-semibold text-gray-800 mb-6 tracking-wide">
                    Belum ada produk promo yang tersedia.
                </h1>

                <div class="w-full border border-gray-200 rounded-[30px] p-16 flex flex-col items-center justify-center text-center bg-white shadow-[0_4px_25px_rgba(0,0,0,0.02)] min-h-[420px]">
                    
                    <div class="text-gray-300 text-8xl mb-6">
                        <i class="fas fa-box-open"></i>
                    </div>

                    <p class="text-gray-400 font-medium text-sm tracking-wide mb-8">
                        Belum ada produk promo yang ditampilkan.
                    </p>

                    <a href="{{ route('customer.semua-produk') }}">
                        <button class="p-[10px_35px] bg-brandRed text-white border border-brandRed rounded-[20px] font-bold text-xs tracking-wider transition-all duration-300 hover:scale-[1.03] hover:shadow-[0_4px_15px_rgba(196,0,0,0.3)]">
                            Lihat Semua Produk
                        </button>
                    </a>
                </div>

            </section>

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