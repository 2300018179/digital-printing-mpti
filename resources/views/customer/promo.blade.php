@extends('layouts.customer') {{-- Menyesuaikan path layout yang benar --}}

@section('title', 'Promo - Fantastic Digital Printing')

@section('content')
<div class="max-w-[1350px] mx-auto px-[15px] w-full flex flex-col md:flex-row gap-5 items-start mb-12">
            
    <!-- SIDEBAR KATEGORI -->
    <aside class="hidden md:flex w-[280px] shrink-0 bg-white rounded-[0_0_20px_20px] shadow-[0_10px_20px_rgba(0,0,0,0.05)] flex-col border border-t-0 border-[#f0f0f0] relative z-20">
        <ul class="list-none m-0 p-0">
            @php
                $iconMapping = [
                    1 => 'fas fa-file-alt',           // Print On Paper
                    2 => 'fas fa-sticky-note',       // Print Stiker
                    3 => 'far fa-calendar-alt',      // Kalender
                    4 => 'fas fa-scroll',            // Banner & Spanduk
                    5 => 'fas fa-tshirt',            // Sablon
                    6 => 'fas fa-gift',              // Sovenir
                    7 => 'fas fa-envelope-open-text',// Undangan
                    8 => 'fas fa-clipboard',         // Papan Informasi
                    9 => 'fas fa-id-card',           // Tanda Pengenal
                ];
            @endphp

            @foreach($categories as $cat)
                <li onclick="toggleSubMenu(this, event)" class="category-item group/item flex flex-col md:flex-row md:justify-between md:items-center p-[10px_20px] border-b border-[#f0f0f0] cursor-pointer hover:bg-[#fff5f5] transition-colors relative">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex items-center gap-[15px]">
                            <i class="{{ $iconMapping[$cat->id] ?? 'fas fa-folder' }} text-brandRed text-[16px] w-5 text-center"></i> 
                            <span class="text-[13px] font-medium text-brandTextDark">{{ $cat->name }}</span>
                        </div>
                        <i class="fa fa-chevron-right arrow-icon text-[11px] text-[#ccc] group-hover/item:text-brandRed transition-all duration-200"></i>
                    </div>

                    <div class="submenu-box hidden md:block md:absolute md:left-[100%] md:top-0 w-full md:w-[240px] bg-white md:border md:border-[#f0f0f0] md:rounded-[0_20px_20px_20px] md:shadow-[10px_10px_20px_rgba(0,0,0,0.05)] md:opacity-0 md:pointer-events-none transition-all duration-200 z-[50] overflow-hidden mt-2 md:mt-0 pl-9 md:pl-0 md:group-hover/item:opacity-100 md:group-hover/item:pointer-events-auto">
                        <ul class="list-none m-0 p-0 flex flex-col">
                            @php
                                $subItems = DB::table('sub_kategoris')->where('kategori_id', $cat->id)->get();
                            @endphp
                            @foreach($subItems as $sub)
                                <a href="{{ route('customer.semua-produk', ['sub' => $sub->id]) }}" class="py-2 md:p-[12px_20px] text-[13px] font-medium text-gray-700 hover:bg-[#fff5f5] hover:text-brandRed border-b border-[#f9f9f9] transition-colors">
                                    {{ $sub->name }}
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach
        </ul>
    </aside>

    <!-- CONTENT AREA -->
    <section class="flex-1 w-full flex flex-col pt-5 md:pt-8">
        
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-brandTextDark mt-0.5">Promo Spesial</h2>
        </div>

        {{-- CEK APAKAH ADA PROMO --}}
        @if(isset($promos) && $promos->count() > 0)
            <!-- CONTAINER LIST VOUCHER -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 w-full">
                @foreach($promos as $promo)
                    <div class="flex bg-white rounded-2xl border border-gray-100 shadow-[0_4px_15px_rgba(0,0,0,0.04)] overflow-hidden h-[130px] relative transition-transform hover:-translate-y-0.5">
                        
                        <!-- SISI KIRI (JENIS VOUCHER) -->
                        <div class="w-[110px] md:w-[130px] bg-[#4ca393] shrink-0 flex flex-col items-center justify-center text-white p-3 text-center relative">
                            <span class="text-xs uppercase font-bold tracking-wider opacity-90">Kupon</span>
                            <span class="text-sm md:text-base font-extrabold font-inder leading-tight mt-1">
                                {{ $promo->badge_type ?? 'POTONGAN HARGA' }}
                            </span>
                            
                            <!-- Dekorasi Setengah Lingkaran ala Tiket Gerigi (Kiri) -->
                            <div class="absolute -right-1.5 top-1/2 -translate-y-1/2 flex flex-col gap-1 z-30">
                                @for($i = 0; $i < 6; $i++)
                                    <div class="w-3 h-3 bg-white rounded-full"></div>
                                @endfor
                            </div>
                        </div>

                        <!-- SISI KANAN (INFO DETIL VOUCHER) -->
                        <div class="flex-1 p-4 flex flex-col justify-between pl-6 relative">
                            <div>
                                <!-- Label & Judul Voucher -->
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="bg-orange-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-sm uppercase tracking-wide">
                                        {{ $promo->tag ?? 'Spesial' }}
                                    </span>
                                    <h3 class="text-sm md:text-base font-bold text-gray-800 line-clamp-1">
                                        {{ $promo->title }}
                                    </h3>
                                </div>
                                
                                <!-- Deskripsi / Syarat Minimal Belanja -->
                                <p class="text-xs text-gray-500 mt-1 line-clamp-1 font-inder">
                                    {{ $promo->description }}
                                </p>
                            </div>

                            <!-- Baris Bawah: Masa Berlaku & Tombol S&K -->
                            <div class="flex justify-between items-end border-t border-dashed border-gray-100 pt-2">
                                <span class="text-[10px] md:text-xs text-red-500 font-medium">
                                    <i class="far fa-clock mr-1"></i>Hingga {{ \Carbon\Carbon::parse($promo->end_date)->format('d.m.Y') }}
                                </span>
                                <button onclick="openTncModal('{{ $promo->id }}')" class="text-[10px] md:text-xs font-semibold text-blue-600 bg-transparent border-none cursor-pointer hover:underline">
                                    S&K
                                </button>
                            </div>

                            <!-- Tombol Pakai/Salin di Pojok Kanan Atas -->
                            <div class="absolute right-4 top-4">
                                <a href="{{ route('customer.semua-produk') }}" class="text-xs font-bold text-orange-600 flex items-center gap-0.5 no-underline hover:opacity-80">
                                    Pakai <i class="fa fa-chevron-right text-[9px]"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <!-- EMPTY STATE (JIKA BELUM ADA PROMO) -->
            <div class="w-full border border-gray-200 rounded-[30px] p-16 flex flex-col items-center justify-center text-center bg-white shadow-[0_4px_25px_rgba(0,0,0,0.02)] min-h-[420px]">
                <div class="text-gray-300 text-8xl mb-6">
                    <i class="fas fa-box-open"></i>
                </div>

                <p class="text-gray-400 font-medium text-sm tracking-wide mb-8">
                    Belum ada promo yang tersedia saat ini.
                </p>

                <a href="{{ route('customer.semua-produk') }}">
                    <button class="p-[10px_35px] bg-brandRed text-white border border-brandRed rounded-[20px] font-bold text-xs tracking-wider transition-all duration-300 hover:scale-[1.03] hover:shadow-[0_4px_15px_rgba(196,0,0,0.3)] cursor-pointer">
                        Lihat Semua Produk
                    </button>
                </a>
            </div>
        @endif

    </section>

</div>
@endsection