@extends('layouts.admin')

@section('title', 'Dashboard - Fantastic Digital Printing')

<style>
    .fixed-table-container th, .fixed-table-container td {
        box-sizing: border-box !important;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .clean-pagination nav div:first-child {
        display: none !important;
    }
    .clean-pagination nav div:last-child {
        width: auto !important;
        display: flex !important;
        justify-content: flex-end !important;
    }
    .clean-pagination nav span, .clean-pagination nav a {
        box-shadow: none !important;
    }
</style>

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
        <div class="bg-white p-6 border border-red-300 rounded-2xl shadow-sm">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Total Pesanan</p>
            <h3 class="text-4xl font-bold text-gray-800 mt-2">{{ number_format($totalOrder ?? 0) }}</h3>
        </div>
        <div class="bg-white p-6 border border-red-300 rounded-2xl shadow-sm">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Produk</p>
            <h3 class="text-4xl font-bold text-gray-800 mt-2">{{ number_format($totalProduk ?? 0) }}</h3>
        </div>
        <div class="bg-white p-6 border border-red-300 rounded-2xl shadow-sm">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Pelanggan</p>
            <h3 class="text-4xl font-bold text-gray-800 mt-2">{{ number_format($totalPelanggan ?? 0) }}</h3>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-5 border border-red-300 rounded-2xl shadow-sm lg:col-span-2 overflow-x-auto overflow-y-hidden h-[380px] flex flex-col justify-between fixed-table-container">
            <div class="flex-grow min-h-[280px]">
                <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4">Pesanan Terbaru</h4>
                <table class="w-full text-left border-collapse text-xs table-fixed">
                    <thead>
                        <tr class="bg-red-50 text-red-700 font-bold border-b border-red-100 h-9">
                            <th class="p-2.5 w-[45px]">No</th>
                            <th class="p-2.5 w-[180px]">Order ID</th>
                            <th class="p-2.5 w-[150px]">Pelanggan</th>
                            <th class="p-2.5 w-[120px]">Total</th>
                            <th class="p-2.5 text-center w-[95px]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-600">
                        @forelse($latestOrders as $index => $order)
                        <tr class="h-[40px] hover:bg-gray-50/50 transition">
                            <td class="p-2.5">{{ $latestOrders->firstItem() + $index }}</td>
                            <td class="p-2.5 font-semibold text-gray-800">{{ $order->order_id ?? '#' . $order->id }}</td>
                            <td class="p-2.5">{{ $order->nama_pelanggan ?? ($order->user->name ?? 'Pelanggan') }}</td>
                            <td class="p-2.5 text-gray-800">Rp {{ number_format($order->total ?? $order->total_harga ?? 0, 0, ',', '.') }}</td>
                            <td class="p-2.5 text-center">
                                <span class="text-[10px] px-2.5 py-0.5 rounded-full font-bold inline-block w-20
                                    @if(in_array(strtolower($order->status), ['batal', 'dibatalkan'])) bg-red-100 text-red-700 
                                    @elseif(strtolower($order->status) == 'diproses') bg-amber-100 text-amber-700 
                                    @elseif(strtolower($order->status) == 'dicetak') bg-blue-100 text-blue-700 
                                    @else bg-green-100 text-green-700 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 italic">Belum ada pesanan terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 pt-2 border-t border-gray-50 flex items-center justify-between h-[40px] flex-shrink-0">
                @if($latestOrders->total() > 0)
                    <div class="text-[11px] text-gray-500 font-medium">
                        Showing <span class="font-bold text-gray-700">{{ $latestOrders->firstItem() }}</span> to <span class="font-bold text-gray-700">{{ $latestOrders->lastItem() }}</span> of <span class="font-bold text-gray-700">{{ $latestOrders->total() }}</span> results
                    </div>
                @else
                    <div class="text-[11px] text-gray-400 italic">
                        Showing 0 to 0 of 0 results
                    </div>
                @endif
                <div class="clean-pagination">
                    {{ $latestOrders->links() }}
                </div>
            </div>
        </div>
        <div class="bg-white p-5 border border-red-300 rounded-2xl shadow-sm h-[380px]">
            <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4">Status Pesanan</h4>
            <div class="w-full text-[11px] font-medium text-gray-600 space-y-3">
                @forelse($statusCounts as $label => $count)
                <div class="flex justify-between items-center border-b border-gray-50 pb-2 last:border-none last:pb-0">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full 
                            @if(in_array(strtolower($label), ['batal', 'dibatalkan'])) bg-red-500 
                            @elseif(strtolower($label) == 'diproses') bg-amber-500 
                            @elseif(strtolower($label) == 'dicetak') bg-blue-500 
                            @else bg-green-500 @endif">
                        </span>
                        <p class="capitalize text-gray-700 font-semibold">{{ $label }}</p> 
                    </div>
                    <span class="font-bold bg-gray-100 text-gray-800 px-2.5 py-0.5 rounded-md text-xs">{{ $count }}</span>
                </div>
                @empty
                <p class="text-center text-gray-400 italic py-4">Data status belum tersedia.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="bg-white p-5 border border-red-300 rounded-2xl shadow-sm w-full">
        <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4">Produk Terlaris</h4>
        @php
            $maxSold = $produkTerlaris->max('total_sold') ?: 1;
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-5 gap-6">
            @forelse($produkTerlaris as $produk)
            @php
                $percentage = min(100, round(($produk->total_sold / $maxSold) * 100));
            @endphp
            <div class="text-xs">
                <div class="flex justify-between font-semibold text-gray-700 mb-1.5">
                    <span class="truncate block max-w-[110px]" title="{{ $produk->name }}">{{ $loop->iteration }}. {{ $produk->name }}</span>
                    <span class="text-red-600 flex-shrink-0 font-bold">{{ $produk->total_sold }} Terjual</span>
                </div>
                <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-red-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
            @empty
            <div class="col-span-5 text-center text-gray-400 italic py-2">
                Belum ada data penjualan produk.
            </div>
            @endforelse
        </div>
    </div>
@endsection