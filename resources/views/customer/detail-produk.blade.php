<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Fantastic Digital Printing</title>

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

    <!-- HEADER & NAVBAR FIXED -->
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
                
                <!-- POPUP NOTIFIKASI SUKSES (Sesuai gambar image_7982e0.png) -->
                <div class="absolute top-[65px] right-[10%] bg-white border border-gray-200 text-gray-800 font-medium p-[12px_30px] rounded-[12px] shadow-[0_6px_20px_rgba(0,0,0,0.15)] z-[10000] flex items-center justify-center min-w-[220px]">
                    <span class="text-sm tracking-wide">Pemesanan Berhasil</span>
                </div>

                <div class="ml-auto flex items-center gap-5">
                    <div class="flex gap-5 text-xl">
                        <a href="/keranjang" class="text-black no-underline transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1]" title="Keranjang"><i class="fa fa-shopping-cart"></i></a>
                        <a href="/notifikasi" class="text-black no-underline transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1]" title="Notifikasi"><i class="fa fa-bell"></i></a>
                    </div>
                    <div class="hidden md:flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 bg-gray-100 text-lg">
                            <i class="fa fa-user"></i>
                        </div>
                        <button class="p-[8px_20px] bg-[#c40000] text-white border border-[#c40000] rounded-[20px] cursor-pointer font-semibold transition-all duration-300 ease-in-out hover:bg-white hover:text-[#c40000]">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <nav class="bg-brandRed h-[50px]">
            <div class="max-w-[1350px] mx-auto px-[15px] w-full flex h-full items-center relative">
                
                <div class="bg-brandRed text-white h-full w-[280px] flex items-center font-bold text-sm rounded-tr-[25px] gap-15 cursor-default pointer-events-none user-select-none shadow-[6px_0_10px_rgba(0,0,0,0.15)] relative z-20 pl-5">
                    <i class="fa fa-bars mr-3"></i> Pilih Kategori
                </div>
                
                <div class="absolute top-[50px] left-[15px] w-[280px] bg-white border border-t-0 border-gray-200 shadow-[0_8px_15px_rgba(0,0,0,0.1)] rounded-bl-[20px] rounded-br-[20px] p-[8px_20px] text-xs z-10">
                    <div class="flex items-center text-gray-500 font-medium">
                        <span class="font-inder text-[11px] text-gray-400">Brosur Art Paper</span> 
                        <i class="fa fa-chevron-right text-[9px] mx-2 text-gray-400"></i> 
                        <span class="text-gray-800 font-bold font-inder">Brosur</span>
                    </div>
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

    <!-- MAIN CONTENT AREA -->
<main class="pt-[140px]">
    <div class="max-w-[1350px] mx-auto px-[15px] w-full pt-12">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start mb-8">
            <div class="w-full aspect-[4/3] max-w-[500px] border border-brandRed rounded-[25px] p-6 flex items-center justify-center bg-white shadow-[0_4px_12px_rgba(0,0,0,0.02)] mx-auto lg:ml-0">
                <img src="{{ asset('assets/products/brosur.png') }}" alt="Brosur" class="max-w-full max-h-full object-contain">
            </div>

                <!-- Info Produk -->
                <div class="flex flex-col items-start pt-2">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4 font-inder">Brosur</h1>
                    
                    <!-- Tag Harga -->
                    <div class="bg-brandRed text-white font-semibold text-sm p-[8px_25px] rounded-[20px] mb-5 shadow-sm">
                        Rp. 10.000
                    </div>

                    <!-- Spesifikasi -->
                    <h3 class="text-sm font-bold text-gray-700 mb-2">Spesifikasi Produk</h3>
                    <ol class="list-decimal pl-5 text-sm text-gray-600 space-y-1 font-medium">
                        <li>ahddghddj</li>
                        <li>ahajdbjdjsje</li>
                        <li>agdgjbjmabja</li>
                        <li>ajjnsbhsekjaka</li>
                        <li>ahghjlsk</li>
                    </ol>
                </div>
            </div>

            <!-- Bagian Bawah: Form Order dan Upload Desain -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch mb-16">
                
                <!-- KIRI: Form Order -->
                <div class="bg-white border border-gray-200 rounded-[20px] p-6 shadow-[0_4px_15px_rgba(0,0,0,0.05)] flex flex-col justify-between">
                    <div>
                        <h2 class="text-center font-bold text-gray-700 border-b border-gray-100 pb-3 mb-5 text-sm tracking-wide">Form Order</h2>
                        <form class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Bahan</label>
                                <input type="text" class="w-full border border-gray-300 rounded-[10px] p-[8px_12px] text-sm outline-none focus:border-brandRed">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jumlah</label>
                                    <input type="text" class="w-full border border-gray-300 rounded-[10px] p-[8px_12px] text-sm outline-none focus:border-brandRed">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Harga Satuan</label>
                                    <input type="text" class="w-full border border-gray-300 rounded-[10px] p-[8px_12px] text-sm outline-none focus:border-brandRed">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan</label>
                                <textarea rows="4" class="w-full border border-gray-300 rounded-[10px] p-[8px_12px] text-sm outline-none focus:border-brandRed resize-none"></textarea>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- KANAN: Upload Desain -->
                <div class="bg-white border border-gray-200 rounded-[20px] p-6 shadow-[0_4px_15px_rgba(0,0,0,0.05)] flex flex-col justify-between">
                    <div>
                        <h2 class="text-center font-bold text-gray-700 border-b border-gray-100 pb-3 mb-5 text-sm tracking-wide">Upload Desain</h2>
                        
                        <!-- Tab Pilihan -->
                        <div class="grid grid-cols-2 gap-2 bg-gray-100 rounded-[10px] p-1 mb-5">
                            <button class="bg-gray-300 text-gray-700 font-semibold text-xs py-2 rounded-[8px] shadow-sm">Upload File</button>
                            <button class="text-gray-500 font-semibold text-xs py-2 rounded-[8px] hover:text-gray-700">Link Desain</button>
                        </div>

                        <!-- Dropzone Box -->
                        <div class="border border-gray-300 rounded-[15px] p-8 flex flex-col items-center justify-center text-center space-y-3 bg-white">
                            <p class="text-xs font-medium text-gray-500 max-w-[240px] leading-relaxed">
                                Drag & Drop file desain Anda di sini atau klik untuk memilih file
                            </p>
                            <button class="bg-brandRed text-white text-[11px] font-semibold p-[5px_20px] rounded-[15px] shadow-sm">
                                Pilih file
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Kirim / Submit Terbawah -->
                    <div class="mt-8 text-center">
                        <button type="submit" class="w-full max-w-[200px] p-[10px_35px] bg-brandRed text-white border border-brandRed rounded-[25px] font-bold text-sm tracking-wide transition-all duration-300 ease-in-out hover:bg-white hover:text-brandRed hover:shadow-[0_4px_12px_rgba(0,0,0,0.15)]">
                            Kirim
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- FOOTER -->
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