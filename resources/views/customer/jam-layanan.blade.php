@extends('layouts.customer')

@section('title', 'Jam Layanan - Fantastic Digital Printing')

@section('content')
<div class="max-w-[1350px] mx-auto px-[15px] w-full flex flex-col items-center mb-16 mt-4">
    
    <div class="w-full bg-brandRed text-white rounded-[20px] p-6 flex items-center justify-center gap-4 shadow-[0_4px_15px_rgba(196,0,0,0.15)] mb-8">
        <div class="text-4xl">
            <i class="far fa-clock"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold tracking-wide leading-tight">Jam Layanan</h1>
            <p class="text-sm text-white/90">Siap Melayani Anda</p>
        </div>
    </div>

    <div class="w-full max-w-[850px] bg-white border border-gray-200 rounded-[30px] p-10 md:p-14 shadow-[0_4px_25px_rgba(0,0,0,0.03)] flex flex-col items-center">
        
        <div class="flex items-center gap-4 mb-10 w-full justify-center border-b border-gray-100 pb-6">
            <div class="w-14 h-14 bg-brandRed rounded-full flex items-center justify-center text-white text-2xl shadow-sm">
                <i class="fas fa-store"></i>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-wide text-center">
                {{ $appSettings['nama_toko'] ?? $settings['nama_toko'] ?? '' }}
            </h2>
        </div>

        <div class="w-full space-y-6 mb-10 text-base md:text-lg">
            <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                <span class="font-medium text-gray-700">Senin - Sabtu</span>
                <span class="font-bold text-brandRed font-inder">
                    {{ $appSettings['jam_senin_sabtu'] ?? $settings['jam_senin_sabtu'] ?? '' }}
                </span>
            </div>
            <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                <span class="font-medium text-gray-700">Minggu</span>
                <span class="font-bold text-gray-400 font-inder">
                    {{ $appSettings['jam_minggu'] ?? $settings['jam_minggu'] ?? '' }}
                </span>
            </div>
        </div>

        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 text-xs md:text-sm text-gray-500">
            <div class="flex items-start gap-3">
                <i class="fas fa-map-marker-alt text-brandRed text-base mt-0.5 shrink-0"></i>
                <p class="leading-relaxed">
                    {{ $appSettings['jalan_detail'] ?? $settings['jalan_detail'] ?? '' }}, 
                    {{ $appSettings['desa_dusun'] ?? $settings['desa_dusun'] ?? '' }}, 
                    Kec. {{ $appSettings['kecamatan'] ?? $settings['kecamatan'] ?? '' }}, 
                    Kab. {{ $appSettings['kota'] ?? $settings['kota'] ?? '' }}, 
                    {{ $appSettings['provinsi'] ?? $settings['provinsi'] ?? '' }}
                </p>
            </div>
            <div class="flex items-center gap-3 md:justify-end">
                <i class="fab fa-whatsapp text-emerald-500 text-lg shrink-0"></i>
                <span class="font-semibold text-gray-700">
                    {{ $appSettings['wa_number_1'] ?? $settings['wa_number_1'] ?? '' }}
                </span>
            </div>
        </div>

    </div>

</div>
@endsection