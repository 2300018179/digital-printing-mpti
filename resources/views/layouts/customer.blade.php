<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['nama_toko'] ?? '' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inclusive+Sans:ital@0;1&family=Inder&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}" sizes="32x32">
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
                        fontFamily: {
                            sans: ['Inder', 'sans-serif'], 
                            // Tambahkan tanda kutip ganda didalam kutip tunggal ('"Inclusive Sans"')
                            harga: ['"Inclusive Sans"', 'sans-serif'] 
                        }
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="font-sans m-0 p-0 box-border text-gray-800 bg-white">

    <div class="fixed top-0 left-0 w-full z-[9999] shadow-[0_4px_10px_rgba(0,0,0,0.1)]">
        <header class="bg-white py-[10px]">
            <div class="max-w-[1350px] mx-auto px-[15px] w-full flex items-center gap-5">
                <div class="flex-shrink-0">
                    <a href="{{ route('customer.dashboard') }}">
                        <img src="{{ asset('storage/' . $appSettings['logo_toko']) }}" 
                            alt="{{ $appSettings['nama_toko'] ?? '' }}" 
                            class="h-[48px] w-auto object-contain"> {{-- Pas untuk navbar --}}
                    </a>
                </div>
                <form action="{{ route('customer.semua-produk') }}" method="GET" onsubmit="return this.search.value.trim() !== ''" class="hidden md:flex flex-[0_1_320px] bg-brandBgGray rounded-[25px] p-[0_5px] border border-[#ddd] ml-5 items-center">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Mau Print Apa Hari ini?" 
                        class="flex-1 border-none bg-transparent p-[8px_15px] outline-none rounded-[25px] [&:-webkit-autofill]:[text-fill-color:#444444] [&:-webkit-autofill]:[transition:background-color_5000s_ease-in-out_0s]"
                    >
                    <button type="submit" aria-label="Cari" class="bg-brandRed text-white w-[35px] h-[35px] rounded-full flex items-center justify-center cursor-pointer border-none">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
                
                <div class="ml-auto flex items-center gap-5">
                    <div class="flex gap-5 text-xl items-center">
                        @auth
                            <div class="relative inline-block" id="cartMenuWrapper">
                                <button onclick="toggleCartPopup()" class="text-black bg-transparent border-none p-0 transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1] relative">
                                    <i class="fa fa-shopping-cart text-xl"></i>
                                    <span class="absolute -top-1.5 -right-2 bg-brandRed text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                                        {{ $cartCount ?? 0 }}
                                    </span>
                                </button>

                                <div id="cartDropdown" class="hidden absolute right-0 mt-3 w-[360px] bg-white rounded-[15px] shadow-[0_10px_25px_rgba(0,0,0,0.15)] border border-gray-100 z-[99999] flex flex-col overflow-hidden origin-top-right">
                                    <div class="flex justify-between items-center p-4 border-b border-gray-100">
                                        <span class="font-bold text-gray-800 text-sm">Keranjang ({{ $cartCount ?? 0 }})</span>
                                    </div>

                                    {{-- PERBAIKAN: Tampilan Tombol Interaksi Saat Keranjang Kosong --}}
                                    @if(empty($cartItemsData) || $cartItemsData->isEmpty())
                                        <div class="flex flex-col items-center justify-center py-10 px-4 text-center">
                                            <div class="w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3">
                                                <i class="fa fa-shopping-basket text-lg"></i>
                                            </div>
                                            <p class="text-gray-400 text-xs mb-4 font-medium">Keranjang belanja Anda masih kosong</p>
                                            <a href="{{ route('customer.semua-produk') }}" class="px-5 py-2 bg-brandRed text-white text-[11px] font-bold rounded-full hover:bg-red-700 transition no-underline shadow-sm">
                                                Mulai Order Produk
                                            </a>
                                        </div>
                                    @else
                                        <form action="{{ route('customer.pembayaran') }}" method="POST" id="formCheckoutPopUp">
                                            @csrf
                                            
                                            <div class="flex flex-col max-h-[340px] overflow-y-auto p-3 gap-3 divide-y divide-gray-100">
                                                @foreach($cartItemsData as $item)
                                                    <div class="flex items-start gap-3 pt-3 first:pt-0 justify-between group">
                                                        
                                                        <div class="flex items-center mt-1.5 shrink-0">
                                                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" 
                                                                data-price="{{ $item->product->price ?? 0 }}" data-qty="{{ $item->quantity }}"
                                                                onchange="hitungTotalPopup()"
                                                                class="cart-checkbox w-4 h-4 text-brandRed border-gray-300 rounded focus:ring-brandRed cursor-pointer">
                                                        </div>

                                                        <div class="w-14 h-14 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden border border-gray-100 mt-1">
                                                            @if($item->product && $item->product->image)
                                                                <img src="{{ asset('assets/products/' . $item->product->image) }}" alt="" class="w-full h-full object-cover">
                                                            @else
                                                                <i class="fa fa-image text-gray-300 text-xs"></i>
                                                            @endif
                                                        </div>

                                                        <div class="flex-1 text-left min-w-0 px-1">
                                                            <h4 class="text-xs font-bold text-gray-800 line-clamp-1 mb-0.5">{{ $item->product->name }}</h4>
                                                            <p class="text-[11px] text-gray-500 font-semibold">{{ $item->quantity }} x Rp {{ number_format($item->product->price ?? 0, 0, ',', '.') }}</p>
                                                            
                                                            {{-- MENAMPILKAN CATATAN TAMBAHAN (NOTES) --}}
                                                            @if(!empty($item->notes))
                                                                <div class="mt-1 bg-gray-50 border border-gray-100 rounded-md p-1.5 text-[10px] text-gray-600 leading-relaxed break-words">
                                                                    <span class="font-bold text-gray-700">Note:</span> {{ $item->notes }}
                                                                </div>
                                                            @endif

                                                            {{-- MENAMPILKAN DESAIN (FILE / LINK) --}}
                                                            @if(!empty($item->desain))
                                                                <div class="mt-1 max-w-full">
                                                                    @if(filter_var($item->desain, FILTER_VALIDATE_URL) || str_contains($item->desain, 'http'))
                                                                        {{-- Jika berupa Tautan Drive / Eksternal Link --}}
                                                                        <a href="{{ $item->desain }}" target="_blank" class="inline-flex items-center gap-1 bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-medium px-2 py-0.5 rounded hover:underline max-w-full">
                                                                            <i class="fa-solid fa-link text-[9px] shrink-0"></i>
                                                                            <span class="truncate max-w-[150px]">{{ $item->desain }}</span>
                                                                        </a>
                                                                    @else
                                                                        {{-- Jika berupa Berkas Dokumen Terunggah --}}
                                                                        <div class="inline-flex items-center gap-1 bg-red-50 text-brandRed border border-red-100 text-[10px] font-medium px-2 py-0.5 rounded max-w-full" title="{{ basename($item->desain) }}">
                                                                            <i class="fa-solid fa-file-pdf text-[10px] shrink-0"></i>
                                                                            <span class="truncate max-w-[150px]">{{ basename($item->desain) }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                            <div class="mt-1.5">
                                                                <a href="{{ route('customer.detail-produk', $item->product->id) }}?edit_cart={{ $item->id }}" class="text-[10px] text-blue-500 hover:underline inline-flex items-center gap-1 font-semibold">
                                                                    <i class="fa-solid fa-pen text-[9px]"></i> Edit Detail
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <button type="button" onclick="event.preventDefault(); document.getElementById('popup-hapus-{{ $item->id }}').submit();" class="text-gray-300 hover:text-brandRed bg-transparent border-none cursor-pointer p-1 mt-1 shrink-0 transition-colors">
                                                            <i class="fa-regular fa-trash-can text-sm"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="bg-gray-50 p-4 border-t border-gray-100 flex flex-col gap-3">
                                                <div class="flex justify-between items-center px-1">
                                                    <span class="text-xs text-gray-500 font-medium">Total Terpilih:</span>
                                                    <span id="totalHargaPopup" class="text-sm font-bold text-brandRed">Rp 0</span>
                                                </div>
                                                
                                                <button type="submit" class="w-full py-2.5 bg-brandRed text-white rounded-full text-xs font-bold hover:bg-red-700 transition text-center shadow-sm">
                                                    Beli Sekarang
                                                </button>
                                            </div>
                                        </form>

                                        @foreach($cartItemsData as $item)
                                            <form id="popup-hapus-{{ $item->id }}" action="{{ route('customer.keranjang.hapus', $item->id) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="relative inline-block mx-2" id="notifMenuWrapper">
                                <button onclick="toggleNotificationPopup()" class="text-black bg-transparent border-none p-0 transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1] relative">
                                    <i class="fa fa-bell text-xl"></i>
                                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                        <span class="absolute top-0 right-0 bg-brandRed w-2 h-2 rounded-full animate-pulse"></span>
                                    @endif
                                </button>

                                <div id="notificationDropdown" class="hidden absolute right-0 mt-3 w-[340px] bg-white rounded-[15px] shadow-[0_10px_25px_rgba(0,0,0,0.15)] border border-gray-100 z-[99999] flex flex-col overflow-hidden origin-top-right">
                                    <div class="flex justify-between items-center p-4 border-b border-gray-100">
                                        <span class="font-bold text-gray-800 text-sm">Notifikasi</span>
                                        <a href="{{ route('customer.notifikasi') }}" class="text-brandRed text-xs font-semibold hover:underline">Lihat Semua</a>
                                    </div>

                                    <div class="flex justify-around items-center py-6 px-2 bg-white">
                                        <a href="{{ route('customer.pesanan') }}" class="flex flex-col items-center gap-2 group text-none flex-1">
                                            <div class="w-12 h-12 rounded-full bg-brandRed flex items-center justify-center transition group-hover:scale-105 shadow-sm relative">
                                                <i class="fa fa-shopping-bag text-white text-lg"></i> 
                                                @if(isset($orderNotifCount) && $orderNotifCount > 0)
                                                    <span class="absolute -top-1 -right-1 bg-amber-500 text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold border border-white">{{ $orderNotifCount }}</span>
                                                @endif
                                            </div>
                                            <span class="text-[11px] font-medium text-gray-700 text-center group-hover:text-brandRed transition">Pesanan</span>
                                        </a>

                                        <a href="{{ route('customer.informasi') }}" class="flex flex-col items-center gap-2 group text-none flex-1">
                                            <div class="w-12 h-12 rounded-full bg-brandRed flex items-center justify-center transition group-hover:scale-105 shadow-sm">
                                                <i class="fa fa-info-circle text-white text-lg"></i>
                                            </div>
                                            <span class="text-[11px] font-medium text-gray-700 text-center group-hover:text-brandRed transition">Informasi Terbaru</span>
                                        </a>

                                        <a href="{{ route('customer.promo') }}" class="flex flex-col items-center gap-2 group text-none flex-1">
                                            <div class="w-12 h-12 rounded-full bg-brandRed flex items-center justify-center transition group-hover:scale-105 shadow-sm">
                                                <i class="fa fa-tags text-white text-lg"></i>
                                            </div>
                                            <span class="text-[11px] font-medium text-gray-700 text-center group-hover:text-brandRed transition">Promo</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        @guest
                            <button onclick="openLoginModal('keranjang')" class="text-black bg-transparent border-none p-0 transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1]">
                                <i class="fa fa-shopping-cart text-xl"></i>
                            </button>

                            <button onclick="openLoginModal('notifikasi')" class="text-black bg-transparent border-none p-0 transition-all duration-300 ease-in-out cursor-pointer inline-block hover:text-brandRed hover:scale-[1.1] mx-2">
                                <i class="fa fa-bell text-xl"></i>
                            </button>
                        @endguest
                    </div>

                    <div class="hidden md:flex items-center gap-5">
                        @auth
                            <div class="flex items-center gap-3">
                                <div class="relative inline-block text-left" id="userMenuWrapper">
                                    <button onclick="toggleUserMenu()" class="w-9 h-9 bg-brandBgGray rounded-full border border-gray-300 flex items-center justify-center text-gray-600 shadow-sm transition-all duration-300 hover:border-brandRed hover:text-brandRed cursor-pointer focus:outline-none overflow-hidden" title="{{ Auth::user()->name }}">
                                        <i class="fa-solid fa-user text-lg"></i>
                                    </button>

                                    <div id="userDropdown" class="hidden absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.1)] border border-gray-100 z-50 overflow-hidden transform origin-top-right transition-all duration-200">
                                        
                                        <div class="p-5 flex flex-col items-center bg-gray-50/50">
                                            <div class="w-16 h-16 bg-brandBgGray text-gray-600 rounded-full flex items-center justify-center border border-gray-300 shadow-sm mb-3 overflow-hidden">
                                                @if(Auth::user()->avatar)
                                                    <img src="{{ asset('storage/avatars/'.Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                                @else
                                                    <i class="fa-solid fa-user text-2xl text-gray-400"></i>
                                                @endif
                                            </div>
                                            <h4 class="font-bold text-gray-800 text-base leading-tight">{{ Auth::user()->name }}</h4>
                                        </div>

                                        <div class="p-5 space-y-4 text-sm border-t border-gray-100">
                                            <div class="flex items-center gap-3 text-gray-600">
                                                <i class="far fa-envelope text-gray-400 w-4 text-center text-base"></i>
                                                <div class="truncate">
                                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider leading-none mb-0.5">Email</p>
                                                    <span class="font-semibold text-gray-700 text-xs">{{ Auth::user()->email }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 text-gray-600">
                                                <i class="fas fa-phone-alt text-gray-400 w-4 text-center"></i>
                                                <div>
                                                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider leading-none mb-0.5">Nomor Telepon</p>
                                                    <span class="font-semibold text-gray-700 text-xs">{{ Auth::user()->phone ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <button type="button" onclick="openLogoutModal()" class="p-[8px_20px] bg-[#c40000] text-white border border-[#c40000] rounded-[20px] cursor-pointer font-semibold transition-all duration-300 ease-in-out hover:bg-white hover:text-[#c40000] hover:border-[#c40000] hover:shadow-[0_4px_12px_rgba(0,0,0,0.15)] hover:-translate-y-0.5 active:translate-y-0">
                                    Logout
                                </button>
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
                @if(!Route::is('customer.jam-layanan') && !Route::is('customer.tentang-kami') && !Route::is('customer.detail-produk') && !Route::is('customer.pembayaran') && !Route::is('customer.pesanan') && !Route::is('customer.informasi') && !Route::is('customer.promo') && !Route::is('customer.notifikasi'))
                    <div class="bg-brandRed text-white h-full w-[280px] flex items-center font-bold text-sm rounded-[15px_15px_0_0] gap-15 cursor-default pointer-events-none user-select-none shadow-[6px_0_10px_rgba(0,0,0,0.15)] relative z-10 pl-5">
                        <i class="fa fa-bars mr-3"></i> Pilih Kategori
                    </div>
                @else
                    <!-- Spacer pengganti agar menu 'Beranda' dkk tidak bergeser ke kiri saat Pilih Kategori hilang -->
                    <div class="w-[280px] h-full hidden md:block"></div>
                @endif
                <ul class="hidden md:flex list-none gap-[50px] ml-30 flex-1 pl-8">
                    <li><a href="/" class="text-white no-underline text-sm font-semibold cursor-pointer inline-block">Beranda</a></li>
                    <li><a href="{{ route('customer.semua-produk') }}" class="text-white no-underline text-sm font-semibold cursor-pointer inline-block">Semua Produk</a></li>
                    <li><a href="{{ route('customer.promo') }}" class="text-white no-underline text-sm font-semibold cursor-pointer inline-block">Promo</a></li>
                    <li><a href="{{ route('customer.jam-layanan') }}" class="text-white no-underline text-sm font-semibold cursor-pointer inline-block">Jam Layanan</a></li>
                    <li><a href="{{ route('customer.tentang-kami') }}" class="text-white no-underline text-sm font-semibold cursor-pointer inline-block">Tentang Kami</a></li>
                </ul>
                @php
                    $settingsData = $settings ?? $appSettings ?? [];

                    // Cleaning WA 1 & WA 2 agar valid untuk link wa.me
                    $rawWa1 = $settingsData['wa_number_1'] ?? '+62 851-1962-2615';
                    $rawWa2 = $settingsData['wa_number_2'] ?? '';

                    $cleanWa1 = preg_replace('/[^0-9]/', '', $rawWa1);
                    if (str_starts_with($cleanWa1, '0')) {
                        $cleanWa1 = '62' . substr($cleanWa1, 1);
                    }

                    $cleanWa2 = preg_replace('/[^0-9]/', '', $rawWa2);
                    if (str_starts_with($cleanWa2, '0')) {
                        $cleanWa2 = '62' . substr($cleanWa2, 1);
                    }
                @endphp
                <div class="hidden md:flex items-center gap-[10px] text-white ml-auto">
                    <img src="{{ asset('assets/icons/wa-icon.png') }}" alt="WA" class="w-5 h-5">
                    <span class="text-xs">Pusat Bantuan :</span>
                    <a href="https://wa.me/{{ $cleanWa1 }}?text=Halo%20{{ urlencode($settingsData['nama_toko'] ?? '') }}%2C%20saya%20butuh%20bantuan%20mengenai..." 
                    target="_blank" 
                    class="p-[6px_15px] bg-brandRed text-white border border-white rounded-[20px] text-xs font-bold cursor-pointer transition-all duration-300 ease-in-out ml-5 text-none hover:bg-white hover:text-brandRed hover:border-brandRed hover:shadow-[0_4px_12px_rgba(0,0,0,0.15)] hover:-translate-y-0.5 active:translate-y-0 block">
                        Customer Service
                    </a>
                </div>
            </div>
        </nav>
    </div> 

    <main class="pt-[125px]">        
        @yield('content')
    </main>

    <footer class="bg-[#c40000] text-white py-[25px] mt-[50px] text-[13px] [line-height:1.6] font-sans">
        <div class="max-w-[1350px] mx-auto px-[20px] grid grid-cols-1 md:grid-cols-5 gap-[30px] items-start">
            
            {{-- 1. LOGO & DESKRIPSI --}}
            <div class="w-full">
                @if(!empty($appSettings['logo_toko']))
                    <a href="{{ route('customer.dashboard') }}">
                        <img src="{{ asset('storage/' . $appSettings['logo_toko']) }}" 
                            alt="{{ $appSettings['nama_toko'] ?? '' }}" 
                            class="w-[180px] mb-[20px] p-[5px] rounded-[5px] object-contain">
                    </a>
                @endif
                
                <p class="text-white/90 text-justify">
                    {{ $appSettings['deskripsi_toko'] ?? '' }}
                </p>
            </div>

            {{-- 2. KATEGORI --}}
            <div class="w-full">
                <h3 class="text-[16px] mb-[20px] font-bold text-left">Kategori</h3>
                <div class="flex gap-[20px] text-left">
                    @php
                        $footerCategories = DB::table('kategoris')->get();
                        $chunks = $footerCategories->chunk(ceil($footerCategories->count() / 2));
                    @endphp

                    @foreach($chunks as $chunk)
                        <ul class="list-none p-0 flex-1">
                            @foreach($chunk as $cat)
                                <li class="mb-[8px]">
                                    <a href="{{ route('customer.semua-produk', ['kategori' => $cat->id]) }}" 
                                    class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px] inline-block">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>

            {{-- 3. TENTANG KAMI & INSTAGRAM DINAMIS --}}
            <div class="w-full">
                <h3 class="text-[16px] mb-[20px] font-bold text-left">Tentang Kami</h3>
                <ul class="list-none p-0 mb-[20px]">
                    <li class="mb-[8px]">
                        <a href="{{ route('customer.tentang-kami') }}" class="text-white/80 no-underline text-[13px] transition-all duration-300 hover:text-white hover:pl-[5px]">
                            Profil Perusahaan
                        </a>
                    </li>
                </ul>

                <h3 class="text-[16px] mb-[20px] font-bold text-left">Ikuti Kami</h3>
                <div class="mt-[10px] flex items-center gap-3">
                    {{-- Instagram --}}
                    @php
                        $rawIg = $settingsData['instagram_url'] ?? '';
                        $cleanIg = str_replace(['https://', 'http://', 'instagram.com/', 'www.instagram.com/', '@'], '', $rawIg);
                        $cleanIg = trim($cleanIg, '/ ');
                        $finalIgUrl = !empty($cleanIg) ? 'https://www.instagram.com/' . $cleanIg . '/' : '#';
                    @endphp

                    @if(!empty($cleanIg))
                        <a href="{{ $finalIgUrl }}" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        aria-label="Ikuti kami di Instagram" 
                        class="inline-block transition-all duration-300 hover:scale-[1.1]">
                            <img src="{{ asset('assets/icons/instagram_.png') }}" alt="Instagram" class="w-[30px] h-[30px] align-middle">
                        </a>
                    @endif

                    {{-- Google Maps (dengan background putih) --}}
                    @php
                        // Ambil langsung sesuai nama key di database: 'link_google_maps'
                        $mapsUrl = $settingsData['link_google_maps'] ?? '#';
                    @endphp

                    <a href="{{ $mapsUrl }}" 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    aria-label="Lokasi Kami di Google Maps" 
                    class="w-[30px] h-[30px] bg-white rounded-[8px] flex items-center justify-center transition-all duration-300 hover:scale-[1.1] shadow-sm"
                    title="Lokasi Kami">
                        <img src="{{ asset('assets/icons/maps.png') }}" 
                            alt="Google Maps" 
                            class="w-[22px] h-[22px] object-contain" 
                            onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/2991/2991231.png';">
                    </a>
                </div>
            </div>

            {{-- 4. JAM LAYANAN --}}
            <div class="w-full">                    
                <h3 class="text-[16px] mb-[20px] font-bold text-left">Jam Layanan</h3>
                <div class="flex gap-[12px] mb-[15px] items-start">
                    <i class="far fa-clock text-[16px] mt-[5px]"></i>
                    <span>Senin - Sabtu<br>{{ $settings['jam_senin_sabtu'] ?? ($appSettings['jam_senin_sabtu'] ?? '') }}</span>
                </div>
                <div class="flex gap-[12px] mb-[15px] items-start">
                    <i class="far fa-clock text-[16px] mt-[5px]"></i>
                    <span>Minggu<br>{{ $settings['jam_minggu'] ?? ($appSettings['jam_minggu'] ?? '') }}</span>
                </div>
            </div>

            {{-- 5. HUBUNGI KAMI --}}
            <div class="w-full">
                <h3 class="text-[16px] mb-[20px] font-bold text-left">Hubungi Kami</h3>
                
                {{-- Alamat --}}
                <div class="flex gap-[12px] mb-[15px] items-start">
                    <i class="fas fa-map-marker-alt text-[16px] mt-[5px]"></i>
                    <span class="text-white/90">
                        <strong>{{ $appSettings['nama_toko'] ?? $settings['nama_toko'] ?? '' }}</strong><br>
                        {{ $appSettings['jalan_detail'] ?? $settings['jalan_detail'] ?? '' }},
                        {{ $appSettings['desa_dusun'] ?? $settings['desa_dusun'] ?? '' }},
                        Kec. {{ $appSettings['kecamatan'] ?? $settings['kecamatan'] ?? '' }},
                        Kab. {{ $appSettings['kota'] ?? $settings['kota'] ?? '' }},
                        {{ $appSettings['provinsi'] ?? $settings['provinsi'] ?? '' }}
                        {{ $appSettings['kode_pos'] ?? $settings['kode_pos'] ?? '' }}
                    </span>
                </div>

                {{-- WhatsApp --}}
                <div class="flex gap-[12px] mb-[15px] items-start">
                    <img src="{{ asset('assets/icons/wa-icon.png') }}" alt="WA" class="w-[16px] h-[16px] align-middle mt-[3px]"> 
                    <div>
                        <span>{{ $settingsData['wa_number_1'] ?? '' }}</span>
                        @if(!empty($settingsData['wa_number_2']))
                            <br>
                            <span>{{ $settingsData['wa_number_2'] }}</span>
                        @endif
                    </div>
                </div>

                {{-- Email --}}
                <div class="flex gap-[12px] mb-[15px] items-start">
                    <i class="far fa-envelope text-[16px] mt-[3px]"></i>
                    <span>{{ $settingsData['email_toko'] ?? '' }}</span>
                </div>

            </div>
        </div>
    </footer>

    <!-- Modal Alert Login -->
    <div id="loginAlertModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white w-[90%] max-w-[400px] rounded-[30px] p-8 flex flex-col items-center text-center shadow-[0_10px_30px_rgba(0,0,0,0.15)] transform scale-95 transition-transform duration-300">
            <div class="w-16 h-16 bg-brandRed/10 text-brandRed rounded-full flex items-center justify-center text-3xl mb-4 shadow-sm">
                <i class="fa-solid fa-user-lock"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2 tracking-wide">Yuk, Masuk Dulu!</h3>
            
            <p id="loginAlertMessage" class="text-sm text-gray-500 mb-6 leading-relaxed">
                Silakan login terlebih dahulu ke akun Anda.
            </p>
            
            <div class="flex gap-3 w-full">                
                <button onclick="closeLoginModal()" class="flex-1 py-3 border border-gray-200 text-gray-500 rounded-[15px] text-sm font-semibold cursor-pointer transition hover:bg-gray-50">
                    Batal
                </button>
                <a href="{{ route('login') }}" class="flex-1 py-3 bg-brandRed text-white rounded-[15px] text-sm font-bold text-center cursor-pointer transition hover:scale-[1.02] hover:shadow-[0_4px_15px_rgba(196,0,0,0.3)]">
                    Masuk Sekarang
                </a>
            </div>
        </div>
    </div>

    @auth
    <!-- Modal Konfirmasi Logout -->
    <div id="logoutModal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 p-4">
        <div class="bg-white w-full max-w-[400px] rounded-[25px] p-8 flex flex-col items-center text-center shadow-[0_10px_30px_rgba(0,0,0,0.2)] transform scale-95 transition-transform duration-300">
            <div class="w-16 h-16 bg-red-50 text-[#c40000] rounded-full flex items-center justify-center text-3xl mb-4">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2 font-inder">Konfirmasi Keluar</h3>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">Apakah Anda yakin ingin keluar dari akun Fantastic Digital Printing?</p>
            <div class="flex gap-3 w-full">
                <button type="button" onclick="closeLogoutModal()" class="flex-1 py-2.5 border border-gray-300 text-gray-600 rounded-[15px] text-sm font-semibold cursor-pointer transition hover:bg-gray-50">
                    Batal
                </button>
                <form action="{{ route('logout') }}" method="POST" class="flex-1 m-0 p-0">
                    @csrf
                    <button type="submit" class="w-full py-2.5 bg-[#c40000] text-white rounded-[15px] text-sm font-semibold text-center cursor-pointer transition hover:bg-red-700 shadow-md shadow-red-600/10">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endauth

    <script>
        // === TOGGLE DROPDOWN ===
        function toggleCartPopup() {
            const cart = document.getElementById('cartDropdown');
            const notif = document.getElementById('notificationDropdown');
            const userMenu = document.getElementById('userDropdown');
            
            if(cart) cart.classList.toggle('hidden');
            if(notif) notif.classList.add('hidden');
            if(userMenu) userMenu.classList.add('hidden');
        }

        function toggleNotificationPopup() {
            const notif = document.getElementById('notificationDropdown');
            const cart = document.getElementById('cartDropdown');
            const userMenu = document.getElementById('userDropdown');
            
            if(notif) notif.classList.toggle('hidden');
            if(cart) cart.classList.add('hidden');
            if(userMenu) userMenu.classList.add('hidden');
        }

        function toggleUserMenu() {
            const userMenu = document.getElementById('userDropdown');
            const cart = document.getElementById('cartDropdown');
            const notif = document.getElementById('notificationDropdown');
            
            if(userMenu) userMenu.classList.toggle('hidden');
            if(cart) cart.classList.add('hidden');
            if(notif) notif.classList.add('hidden');
        }

        // === HITUNG TOTAL POPUP KERANJANG ===
        function hitungTotalPopup() {
            let total = 0;
            const checkboxes = document.querySelectorAll('.cart-checkbox:checked');
            
            checkboxes.forEach(cb => {
                const price = parseFloat(cb.getAttribute('data-price')) || 0;
                const qty = parseInt(cb.getAttribute('data-qty')) || 0;
                total += price * qty;
            });
            
            const totalElem = document.getElementById('totalHargaPopup');
            if(totalElem) {
                totalElem.innerText = 'Rp ' + total.toLocaleString('id-ID');
            }
        }

        // === SUBMENU (MOBILE) ===
        function toggleSubMenu(element, event) {
            if (window.innerWidth < 768) {
                if (event.target.closest('a')) return;
                const submenu = element.querySelector('.submenu-box');
                const arrow = element.querySelector('.arrow-icon');
                if(!submenu) return;

                const isHidden = submenu.classList.contains('hidden');
                
                document.querySelectorAll('.submenu-box').forEach(box => {
                    box.classList.add('hidden');
                    box.classList.remove('block');
                });
                document.querySelectorAll('.arrow-icon').forEach(arr => {
                    arr.classList.remove('rotate-90', 'text-brandRed');
                });

                if (isHidden) {
                    submenu.classList.remove('hidden');
                    submenu.classList.add('block');
                    if(arrow) arrow.classList.add('rotate-90', 'text-brandRed'); 
                }
            }
        }

        // === UTILS HELPER UNTUK ANIMASI MODAL ===
        function showModalAnimated(modalId) {
            const modal = document.getElementById(modalId);
            if(!modal) return;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                const innerCard = modal.querySelector('.transform');
                if(innerCard) {
                    innerCard.classList.remove('scale-95');
                    innerCard.classList.add('scale-100');
                }
            }, 10);
        }

        function hideModalAnimated(modalId) {
            const modal = document.getElementById(modalId);
            if(!modal) return;

            modal.classList.add('opacity-0');
            const innerCard = modal.querySelector('.transform');
            if(innerCard) {
                innerCard.classList.remove('scale-100'); 
                innerCard.classList.add('scale-95');
            }
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        // === MODAL LOGIN ===
        function openLoginModal(fitur) {
            const message = document.getElementById('loginAlertMessage');
            if (message) {
                if (fitur === 'keranjang') {
                    message.innerText = "Silakan login terlebih dahulu ke akun Anda untuk mengakses fitur keranjang belanja.";
                } else if (fitur === 'notifikasi') {
                    message.innerText = "Silakan login terlebih dahulu ke akun Anda untuk melihat notifikasi terbaru.";
                } else {
                    message.innerText = "Silakan login terlebih dahulu ke akun Anda.";
                }
            }
            showModalAnimated('loginAlertModal');
        }

        function closeLoginModal() { 
            hideModalAnimated('loginAlertModal');
        }

        // === MODAL LOGOUT ===
        function openLogoutModal() {
            showModalAnimated('logoutModal');
        }

        function closeLogoutModal() {
            hideModalAnimated('logoutModal');
        }

        // === CLOSE DROPDOWNS ON OUTSIDE CLICK ===
        window.addEventListener('click', function(event) {
            const cartWrapper = document.getElementById('cartMenuWrapper');
            const notifWrapper = document.getElementById('notifMenuWrapper');
            const userWrapper = document.getElementById('userMenuWrapper');

            if (cartWrapper && !cartWrapper.contains(event.target)) {
                const cartDropdown = document.getElementById('cartDropdown');
                if (cartDropdown) cartDropdown.classList.add('hidden');
            }

            if (notifWrapper && !notifWrapper.contains(event.target)) {
                const notifDropdown = document.getElementById('notificationDropdown');
                if (notifDropdown) notifDropdown.classList.add('hidden');
            }

            if (userWrapper && !userWrapper.contains(event.target)) {
                const userDropdown = document.getElementById('userDropdown');
                if (userDropdown) userDropdown.classList.add('hidden');
            }
        });
    </script>
@stack('scripts')
</body>
</html>