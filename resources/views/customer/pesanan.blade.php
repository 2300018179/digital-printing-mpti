@extends('layouts.customer')

@section('title', 'Pesanan Saya - Fantastic Digital Printing')

@section('content')
<div class="max-w-[1350px] mx-auto px-[15px] w-full pt-4 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-receipt text-brandRed"></i> Pesanan Cetak
            </h1>
        </div>

        {{-- Filter Status --}}
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('customer.pesanan', ['status' => 'Diproses']) }}" class="px-4 py-2 text-xs font-bold rounded-full no-underline {{ (request('status') == 'Diproses' || !request()->has('status')) ? 'bg-brandRed text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }} transition">
                Diproses
            </a>
            
            <a href="{{ route('customer.pesanan', ['status' => 'Dicetak']) }}" class="px-4 py-2 text-xs font-bold rounded-full no-underline {{ request('status') == 'Dicetak' ? 'bg-brandRed text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }} transition">
                Dicetak
            </a>
            
            <a href="{{ route('customer.pesanan', ['status' => 'Selesai']) }}" class="px-4 py-2 text-xs font-bold rounded-full no-underline {{ request('status') == 'Selesai' ? 'bg-brandRed text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }} transition">
                Selesai
            </a>
            
            <a href="{{ route('customer.pesanan', ['status' => 'semua']) }}" class="px-4 py-2 text-xs font-bold rounded-full no-underline {{ request('status') == 'semua' ? 'bg-brandRed text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100' }} transition">
                Semua
            </a>
        </div>

        <div class="space-y-4">
            @forelse ($orders as $order)
                <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Header Card Invoice --}}
                    <div class="p-4 bg-gray-50 border-b border-gray-100 flex flex-wrap justify-between items-center gap-2 text-xs">
                        <div class="flex items-center gap-4 text-gray-500">
                            <span><strong class="text-gray-800">{{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('j M Y') }}</strong></span>
                            <span>No. Order: <strong class="text-gray-800 font-bold">#{{ $order->order_id }}</strong></span>
                            <span>Jumlah Produk: <strong class="text-gray-800">{{ $order->items->count() }} Item</strong></span>
                        </div>
                    </div>

                    {{-- Body Card Info Detail Produk Pertama --}}
                    @php
                        $itemPertama = $order->items->first();
                        $sisaProduk = $order->items->count() - 1;
                    @endphp

                    @if($itemPertama)
                    <div class="p-6 flex flex-col sm:flex-row justify-between items-center gap-4 border-b border-gray-50 last:border-none">
                        <div class="flex gap-4 items-center">
                            
                            {{-- Gambar Produk Pertama --}}
                            <div class="w-16 h-16 bg-gray-100 rounded-[12px] flex items-center justify-center overflow-hidden flex-shrink-0">
                                @if($itemPertama->product && $itemPertama->product->image)
                                    <img src="{{ asset('assets/products/' . $itemPertama->product->image) }}" 
                                         alt="{{ $itemPertama->nama_produk }}" 
                                         class="w-full h-full object-cover">
                                @elseif($itemPertama->product && $itemPertama->product->gambar) 
                                    <img src="{{ asset('assets/products/' . $itemPertama->product->gambar) }}" 
                                         alt="{{ $itemPertama->nama_produk }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="text-gray-400 flex items-center justify-center">
                                        <i class="fa fa-image text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Detail Produk Pertama --}}
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 mb-0.5">
                                    {{ $itemPertama->nama_produk ?? 'Produk Cetak' }}
                                </h3>
                                
                                <p class="text-xs text-gray-500 mb-1 line-clamp-1" title="{{ $itemPertama->keterangan }}">
                                    Jumlah: {{ $itemPertama->jumlah ?? 1 }} pcs {{ $itemPertama->keterangan ? '| '. \Illuminate\Support\Str::limit($itemPertama->keterangan, 70) : '' }}
                                </p>
                                
                                <p class="text-xs font-medium text-gray-600">Total Tagihan: 
                                    <span class="font-bold text-gray-800 font-harga">
                                        Rp {{ number_format($order->total ?? $order->grand_total, 0, ',', '.') }}
                                    </span>
                                    @if(isset($order->sisa_tagihan) && $order->sisa_tagihan > 0)
                                        <span class="ml-2 inline-block px-2 py-0.5 bg-amber-100 text-amber-800 text-[10px] font-bold rounded-md">
                                            Sisa DP: Rp {{ number_format($order->sisa_tagihan, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </p>

                                @if($sisaProduk > 0)
                                    <p class="text-xs text-brandRed font-bold mb-1">
                                        + {{ $sisaProduk }} produk lainnya
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Aksi Tombol & Status --}}
                        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                            <button type="button" onclick="toggleModal('modal-{{ $order->id }}')" 
                                    class="flex-1 sm:flex-none text-center px-4 py-2 border border-gray-200 text-gray-600 font-bold text-xs rounded-full hover:bg-gray-50 transition cursor-pointer">
                                Detail Nota
                            </button>

                            @if($order->status == 'Diproses')
                                <span class="flex-1 sm:flex-none text-center px-4 py-2 bg-amber-100 text-amber-700 font-bold text-xs rounded-full select-none min-w-[110px]">
                                    Diproses
                                </span>
                            @elseif($order->status == 'Dicetak')
                                <span class="flex-1 sm:flex-none text-center px-4 py-2 bg-blue-100 text-blue-700 font-bold text-xs rounded-full animate-pulse select-none min-w-[110px]">
                                    Sedang Dicetak
                                </span>
                            @elseif($order->status == 'Selesai')
                                <a href="{{ route('customer.semua-produk') }}" class="flex-1 sm:flex-none text-center px-4 py-2 border border-brandRed text-brandRed font-bold text-xs rounded-full hover:bg-red-50 transition no-underline min-w-[110px]">
                                    Order Lagi
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Include Subview Modal Detail Pesanan --}}
                @include('customer.detail-pesanan', ['order' => $order])

            @empty
                <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 py-16 px-4 flex flex-col items-center justify-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-4">
                        <i class="fa fa-shopping-basket text-3xl"></i>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800 mb-1">Belum Ada Transaksi</h3>
                    <p class="text-xs text-gray-400 text-center max-w-xs mb-4">Tidak ada pesanan dengan status ini.</p>
                    <a href="{{ route('customer.semua-produk') }}" class="px-6 py-2 bg-brandRed text-white text-xs font-bold rounded-full hover:bg-red-700 transition no-underline">Mulai Order Produk</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }
    }
</script>
@endsection