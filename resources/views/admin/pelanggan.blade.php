@extends('layouts.admin')

@section('title', 'Data Pelanggan - Fantastic Digital Printing')

@section('content')
{{-- Container Utama --}}
<div class="flex flex-col max-w-7xl space-y-6">

    {{-- Header Halaman --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">Data Pelanggan</h2>
        <p class="text-xs text-gray-500 mt-1">Melihat daftar pelanggan yang terdaftar dan riwayat total orderan mereka.</p>
    </div>

    {{-- Alert Notifikasi Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl text-xs font-semibold flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold ml-4">&times;</button>
        </div>
    @endif

    {{-- Input Pencarian dengan Vector Icon (SVG) & Border Merah --}}
    <form action="{{ route('admin.pelanggan') }}" method="GET" class="flex items-center max-w-md">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama, email, atau no. telp..." class="w-full pl-10 pr-4 py-2 bg-white border border-red-300 rounded-xl text-xs font-medium text-gray-700 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:ring-1 focus:ring-red-600 transition shadow-sm">
        </div>
    </form>

    {{-- Box Putih Tabel Pelanggan dengan Border Merah (border-red-300) --}}
    <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6 overflow-hidden flex flex-col justify-between">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-red-50 text-red-700 font-bold border-b border-red-100 h-19">
                        <th class="py-2.5 px-4 text-center w-14">No</th>
                        <th class="py-2.5 px-4">Nama</th>
                        <th class="py-2.5 px-4">Email</th>
                        <th class="py-2.5 px-4">No. Telp</th>
                        <th class="py-2.5 px-4 text-center w-32">Total Order</th>
                        <th class="py-2.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-600">
                    @forelse($pelanggan as $index => $user)
                    <tr class="hover:bg-gray-50 transition align-middle h-12">
                        {{-- Nomor Berlanjut --}}
                        <td class="py-2.5 px-4 text-center text-gray-400 font-semibold">
                            {{ $pelanggan->firstItem() + $index }}
                        </td>

                        {{-- Nama --}}
                        <td class="py-2.5 px-4 font-semibold text-gray-800 capitalize">
                            {{ strtolower($user->name) }}
                        </td>

                        {{-- Email --}}
                        <td class="py-2.5 px-4 text-gray-600">
                            {{ $user->email }}
                        </td>

                        {{-- No. Telp --}}
                        <td class="py-2.5 px-4 text-gray-500 font-mono text-xs">
                            {{ $user->phone ?? '-' }}
                        </td>

                        {{-- Total Order --}}
                        <td class="py-2.5 px-4 text-center">
                            <span class="inline-block px-2.5 py-0.5 bg-gray-100 text-gray-800 font-bold rounded-md">
                                {{ $user->pesanan_count ?? 0 }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="py-2.5 px-4 text-center">
                            <a href="{{ route('admin.pelanggan.show', $user->id) }}" 
                               class="inline-block px-4 py-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white text-gray-700 rounded-lg text-[11px] font-bold shadow-sm transition active:scale-95">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 px-4 text-center text-gray-400 italic">
                            Tidak ada data pelanggan tersedia.
                        </td>
                    </tr>
                    @endforelse

                    {{-- DUMMY ROWS (Tinggi Tetap Konsisten & Tanpa Garis Pembatas) --}}
                    @php
                        $rowCount = count($pelanggan);
                        $maxRows = 5;
                    @endphp

                    @if($rowCount > 0 && $rowCount < $maxRows)
                        @for($i = 0; $i < ($maxRows - $rowCount); $i++)
                        <tr class="h-12 pointer-events-none" style="border: none !important;">
                            <td colspan="6" class="py-2.5 px-4" style="border: none !important;">&nbsp;</td>
                        </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Area Pagination Otomatis --}}
        @if($pelanggan->hasPages() || $pelanggan->total() > 0)
        <div class="flex flex-col sm:flex-row justify-between items-center pt-4 mt-2 border-t border-gray-100 text-xs text-gray-500 gap-3">
            <div>
                Showing <span class="font-semibold text-gray-700">{{ $pelanggan->firstItem() ?? 0 }}</span> 
                to <span class="font-semibold text-gray-700">{{ $pelanggan->lastItem() ?? 0 }}</span> 
                of <span class="font-semibold text-gray-700">{{ $pelanggan->total() }}</span> results
            </div>

            @if($pelanggan->hasPages())
            <div class="inline-flex rounded-lg border border-gray-200 overflow-hidden bg-white shadow-sm">
                {{-- Tombol Previous --}}
                @if ($pelanggan->onFirstPage())
                    <span class="px-3 py-1.5 text-gray-300 border-r border-gray-200 cursor-not-allowed flex items-center">&lsaquo;</span>
                @else
                    <a href="{{ $pelanggan->previousPageUrl() }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r border-gray-200 transition flex items-center">&lsaquo;</a>
                @endif

                {{-- Angka Halaman --}}
                @foreach ($pelanggan->getUrlRange(1, $pelanggan->lastPage()) as $page => $url)
                    @if ($page == $pelanggan->currentPage())
                        <span class="px-3 py-1.5 bg-gray-100 font-bold text-gray-800 border-r last:border-r-0 border-gray-200 flex items-center">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r last:border-r-0 border-gray-200 transition flex items-center">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Tombol Next --}}
                @if ($pelanggan->hasMorePages())
                    <a href="{{ $pelanggan->nextPageUrl() }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 transition flex items-center">&rsaquo;</a>
                @else
                    <span class="px-3 py-1.5 text-gray-300 cursor-not-allowed flex items-center">&rsaquo;</span>
                @endif
            </div>
            @endif
        </div>
        @endif
    </div>

</div>
@endsection