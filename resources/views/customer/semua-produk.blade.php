@extends('layouts.customer')

@section('title', $title . ' - Fantastic Digital Printing')

@section('content')
<div class="max-w-[1350px] mx-auto px-[15px] w-full flex flex-col md:flex-row gap-5 items-start mb-12">
    
    {{-- ASIDE: Sidebar Kategori --}}
    <aside class="hidden md:flex w-[280px] shrink-0 bg-white rounded-[0_0_20px_20px] shadow-[0_10px_20px_rgba(0,0,0,0.05)] flex-col border border-t-0 border-[#f0f0f0] relative z-20">
        <ul class="list-none m-0 p-0">
            @php
                $iconMapping = [
                    1 => 'fas fa-file-alt',          // Print On Paper
                    2 => 'fas fa-sticky-note',       // Print Stiker
                    3 => 'far fa-calendar-alt',      // Kalender
                    4 => 'fas fa-scroll',            // Banner & Spanduk
                    5 => 'fas fa-tshirt',            // Sablon
                    6 => 'fas fa-gift',              // Souvenir
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
                            {{-- Direkomendasikan menggunakan $cat->subKategoris via Controller --}}
                            @foreach($cat->subKategoris ?? [] as $sub)
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

    {{-- SECTION: Daftar Produk --}}
    <section class="flex-1 flex flex-col justify-between self-stretch pt-5 md:pt-8">
        <div>
            <div class="mb-4">
                <h2 class="text-2xl font-bold text-brandTextDark mt-0.5">{{ $title }}</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 mt-5">
                @forelse ($products as $p)
                    <a href="{{ route('customer.detail-produk', $p->id) }}" class="block bg-white rounded-[20px] overflow-hidden border border-[#c40000] flex flex-col relative transition-all duration-300 ease-in-out cursor-pointer hover:-translate-y-[5px] hover:shadow-[0_8px_20px_rgba(0,0,0,0.1)]">
                        <div class="w-full aspect-square flex items-center justify-center p-[5px] bg-white">
                            <img src="{{ asset('assets/products/' . $p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-contain">
                        </div>
                        
                        <div class="bg-[#c40000] text-white p-[15px] rounded-[0_0_15px_15px] -mt-[1px] flex flex-col justify-between min-h-[105px] relative">
                            <span class="text-sm font-semibold text-left w-full break-words flex-grow flex items-start mb-3 line-clamp-2">
                                {{ $p->name }}
                            </span> 
                            
                            <div class="font-inder bg-white text-black p-[5px_20px] rounded-[20px] text-[13px] font-normal shadow-[0_2px_4px_rgba(0,0,0,0.1)] whitespace-nowrap inline-block leading-none shrink-0 mx-auto">
                                Rp. {{ number_format($p->price, 0, ',', '.') }}/{{ $p->unit }}
                            </div> 
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <i class="fas fa-box-open text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-400 text-sm font-medium">Belum ada produk yang tersedia untuk kategori ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- PAGINATION --}}
        @if ($products->hasPages())
            <div class="flex justify-center items-center gap-2 text-xs font-semibold mt-12 mb-4 text-gray-600">
                @if ($products->onFirstPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                        <i class="fa fa-chevron-left text-[10px]"></i>
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition text-gray-600">
                        <i class="fa fa-chevron-left text-[10px]"></i>
                    </a>
                @endif

                @for ($page = 1; $page <= $products->lastPage(); $page++)
                    @if ($page == $products->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#c40000] text-white font-bold">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $products->url($page) }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition text-gray-600">
                            {{ $page }}
                        </a>
                    @endif
                @endfor

                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition text-gray-600">
                        <i class="fa fa-chevron-right text-[10px]"></i>
                    </a>
                @else
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed">
                        <i class="fa fa-chevron-right text-[10px]"></i>
                    </span>
                @endif
            </div>
        @endif
    </section>
</div>
@endsection