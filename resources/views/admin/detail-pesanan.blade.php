@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . ($pesanan->order_id ?? 'N/A') . ' - Fantastic Digital Printing')

@section('content')
{{-- Container Utama --}}
<div class="flex flex-col max-w-7xl space-y-6">
    {{-- Alert Error / Flash Message --}}
    @if(session('error'))
        <div class="p-4 bg-red-100 border border-red-400 text-red-700 text-xs rounded-xl font-bold flex items-center justify-between">
            <span>⚠️ {{ session('error') }}</span>
        </div>
    @endif

    @if(session('success'))
        <div class="p-4 bg-green-100 border border-green-400 text-green-700 text-xs rounded-xl font-bold flex items-center justify-between">
            <span>✅ {{ session('success') }}</span>
        </div>
    @endif

    {{-- Header Halaman --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">
            Detail Pesanan <span class="font-mono text-red-700">#{{ $pesanan->order_id }}</span>
        </h2>
        <p class="text-xs text-gray-500 mt-1">Lihat rincian cetakan, file desain, dan kelola status pesanan.</p>
    </div>

    {{-- Grid Layout Utama --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri (2/3): Item Cetakan & File Desain --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Box Item Cetakan --}}
            <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-xs font-bold text-red-700 uppercase tracking-wider border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        Item Cetakan
                    </h3>

                    <div class="divide-y divide-gray-100">
                        @forelse($pesanan->items as $item)
                            <div class="flex justify-between items-center py-3.5 hover:bg-gray-50/50 px-2 rounded-lg transition">
                                <div>
                                    <h4 class="text-xs font-bold text-gray-800">{{ $item->nama_produk }}</h4>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Jumlah: {{ $item->jumlah ?? 1 }} pcs</p>
                                </div>
                                <p class="text-xs font-bold text-gray-800">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        @empty
                            <div class="py-8 text-center text-gray-400 text-xs italic">
                                Tidak ada item cetakan dalam pesanan ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Total --}}
                <div class="border-t border-gray-100 pt-4 mt-6 flex justify-between items-center">
                    <span class="text-xs font-bold text-gray-500 uppercase">Total Pembayaran</span>
                    <span class="text-base font-bold text-red-700">
                        Rp {{ number_format($pesanan->total ?? $pesanan->items->sum('harga'), 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Box File / Link Desain Cetakan & Catatan --}}
            <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6">
                <h3 class="text-xs font-bold text-red-700 uppercase tracking-wider border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                    </svg>
                    File / Link Desain & Catatan Cetak
                </h3>

                <div class="space-y-4">
                    @php $hasFiles = false; @endphp

                    @foreach($pesanan->items as $item)
                        @if(!empty($item->file_desain) || !empty($item->link_desain) || (!empty($item->keterangan) && $item->keterangan !== '-'))
                            @php $hasFiles = true; @endphp
                            
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 space-y-3">
                                <div class="border-b border-gray-200 pb-2">
                                    <span class="text-xs font-bold text-gray-800">{{ $item->nama_produk }}</span>
                                </div>

                                {{-- Jika Ada Catatan / Keterangan --}}
                                @if(!empty($item->keterangan) && $item->keterangan !== '-')
                                    <div class="text-xs text-gray-600 bg-white p-2.5 rounded-lg border border-gray-100">
                                        <span class="font-semibold text-gray-500 block text-[10px] uppercase">Catatan Pelanggan:</span>
                                        {{ $item->keterangan }}
                                    </div>
                                @endif

                                {{-- Skenario A: Jika berupa Link Google Drive / Cloud --}}
                                @if(!empty($item->link_desain))
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 pt-1">
                                        <div class="overflow-hidden">
                                            <p class="text-[10px] font-semibold text-gray-400 uppercase">Link Cloud / Drive:</p>
                                            <a href="{{ $item->link_desain }}" target="_blank" class="text-xs font-bold text-blue-600 hover:underline truncate block max-w-md">
                                                {{ $item->link_desain }}
                                            </a>
                                        </div>
                                        <a href="{{ $item->link_desain }}" target="_blank" 
                                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-lg transition shadow-sm active:scale-95 flex items-center gap-1.5 whitespace-nowrap">
                                            <span>Buka Link</span> &rarr;
                                        </a>
                                    </div>
                                @endif

                                {{-- Skenario B: Jika berupa Unggahan File --}}
                                @if(!empty($item->file_desain))
                                    <div class="flex items-center justify-between pt-1">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 bg-red-100 text-red-600 rounded-lg flex items-center justify-center font-bold text-[10px]">
                                                FILE
                                            </div>
                                            <div class="overflow-hidden">
                                                <p class="text-xs font-bold text-gray-800 truncate max-w-xs">{{ basename($item->file_desain) }}</p>
                                                <p class="text-[10px] text-gray-400">Siap Cetak</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.pesanan.downloadDesain', $item->id) }}" 
                                        class="px-4 py-2 bg-red-700 hover:bg-red-800 text-white font-bold text-xs rounded-lg transition shadow-sm active:scale-95 flex items-center gap-1.5 whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                            Unduh File
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    @if(!$hasFiles)
                        <div class="p-4 bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs rounded-xl italic">
                            Pelanggan tidak melampirkan file atau link desain untuk pesanan ini.
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Kolom Kanan (1/3): Kelola Status & Pelunasan Terpadu --}}
        <div class="space-y-6">
            <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6">
                <h3 class="text-xs font-bold text-red-700 uppercase tracking-wider border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 1-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 1-3 0M3.75 18H7.5m9-6h2.25m-2.25 0a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 1-3 0M3.75 12h8.25" />
                    </svg>
                    Kelola Status & Pembayaran
                </h3>

                <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT') 

                    {{-- Status Pesanan --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2">Status Pesanan saat ini:</label>
                        @php $currStatus = strtolower($pesanan->status); @endphp
                        <select name="status" 
                                class="w-full border border-gray-300 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-gray-50 transition cursor-pointer">
                            <option value="Diproses" {{ $currStatus == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Dicetak" {{ $currStatus == 'dicetak' ? 'selected' : '' }}>Dicetak</option>
                            <option value="Selesai" {{ $currStatus == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Batal" {{ in_array($currStatus, ['batal', 'ditolak']) ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>

                    {{-- Info & Pelunasan Khusus Pembayaran DP --}}
                    @if(($pesanan->tipe_pembayaran ?? '') === 'dp')
                        <div class="border-t border-gray-100 pt-4 mt-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-700">Status DP:</span>
                                @if($pesanan->status_pelunasan === 'lunas')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] bg-green-100 text-green-700 font-bold border border-green-200">
                                        LUNAS
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] bg-amber-100 text-amber-800 font-bold border border-amber-200">
                                        BELUM LUNAS
                                    </span>
                                @endif
                            </div>

                            @php
                                $sisaTagihan = $pesanan->total - ($pesanan->nominal_dibayar ?? ($pesanan->total / 2));
                            @endphp

                            {{-- BILA SUDAH LUNAS: Hanya Tampilkan Info & Link Bukti Transfer --}}
                            @if($pesanan->status_pelunasan === 'lunas')
                                <div class="bg-green-50 border border-green-200 p-3 rounded-xl text-xs text-green-800">
                                    <p class="font-semibold"> Tagihan Telah Dilunasi</p>
                                    @if($pesanan->bukti_pelunasan)
                                        <a href="{{ asset('assets/bukti_pelunasan/' . $pesanan->bukti_pelunasan) }}" target="_blank" 
                                        class="mt-2 text-[11px] font-bold text-green-700 underline hover:text-green-900 block">
                                            Lihat Bukti Transfer Pelunasan &rarr;
                                        </a>
                                    @endif
                                </div>
                            
                            {{-- BILA BELUM LUNAS: Tampilkan Input Upload Bukti --}}
                            @else
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 space-y-2">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-gray-500 font-semibold">Sisa Tagihan:</span>
                                        <span class="font-extrabold text-red-700">Rp {{ number_format(max(0, $sisaTagihan), 0, ',', '.') }}</span>
                                    </div>

                                    <div class="pt-2 border-t border-gray-200">
                                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">
                                            Upload Bukti Pelunasan <span class="text-gray-400 font-normal">(Opsional)</span>:
                                        </label>
                                        <input type="file" name="bukti_pelunasan" accept="image/*"
                                            class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 border border-gray-200 rounded-xl bg-white cursor-pointer transition">
                                        <p class="text-[9px] text-gray-400 mt-1">Mengunggah file otomatis mengubah status menjadi LUNAS.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <button type="submit" 
                            class="w-full bg-red-700 hover:bg-red-800 text-white font-bold text-xs py-3 rounded-xl shadow-md transition active:scale-95 flex items-center justify-center gap-2 cursor-pointer mt-4">
                        Simpan Status
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>

{{-- ================= MODAL KONFIRMASI (TEMA MERAH) ================= --}}
<div id="modalPelunasan" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-sm w-full mx-4 shadow-2xl text-center transform scale-95 transition-transform duration-300">
        
        {{-- Circle Icon Merah --}}
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8 text-red-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
        </div>

        {{-- Judul Modal --}}
        <h3 class="text-base font-bold text-gray-800 mb-2">Setujui Pelunasan?</h3>
        
        {{-- Deskripsi Modal --}}
        <p class="text-xs text-gray-500 mb-6 leading-relaxed">
            Apakah Anda yakin ingin menyetujui pelunasan untuk order <span class="font-bold text-gray-700">#{{ $pesanan->order_id }}</span>? Status pelunasan akan diubah menjadi <span class="font-bold text-green-600">Lunas</span>.
        </p>

        {{-- Action Buttons --}}
        <div class="grid grid-cols-2 gap-3">
            <button type="button" onclick="closeModalPelunasan()" 
                    class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="submitPelunasanForm()" 
                    class="w-full py-2.5 bg-red-700 hover:bg-red-800 text-white font-bold text-xs rounded-xl shadow-md transition active:scale-95 cursor-pointer">
                Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

{{-- Script Pengendali Modal --}}
<script>
    function openModalPelunasan() {
        const fileInput = document.getElementById('input_bukti');
        if (!fileInput.files || fileInput.files.length === 0) {
            fileInput.reportValidity(); // Tampilkan validasi browser jika file belum dipilih
            return;
        }

        const modal = document.getElementById('modalPelunasan');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModalPelunasan() {
        const modal = document.getElementById('modalPelunasan');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function submitPelunasanForm() {
        document.getElementById('form-pelunasan').submit();
    }
</script>
@endsection