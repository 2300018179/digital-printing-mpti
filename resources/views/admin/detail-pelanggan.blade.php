@extends('layouts.admin')

@section('title', 'Detail Pelanggan - Fantastic Digital Printing')

@section('content')
<div class="flex flex-col max-w-7xl space-y-6">

    {{-- Header Halaman --}}
    <div class="border-b border-gray-200 pb-3">
        <h2 class="text-xl font-bold text-gray-800">Profil & Riwayat Pelanggan</h2>
        <p class="text-xs text-gray-500 mt-0.5">Informasi akun mendalam beserta history transaksi cetak.</p>
    </div>

    {{-- Grid Profil & Riwayat Pesanan --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Card Informasi Pelanggan --}}
        <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6 space-y-4 h-fit">
            <div class="flex flex-col items-center border-b border-gray-100 pb-4">
                <div class="w-20 h-20 bg-red-50 text-red-700 rounded-full flex items-center justify-center border-2 border-red-200 text-3xl font-bold mb-3">
                    {{ substr($pelanggan->name, 0, 1) }}
                </div>
                <h3 class="text-sm font-bold text-gray-800">{{ $pelanggan->name }}</h3>
                <span class="px-2.5 py-0.5 bg-green-50 border border-green-200 text-green-600 rounded-full text-[10px] font-bold mt-1">
                    Pelanggan
                </span>
            </div>

            <div class="space-y-4 text-xs">
                <div>
                    <span class="text-gray-400 block uppercase font-bold tracking-wider">Email</span>
                    <span class="text-gray-700 font-semibold">{{ $pelanggan->email }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block uppercase font-bold tracking-wider">Telepon</span>
                    <span class="text-gray-700 font-mono font-semibold">{{ $pelanggan->phone ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Card Log Riwayat Pesanan dengan Pagination --}}
        <div class="lg:col-span-2 bg-white border border-red-300 rounded-2xl shadow-sm p-6 overflow-hidden flex flex-col justify-between">
            <div>
                <div class="pb-3 border-b border-gray-100 flex justify-between items-center mb-4">
                    <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Log Riwayat Pesanan</h4>
                    <span class="px-2.5 py-1 bg-red-700 text-white rounded-lg text-[10px] font-bold">
                        Total: {{ $pesanan->total() }} Pesanan
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead class="bg-gray-50 text-gray-400 uppercase text-[9px] font-bold border-b border-gray-100 h-10">
                            <tr>
                                <th class="p-3.5 text-center w-12">No</th>
                                <th class="p-3.5">ID Pesanan</th>
                                <th class="p-3.5">Total Bayar</th>
                                <th class="p-3.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700 font-medium">
                            @forelse($pesanan as $index => $item)
                                <tr class="hover:bg-gray-50 transition h-11 align-middle">
                                    <td class="p-3.5 text-center text-gray-400">
                                        {{ $pesanan->firstItem() + $index }}
                                    </td>
                                    <td class="p-3.5 font-mono font-bold text-red-700">
                                        {{ $item->order_id ?? '#' . $item->id }}
                                    </td>
                                    <td class="p-3.5 font-bold">
                                        Rp {{ number_format($item->total ?? $item->total_harga ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3.5 text-center">
                                        @php
                                            $status = strtolower($item->status ?? 'diproses');
                                            $badgeClass = match($status) {
                                                'selesai' => 'bg-green-50 text-green-600 border-green-200',
                                                'dicetak' => 'bg-blue-50 text-blue-600 border-blue-200',
                                                default   => 'bg-orange-50 text-orange-600 border-orange-200', // Diproses
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 border rounded-full text-[10px] font-bold uppercase {{ $badgeClass }}">
                                            {{ $item->status ?? 'Diproses' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-6 text-center text-gray-400 italic">
                                        Belum ada riwayat pesanan.
                                    </td>
                                </tr>
                            @endforelse

                            {{-- DUMMY ROWS UNTUK MENGUNCI TINGGI TABEL (5 BARIS KONSISTEN) --}}
                            @php
                                $rowCount = count($pesanan);
                                $maxRows = 5;
                            @endphp
                            @if($rowCount > 0 && $rowCount < $maxRows)
                                @for($i = 0; $i < ($maxRows - $rowCount); $i++)
                                <tr class="h-11 border-b border-transparent pointer-events-none">
                                    <td colspan="4" class="p-3.5">&nbsp;</td>
                                </tr>
                                @endfor
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Area Pagination Otomatis --}}
            @if($pesanan->hasPages() || $pesanan->total() > 0)
            <div class="flex flex-col sm:flex-row justify-between items-center pt-4 mt-4 border-t border-gray-100 text-xs text-gray-500 gap-3">
                <div>
                    Showing <span class="font-semibold text-gray-700">{{ $pesanan->firstItem() ?? 0 }}</span> 
                    to <span class="font-semibold text-gray-700">{{ $pesanan->lastItem() ?? 0 }}</span> 
                    of <span class="font-semibold text-gray-700">{{ $pesanan->total() }}</span> results
                </div>

                @if($pesanan->hasPages())
                <div class="inline-flex rounded-lg border border-gray-200 overflow-hidden bg-white shadow-sm">
                    {{-- Tombol Previous --}}
                    @if ($pesanan->onFirstPage())
                        <span class="px-3 py-1.5 text-gray-300 border-r border-gray-200 cursor-not-allowed flex items-center">&lsaquo;</span>
                    @else
                        <a href="{{ $pesanan->previousPageUrl() }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r border-gray-200 transition flex items-center">&lsaquo;</a>
                    @endif

                    {{-- Angka Halaman --}}
                    @foreach ($pesanan->getUrlRange(1, $pesanan->lastPage()) as $page => $url)
                        @if ($page == $pesanan->currentPage())
                            <span class="px-3 py-1.5 bg-gray-100 font-bold text-gray-800 border-r last:border-r-0 border-gray-200 flex items-center">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r last:border-r-0 border-gray-200 transition flex items-center">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($pesanan->hasMorePages())
                        <a href="{{ $pesanan->nextPageUrl() }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 transition flex items-center">&rsaquo;</a>
                    @else
                        <span class="px-3 py-1.5 text-gray-300 cursor-not-allowed flex items-center">&rsaquo;</span>
                    @endif
                </div>
                @endif
            </div>
            @endif
        </div>

    </div>

</div>
@endsection