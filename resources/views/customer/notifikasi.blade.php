@extends('layouts.customer') {{-- Sesuaikan dengan nama master layout kamu --}}

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <nav class="text-sm font-medium text-gray-500 mb-2">
                <a href="{{ route('customer.dashboard') }}" class="hover:text-brandRed">Home</a> &gt; 
                <span class="text-gray-800">Notifikasi</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                <i class="fa fa-bell text-brandRed"></i> Pusat Notifikasi
            </h1>
        </div>

        <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="flex border-b border-gray-100 px-6 py-4 bg-gray-50/50 justify-between items-center">
                <div class="flex gap-4">
                    <button class="text-xs font-bold text-brandRed border-b-2 border-brandRed pb-1">Semua</button>
                    <button class="text-xs font-semibold text-gray-500 hover:text-brandRed pb-1 transition">Belum Dibaca</button>
                </div>
                <button class="text-xs font-semibold text-gray-400 hover:text-brandRed transition">
                    Tandai Semua Sudah Dibaca
                </button>
            </div>

            <div class="divide-y divide-gray-100">
                
                {{-- CONTOH NOTIFIKASI 1: STATUS PESANAN (BELUM DIBACA) --}}
                <div class="p-6 hover:bg-red-50/30 transition flex gap-4 items-start bg-red-50/10">
                    <div class="w-10 h-10 rounded-full bg-brandRed/10 text-brandRed flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-shopping-bag text-base"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="text-sm font-bold text-gray-900">Pesanan Selesai Dicetak! 🎉</h3>
                            <span class="text-[11px] text-gray-400">10 Menit yang lalu</span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed mb-2">
                            Pesanan Cetak Banner Toko Anda dengan nomor invoice <span class="font-semibold text-gray-800">#INV-20260706</span> telah selesai diproduksi dan siap diambil di kasir.
                        </p>
                        <a href="{{ route('customer.pesanan') }}" class="inline-flex text-[11px] text-brandRed font-bold hover:underline items-center gap-1">
                            Lihat Detail Pesanan <i class="fa fa-arrow-right text-[9px]"></i>
                        </a>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-brandRed mt-2 flex-shrink-0"></span>
                </div>

                {{-- CONTOH NOTIFIKASI 2: PROMO (SUDAH DIBACA) --}}
                <div class="p-6 hover:bg-gray-50 transition flex gap-4 items-start">
                    <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-tags text-base"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="text-sm font-bold text-gray-800">Promo Spesial Bulan Ini! 🏷️</h3>
                            <span class="text-[11px] text-gray-400">Kemarin, 14:20</span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed mb-2">
                            Dapatkan diskon potongan cetak stiker kemasan hingga 20% khusus minggu ini tanpa minimal order. Yuk, tingkatkan branding jualanmu!
                        </p>
                        <a href="{{ route('customer.promo') }}" class="inline-flex text-[11px] text-brandRed font-bold hover:underline items-center gap-1">
                            Ambil Promo <i class="fa fa-arrow-right text-[9px]"></i>
                        </a>
                    </div>
                </div>

                {{-- CONTOH NOTIFIKASI 3: INFORMASI LAIN (SUDAH DIBACA) --}}
                <div class="p-6 hover:bg-gray-50 transition flex gap-4 items-start">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-info-circle text-base"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <h3 class="text-sm font-bold text-gray-800">Pengumuman Libur Idul Adha</h3>
                            <span class="text-[11px] text-gray-400">3 Hari lalu</span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Yth. Pelanggan Fantastic Digital Printing, toko kami akan libur operasional sementara pada tanggal 15-16 Juni 2026. Pesanan online tetap dibuka namun akan diproses saat toko buka kembali.
                        </p>
                    </div>
                </div>

            </div>

            {{-- 
            <div class="flex flex-col items-center justify-center py-16 px-4">
                <div class="w-20 h-20 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-4">
                    <i class="fa fa-bell-slash text-3xl"></i>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-1">Belum Ada Notifikasi</h3>
                <p class="text-xs text-gray-400 text-center max-w-xs">
                    Semua pemberitahuan seputar pesanan, info toko, dan promo cetak akan muncul di sini.
                </p>
            </div> 
            --}}

        </div>
    </div>
</div>
@endsection