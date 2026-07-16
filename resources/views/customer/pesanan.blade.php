@extends('layouts.customer') {{-- Sesuaikan dengan nama master layout kamu --}}

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <nav class="text-sm font-medium text-gray-500 mb-2">
                <a href="{{ route('customer.dashboard') }}" class="hover:text-brandRed">Home</a> &gt; 
                <span class="text-gray-800">Pesanan Saya</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                <i class="fa fa-shopping-bag text-brandRed"></i> Riwayat Pesanan Cetak
            </h1>
        </div>

        <div class="flex flex-wrap gap-2 mb-6">
            <button class="px-4 py-2 text-xs font-bold rounded-full bg-brandRed text-white shadow-sm">Semua</button>
            <button class="px-4 py-2 text-xs font-semibold rounded-full bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 transition">Belum Bayar</button>
            <button class="px-4 py-2 text-xs font-semibold rounded-full bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 transition">Sedang Diproses</button>
            <button class="px-4 py-2 text-xs font-semibold rounded-full bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 transition">Selesai</button>
            <button class="px-4 py-2 text-xs font-semibold rounded-full bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 transition">Dibatalkan</button>
        </div>

        <div class="space-y-4">

            {{-- CONTOH PESANAN 1: SEDANG DIPROSES / DICETAK --}}
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b border-gray-100 flex flex-wrap justify-between items-center gap-2 text-xs">
                    <div class="flex items-center gap-4 text-gray-500">
                        <span><strong class="text-gray-800">6 Juli 2026</strong></span>
                        <span>No. Invoice: <strong class="text-gray-800">#INV-98231</strong></span>
                        <span>Produk: <strong class="text-gray-800">Banner / Spanduk</strong></span>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-2 py-1 bg-green-100 text-green-700 font-bold rounded-[5px] text-[10px]">Pembayaran: Lunas</span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 font-bold rounded-[5px] text-[10px] animate-pulse">Produksi: Sedang Dicetak</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex gap-4 items-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-[12px] flex items-center justify-center text-gray-400">
                            <i class="fa fa-image text-2xl"></i> {{-- Bisa diganti img thumbnail file mockup custom user --}}
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 mb-0.5">Cetak Spanduk Toko Sembako</h3>
                            <p class="text-xs text-gray-500 mb-1">Ukuran: 3x1 meter | Bahan: Flexi Korea 340gr</p>
                            <p class="text-xs font-bold text-gray-800">Total Tagihan: Rp 135.000</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                        <a href="#" class="flex-1 sm:flex-none text-center px-4 py-2 border border-gray-200 text-gray-600 font-bold text-xs rounded-full hover:bg-gray-50 transition text-none">
                            Detail Nota
                        </a>
                        <a href="#" class="flex-1 sm:flex-none text-center px-4 py-2 bg-brandRed text-white font-bold text-xs rounded-full hover:bg-red-700 transition text-none">
                            Hubungi Desainer
                        </a>
                    </div>
                </div>
            </div>

            {{-- CONTOH PESANAN 2: BELUM BAYAR (MENUNGGU PEMBAYARAN) --}}
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b border-gray-100 flex flex-wrap justify-between items-center gap-2 text-xs">
                    <div class="flex items-center gap-4 text-gray-500">
                        <span><strong class="text-gray-800">5 Juli 2026</strong></span>
                        <span>No. Invoice: <strong class="text-gray-800">#INV-98112</strong></span>
                        <span>Produk: <strong class="text-gray-800">Stiker Kemasan</strong></span>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-2 py-1 bg-amber-100 text-amber-700 font-bold rounded-[5px] text-[10px]">Menunggu Pembayaran</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-500 font-bold rounded-[5px] text-[10px]">Produksi: Tertunda</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex gap-4 items-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-[12px] flex items-center justify-center text-gray-400">
                            <i class="fa fa-tags text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 mb-0.5">Cetak Stiker Label Kue @100 pcs</h3>
                            <p class="text-xs text-gray-500 mb-1">Bahan: Stiker Bontax | Potong: Kiss-Cut Bulat</p>
                            <p class="text-xs font-bold text-brandRed">Total Tagihan: Rp 75.000</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                        <a href="#" class="flex-1 sm:flex-none text-center px-5 py-2 bg-amber-500 text-white font-bold text-xs rounded-full hover:bg-amber-600 transition text-none">
                            Bayar Sekarang
                        </a>
                    </div>
                </div>
            </div>

            {{-- CONTOH PESANAN 3: SELESAI --}}
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b border-gray-100 flex flex-wrap justify-between items-center gap-2 text-xs">
                    <div class="flex items-center gap-4 text-gray-500">
                        <span><strong class="text-gray-800">28 Juni 2026</strong></span>
                        <span>No. Invoice: <strong class="text-gray-800">#INV-97400</strong></span>
                        <span>Produk: <strong class="text-gray-800">Kartu Nama</strong></span>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-2 py-1 bg-green-100 text-green-700 font-bold rounded-[5px] text-[10px]">Pembayaran: Lunas</span>
                        <span class="px-2 py-1 bg-green-100 text-green-700 font-bold rounded-[5px] text-[10px]">Selesai / Diambil</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex gap-4 items-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-[12px] flex items-center justify-center text-gray-400">
                            <i class="fa fa-id-card text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 mb-0.5">Cetak Kartu Nama Bisnis - 2 Box</h3>
                            <p class="text-xs text-gray-500 mb-1">Bahan: Art Paper 260gr | Laminasi: Doff 2 Sisi</p>
                            <p class="text-xs font-bold text-gray-800">Total Tagihan: Rp 90.000</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                        <a href="{{ route('customer.semua-produk') }}" class="flex-1 sm:flex-none text-center px-4 py-2 border border-brandRed text-brandRed font-bold text-xs rounded-full hover:bg-red-50 transition text-none">
                            Order Lagi
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- JIKA RIWAYAT KOSONG --}}
        {{-- 
        <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 py-16 px-4 flex flex-col items-center justify-center">
            <div class="w-20 h-20 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-4">
                <i class="fa fa-shopping-basket text-3xl"></i>
            </div>
            <h3 class="text-sm font-bold text-gray-800 mb-1">Belum Ada Transaksi</h3>
            <p class="text-xs text-gray-400 text-center max-w-xs mb-4">Anda belum memiliki riwayat pesanan cetak apapun.</p>
            <a href="{{ route('customer.semua-produk') }}" class="px-6 py-2 bg-brandRed text-white text-xs font-bold rounded-full hover:bg-red-700 transition text-none">Mulai Order Produk</a>
        </div> 
        --}}

    </div>
</div>
@endsection