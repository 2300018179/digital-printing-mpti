@extends('layouts.customer')

@section('title', 'Informasi Toko - Fantastic Digital Printing')

@section('content')
<div class="max-w-[1350px] mx-auto px-[15px] w-full pt-4 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Judul (KEMBALI KE UKURAN NORMAL / BESAR) --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                <i class="fa fa-info-circle text-brandRed"></i> Informasi & Pengumuman Toko
            </h1>
            <p class="text-xs text-gray-500 mt-1">Dapatkan pembaruan kabar dan pengumuman resmi seputar operasional toko kami.</p>
        </div>

        {{-- CEK DATA PENGUMUMAN --}}
        @if(isset($pengumumans) && $pengumumans->count() > 0)
            <div class="space-y-4">
                @foreach($pengumumans as $info)
                    {{-- Kartu Utama: Tetap dibuat ringkas & pipih (p-4 md:p-5) agar tidak makan tempat ke bawah --}}
                    <div class="bg-white rounded-2xl p-4 md:p-5 border border-gray-100 border-l-[5px] border-l-brandRed shadow-[0_2px_12px_rgba(0,0,0,0.03)] hover:shadow-md transition duration-300 w-full">
                        
                        {{-- 1. Baris Badge & Tanggal --}}
                        <div class="flex items-center justify-between flex-wrap gap-2 mb-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 bg-red-50 text-brandRed text-[10px] font-bold rounded-full uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-brandRed"></span>
                                Pengumuman Resmi
                            </span>
                            
                            <span class="text-[11px] text-gray-400 font-medium flex items-center gap-1">
                                <i class="far fa-calendar-alt text-gray-400"></i>
                                {{ \Carbon\Carbon::parse($info->tanggal ?? $info->created_at)->format('d M Y') }}
                            </span>
                        </div>

                        {{-- 2. Judul Merah (Margin mb-2.5) --}}
                        <h2 class="text-base md:text-lg font-extrabold text-brandRed mb-2.5 leading-snug">
                            {{ $info->judul }}
                        </h2>

                        {{-- 3. Kotak Abu-Abu Isi Pengumuman (Padding tipis p-3.5 md:p-4) --}}
                        <div class="bg-[#F8F9FA] border border-gray-100/80 rounded-xl p-3.5 md:p-4 text-xs md:text-sm text-gray-600 leading-relaxed whitespace-pre-line mb-3">
                            {{ $info->isi }}
                        </div>

                        {{-- 4. Footer Card --}}
                        <div class="flex items-center justify-between text-[11px] md:text-xs">
                            <span class="text-gray-400 font-normal">Ada pertanyaan terkait pengumuman ini?</span>
                            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-1 text-brandRed font-bold hover:underline no-underline">
                                <i class="fab fa-whatsapp text-xs md:text-sm"></i> Tanya Tim Kami
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            {{-- EMPTY STATE --}}
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 py-12 px-4 flex flex-col items-center justify-center min-h-[250px]">
                <div class="w-14 h-14 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-3">
                    <i class="fa fa-folder-open text-2xl"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-1">Belum Ada Informasi Baru</h3>
                <p class="text-xs text-gray-400 text-center max-w-xs">
                    Hubungi kami via kontak jika ada pertanyaan seputar operasional toko.
                </p>
            </div>
        @endif

    </div>
</div>
@endsection