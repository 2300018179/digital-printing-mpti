{{-- MODAL POPUP DETAIL NOTA PESANAN --}}
<div id="modal-{{ $order->id }}" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    {{-- Background Overlay --}}
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-xs" 
             onclick="toggleModal('modal-{{ $order->id }}')" 
             aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Card Modal --}}
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            
            {{-- Header Modal --}}
            <div class="px-6 py-4 border-b border-gray-150 flex justify-between items-center bg-gray-50">
                <div class="text-left">
                    <h3 class="text-base font-bold text-gray-900 mb-0">Detail Nota Pesanan</h3>
                    <p class="text-xs text-gray-500 mb-0">No. Order: <span class="font-mono text-brandRed font-semibold">#{{ $order->order_id }}</span></p>
                </div>
            </div>

            {{-- Body Modal (Scrollbar di-hide pakai style inline & class no-scrollbar) --}}
            <div class="px-6 py-4 space-y-4 max-h-[60vh] overflow-y-auto text-left [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                
                {{-- Status & Tanggal --}}
                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-3 rounded-xl border border-gray-100 text-xs">
                    <div>
                        <span class="text-gray-500 block text-[10px] uppercase tracking-wider mb-0.5">Tanggal Pesan</span>
                        <strong class="text-gray-800">{{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('j M Y') }}</strong>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-[10px] uppercase tracking-wider mb-0.5">Status</span>
                        @if($order->status == 'Diproses')
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold text-amber-700 bg-amber-100 rounded-full">
                                Diproses
                            </span>
                        @elseif($order->status == 'Dicetak')
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold text-blue-700 bg-blue-100 rounded-full">
                                Sedang Dicetak
                            </span>
                        @elseif($order->status == 'Selesai')
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold text-green-700 bg-green-100 rounded-full">
                                Selesai
                            </span>
                        @endif
                    </div>
                </div>

                {{-- List Item Produk --}}
                <div>
                    <h4 class="font-bold text-gray-900 text-xs uppercase tracking-wider mb-3">Item yang Dipesan:</h4>
                    <div class="space-y-3">
                        @foreach($order->items as $detail)
                        <div class="flex items-start justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                            <div class="flex gap-3">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden border border-gray-200">
                                    @if($detail->product && $detail->product->image)
                                        <img src="{{ asset('assets/products/' . $detail->product->image) }}" class="w-full h-full object-cover">
                                    @elseif($detail->product && $detail->product->gambar)
                                        <img src="{{ asset('assets/products/' . $detail->product->gambar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                                            <i class="fa fa-image text-sm"></i>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <h5 class="text-xs font-bold text-gray-900 mb-0.5">{{ $detail->nama_produk }}</h5>
                                    <p class="text-[11px] text-gray-500 mb-0">{{ $detail->jumlah }} pcs x Rp {{ number_format($detail->harga, 0, ',', '.') }}</p>
                                    
                                    @if($detail->keterangan)
                                        <span class="text-[10px] bg-red-50 text-brandRed px-2 py-0.5 rounded-md inline-block mt-1 font-medium">
                                            Catatan: {{ $detail->keterangan }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <span class="text-xs font-bold text-gray-900">
                                Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <hr class="border-gray-100 my-2">

                {{-- Total Pembayaran --}}
                <div class="flex justify-between items-center bg-red-50 p-4 rounded-xl border border-red-100">
                    <span class="text-xs font-bold text-red-900 uppercase tracking-wider">Total Tagihan:</span>
                    <span class="text-base font-black text-brandRed">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>

                {{-- SECTION FILE / LINK DESAIN --}}
                <div class="space-y-1.5 text-left pt-2">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">File / Link Desain Cetak:</span>
                    
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-xl space-y-2">
                        @php $adaDesain = false; @endphp
                        @foreach($order->items as $item)
                            @if($item->file_desain || $item->link_desain)
                                @php $adaDesain = true; @endphp
                                <div class="text-xs border-b border-gray-200 pb-2 last:border-0 last:pb-0">
                                    <p class="font-bold text-gray-800 mb-1 text-[11px]">{{ $item->nama_produk }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @if($item->file_desain)
                                            <a href="{{ asset('assets/file_desain/' . $item->file_desain) }}" target="_blank" download class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-gray-300 rounded-lg text-blue-600 font-semibold text-[11px] hover:bg-blue-50 transition no-underline shadow-xs">
                                                <i class="fa fa-download text-blue-500"></i> Download File ({{ Str::limit($item->file_desain, 20) }})
                                            </a>
                                        @endif

                                        @if($item->link_desain)
                                            <a href="{{ $item->link_desain }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-gray-300 rounded-lg text-purple-600 font-semibold text-[11px] hover:bg-purple-50 transition no-underline shadow-xs">
                                                <i class="fa fa-link text-purple-500"></i> Buka Link Desain
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if(!$adaDesain)
                            <p class="text-xs text-gray-400 italic text-center mb-0">Tidak ada file/link desain yang dilampirkan.</p>
                        @endif
                    </div>
                </div>

                {{-- SECTION BUKTI TRANSFER PEMBAYARAN --}}
                <div class="space-y-1.5 text-left pt-2">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Bukti Transfer Pembayaran:</span>
                    
                    @if($order->bukti_transfer)
                        <div class="border border-gray-200 rounded-xl overflow-hidden p-2 bg-gray-50 flex flex-col items-center gap-2">
                            <a href="{{ asset('assets/bukti_transfer/' . $order->bukti_transfer) }}" target="_blank" title="Klik untuk memperbesar">
                                <img src="{{ asset('assets/bukti_transfer/' . $order->bukti_transfer) }}" 
                                     alt="Bukti Transfer" 
                                     class="max-h-48 rounded-lg object-contain hover:opacity-90 transition cursor-zoom-in">
                            </a>
                            <span class="text-[10px] text-gray-400 italic"><i class="fa fa-search-plus mr-1"></i> Klik gambar untuk melihat ukuran penuh</span>
                        </div>
                    @else
                        <div class="p-3 bg-gray-50 border border-dashed border-gray-200 rounded-xl text-center">
                            <p class="text-xs text-gray-400 italic mb-0">Belum ada bukti transfer yang diunggah.</p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- Footer Modal --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-150 flex justify-end">
                <button type="button" onclick="toggleModal('modal-{{ $order->id }}')" 
                        class="px-5 py-2 text-xs font-bold text-gray-600 bg-white border border-gray-300 rounded-full hover:bg-gray-100 transition cursor-pointer">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>