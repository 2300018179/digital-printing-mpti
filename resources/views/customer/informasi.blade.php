@extends('layouts.customer')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <nav class="text-sm font-medium text-gray-500 mb-2">
                <a href="{{ route('customer.dashboard') }}" class="hover:text-brandRed">Home</a> &gt; 
                <span class="text-gray-800">Informasi Terbaru</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                <i class="fa fa-info-circle text-brandRed"></i> Informasi & Pengumuman Toko
            </h1>
        </div>

        <div class="space-y-6">

            {{-- INFORMASI 1: PENTING / OPERASIONAL TOKO --}}
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300">
                <div class="p-6">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="px-2.5 py-1 bg-red-100 text-brandRed text-[10px] font-bold rounded-full uppercase tracking-wider">Penting</span>
                        <span class="text-xs text-gray-400 font-medium">Diposting pada: 6 Juli 2026</span>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 mb-2 hover:text-brandRed transition">
                        Pemberitahuan Jadwal Perawatan Mesin Cetak Outdoor (Maintenance)
                    </h2>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Yth. Pelanggan Fantastic Digital Printing, kami ingin menginformasikan bahwa akan dilakukan perawatan berkala (maintenance) pada mesin cetak Large Format kami pada hari Sabtu besok. Untuk pesanan spanduk/banner berukuran besar kemungkinan akan mengalami sedikit keterlambatan pengerjaan selama 1x24 jam.
                    </p>
                    <div class="border-t border-gray-100 pt-4 flex justify-between items-center text-xs text-gray-500">
                        <span>Oleh: Admin Utama</span>
                        <span class="font-semibold text-brandRed">Mesin Aktif Kembali: Senin, 8 Juli</span>
                    </div>
                </div>
            </div>

            {{-- INFORMASI 2: TIPS & TRICKS DESAIN --}}
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300">
                <div class="p-6">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full uppercase tracking-wider">Edukasi</span>
                        <span class="text-xs text-gray-400 font-medium">Diposting pada: 3 Juli 2026</span>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 mb-2 hover:text-brandRed transition">
                        Tips Menyiapkan File Cetak Agar Tidak Pecah (Gunakan Mode Warna CMYK)
                    </h2>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Seringkali hasil cetakan berbeda warna dengan layar HP? Pastikan file desain brosur atau stiker kamu sudah diatur menggunakan format warna CMYK sebelum dikirim ke tim desainer kami, bukan RGB. Selain itu, pastikan resolusi minimal file adalah 300 DPI agar gambar tetap tajam saat dicetak.
                    </p>
                    <div class="border-t border-gray-100 pt-4 flex justify-between items-center text-xs text-gray-500">
                        <span>Oleh: Tim Kreatif</span>
                        <a href="#" class="font-bold text-brandRed hover:underline flex items-center gap-1">Baca Selengkapnya <i class="fa fa-chevron-right text-[9px]"></i></a>
                    </div>
                </div>
            </div>

        </div>

        {{-- JIKA DATA PENGUMUMAN KOSONG --}}
        {{-- 
        <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 py-16 px-4 flex flex-col items-center justify-center">
            <div class="w-20 h-20 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-4">
                <i class="fa fa-folder-open text-3xl"></i>
            </div>
            <h3 class="text-sm font-bold text-gray-800 mb-1">Belum Ada Informasi Baru</h3>
            <p class="text-xs text-gray-400 text-center max-w-xs">Hubungi kami via kontak jika ada pertanyaan seputar operasional toko.</p>
        </div> 
        --}}

    </div>
</div>
@endsection