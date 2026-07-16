@extends('layouts.customer')

@section('title', 'Fantastic Digital Printing - Beranda')

@section('content')
<div class="max-w-[1350px] mx-auto px-[15px] w-full flex flex-col md:flex-row gap-5 items-start mb-12">
    
    <aside class="w-full md:w-[280px] shrink-0 bg-white rounded-[0_0_20px_20px] shadow-[0_10px_20px_rgba(0,0,0,0.05)] flex flex-col border border-t-0 border-[#f0f0f0] relative z-20">
        <ul class="list-none m-0 p-0">
            @php
                $iconMapping = [
                    1 => 'fas fa-file-alt',
                    2 => 'fas fa-sticky-note',
                    3 => 'far fa-calendar-alt',
                    4 => 'fas fa-scroll',
                    5 => 'fas fa-tshirt',
                    6 => 'fas fa-gift',
                    7 => 'fas fa-envelope-open-text',
                    8 => 'fas fa-clipboard',
                    9 => 'fas fa-id-card',
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

    <div class="flex-1 flex p-0 h-[350px] md:mt-[30px]">
        <div class="w-full h-full">
            <div class="h-full rounded-[20px] overflow-hidden relative bg-[#e0e0e0] shadow-[0_10px_20px_rgba(0,0,0,0.05)]">
                <img src="{{ asset('assets/view/iklan.jpg') }}" alt="Promo Utama" class="w-full h-full object-cover">
                <button class="absolute top-1/2 -translate-y-1/2 w-[35px] h-[35px] bg-black/70 text-white border-none rounded-full flex items-center justify-center cursor-pointer z-10 transition duration-300 hover:bg-black/95 left-[15px]" aria-label="Previous">
                    <i class="fa fa-chevron-left text-[14px]"></i>
                </button>
                <button class="absolute top-1/2 -translate-y-1/2 w-[35px] h-[35px] bg-black/70 text-white border-none rounded-full flex items-center justify-center cursor-pointer z-10 transition duration-300 hover:bg-black/95 right-[15px]" aria-label="Next">
                    <i class="fa fa-chevron-right text-[14px]"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="max-w-[1350px] mx-auto px-[15px] w-full">
    <section class="flex flex-wrap md:flex-nowrap justify-between gap-5 md:gap-10 m-[10px_0_20px_0]">
        <div class="flex-1 min-w-[45%] md:min-w-0 bg-[#e6e6e6] p-[10px] rounded-[25px] flex items-center gap-[12px]">
            <div class="bg-brandRed w-10 h-10 min-w-[40px] rounded-[12px] flex items-center justify-center text-white text-xl"><i class="fas fa-shipping-fast"></i></div>
            <div>
                <h4 class="text-sm font-bold text-[#333] mb-[2px]">Kirim Kemanapun</h4>
                <p class="text-[11px] text-[#666] leading-tight">Tersedia pilihan pengiriman, dari instan hingga kargo</p>
            </div>
        </div>
        <div class="flex-1 min-w-[45%] md:min-w-0 bg-[#e6e6e6] p-[10px] rounded-[25px] flex items-center gap-[12px]">
            <div class="bg-brandRed w-10 h-10 min-w-[40px] rounded-[12px] flex items-center justify-center text-white text-xl"><i class="fas fa-star"></i></div>
            <div>
                <h4 class="text-sm font-bold text-[#333] mb-[2px]">Berkualitas</h4>
                <p class="text-[11px] text-[#666] leading-tight">Dicetak dengan mesin berteknologi tinggi</p>
            </div>
        </div>
        <div class="flex-1 min-w-[45%] md:min-w-0 bg-[#e6e6e6] p-[10px] rounded-[25px] flex items-center gap-[12px]">
            <div class="bg-brandRed w-10 h-10 min-w-[40px] rounded-[12px] flex items-center justify-center text-white text-xl"><i class="fas fa-cog"></i></div>
            <div>
                <h4 class="text-sm font-bold text-[#333] mb-[2px]">Proses Cepat</h4>
                <p class="text-[11px] text-[#666] leading-tight">Proses produksi cepat, bahkan bisa ditunggu</p>
            </div>
        </div>
        <div class="flex-1 min-w-[45%] md:min-w-0 bg-[#e6e6e6] p-[10px] rounded-[25px] flex items-center gap-[12px]">
            <div class="bg-brandRed w-10 h-10 min-w-[40px] rounded-[12px] flex items-center justify-center text-white text-xl"><i class="fas fa-headset"></i></div>
            <div>
                <h4 class="text-sm font-bold text-[#333] mb-[2px]">Online Support</h4>
                <p class="text-[11px] text-[#666] leading-tight">Pesan hanya lewat online saja tanpa datang ke lokasi</p>
            </div>
        </div>
    </section>

    <section class="mt-[10px]">
        <div class="flex items-center gap-[10px] my-5">
            <h2 class="text-[20px] font-extrabold text-brandRed whitespace-nowrap">Produk Unggulan</h2>
            <div class="flex-1 h-[3px] bg-brandRed"></div>
            <a href="{{ route('customer.semua-produk') }}" class="text-brandRed no-underline text-[15px] font-bold">Lihat Semua ></a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5 mt-5">
            @forelse ($products as $p)
                <a href="{{ route('customer.detail-produk', $p->id) }}" class="block bg-white rounded-[20px] overflow-hidden border border-[#c40000] flex flex-col relative transition-all duration-300 ease-in-out cursor-pointer hover:-translate-y-[5px] hover:shadow-[0_8px_20px_rgba(0,0,0,0.1)]">
                    <div class="w-full aspect-square flex items-center justify-center p-[5px] bg-white">
                        <img src="{{ asset('assets/products/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-contain">
                    </div>
                    <div class="bg-[#c40000] text-white p-[15px] rounded-[0_0_15px_15px] -mt-[1px] flex flex-col items-center justify-between min-h-[105px] relative">
                        <span class="text-sm font-semibold text-left mb-3 w-full line-clamp-2">{{ $p->name }}</span> 
                        <div class="font-inder bg-white text-black p-[5px_20px] rounded-[20px] text-[13px] font-normal shadow-[0_2px_4px_rgba(0,0,0,0.1)] whitespace-nowrap inline-block leading-none mx-auto">
                            Rp {{ number_format($p->price, 0, ',', '.') }}/{{ $p->unit }}
                        </div> 
                    </div>
                </a>
            @empty 
                <div class="col-span-full text-center py-12 text-gray-400">Belum ada data produk unggulan.</div>
            @endforelse
        </div>
    </section>
</div>
@endsection