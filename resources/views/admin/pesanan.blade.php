@extends('layouts.admin')

@section('title', 'Data Pesanan - Fantastic Digital Printing')

@section('content')
{{-- Container Utama --}}
<div class="flex flex-col max-w-7xl space-y-6">

    {{-- Header Halaman --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">Data Pesanan</h2>
        <p class="text-xs text-gray-500 mt-1">Kelola dan pantau seluruh status pesanan pelanggan.</p>
    </div>

    {{-- NOTIFIKASI SUKSES (FLASH MESSAGE) DENGAN AUTO-HIDE --}}
    @if (session('success'))
    <div id="alert-success" class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-between transition-all duration-500 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
                ✓
            </div>
            <div>
                <h4 class="text-xs font-bold text-emerald-900">Berhasil Disimpan!</h4>
                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" onclick="closeAlertSuccess()" class="text-emerald-500 hover:text-emerald-800 text-sm font-bold px-2 py-1 transition cursor-pointer">
            ✕
        </button>
    </div>
    @endif

    {{-- Box Putih Tabel Pesanan --}}
    <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6 overflow-hidden flex flex-col justify-between">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-red-50 text-red-700 font-bold h-9">
                        <th class="py-2.5 px-4 text-center w-12">No</th>
                        <th class="py-2.5 px-4">Order ID</th>
                        <th class="py-2.5 px-4">Pelanggan</th>
                        <th class="py-2.5 px-4">Tanggal</th>
                        <th class="py-2.5 px-4">Total</th>
                        <th class="py-2.5 px-4 text-center">Status</th>
                        <th class="py-2.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-600">
                    @forelse($pesanans as $index => $pesanan)
                    <tr class="hover:bg-gray-50 transition align-middle h-11">
                        <td class="py-2.5 px-4 text-center text-gray-400 font-semibold">
                            {{ $pesanans->firstItem() + $index }}
                        </td>

                        <td class="py-2.5 px-4 font-mono text-xs font-bold text-gray-700">
                            {{ $pesanan->order_id }}
                        </td>

                        <td class="py-2.5 px-4 font-semibold text-gray-800">
                            {{ $pesanan->nama_pelanggan }}
                        </td>

                        <td class="py-2.5 px-4 text-gray-500 font-medium text-xs">
                            {{ $pesanan->created_at->format('d M Y') }}
                        </td>

                        <td class="py-2.5 px-4 font-bold text-gray-800 text-xs">
                            Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                        </td>

                        <td class="py-2.5 px-4 text-center">
                            @php
                                $statusLower = strtolower($pesanan->status);

                                $statusClass = match($statusLower) {
                                    'diproses', 'proses' => 'bg-orange-50 text-orange-600 border-orange-200',
                                    'dicetak'           => 'bg-blue-50 text-blue-600 border-blue-200',
                                    'selesai'           => 'bg-green-50 text-green-600 border-green-200',
                                    'ditolak', 'batal'   => 'bg-red-50 text-red-600 border-red-200',
                                    default             => 'bg-gray-50 text-gray-600 border-gray-200',
                                };

                                $statusLabel = match($statusLower) {
                                    'ditolak' => 'Batal',
                                    default   => ucfirst($pesanan->status),
                                };
                            @endphp

                            <span class="px-3 py-1 rounded-full text-[10px] font-bold border {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <td class="py-2.5 px-4 text-center">
                            <a href="{{ route('admin.pesanan.detail', $pesanan->id) }}" 
                               class="inline-block px-4 py-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white text-gray-600 rounded-lg text-[11px] font-bold shadow-sm transition active:scale-95">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-6 px-4 text-center text-gray-400 italic">
                            Tidak ada data pesanan tersedia.
                        </td>
                    </tr>
                    @endforelse

                    {{-- Dummy rows untuk menjaga tinggi tabel --}}
                    @php
                        $rowCount = count($pesanans);
                        $maxRows = 7;
                    @endphp

                    @if($rowCount > 0 && $rowCount < $maxRows)
                        @for($i = 0; $i < ($maxRows - $rowCount); $i++)
                        <tr class="h-11 border-b border-transparent pointer-events-none">
                            <td colspan="7" class="py-2.5 px-4">&nbsp;</td>
                        </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Area Pagination --}}
        @if($pesanans->hasPages() || $pesanans->total() > 0)
        <div class="flex flex-col sm:flex-row justify-between items-center pt-4 mt-4 border-t border-gray-100 text-xs text-gray-500 gap-3">
            <div>
                Showing <span class="font-semibold text-gray-700">{{ $pesanans->firstItem() ?? 0 }}</span> 
                to <span class="font-semibold text-gray-700">{{ $pesanans->lastItem() ?? 0 }}</span> 
                of <span class="font-semibold text-gray-700">{{ $pesanans->total() }}</span> results
            </div>

            @if($pesanans->hasPages())
            <div class="inline-flex rounded-lg border border-gray-200 overflow-hidden bg-white shadow-sm">
                @if ($pesanans->onFirstPage())
                    <span class="px-3 py-1.5 text-gray-300 border-r border-gray-200 cursor-not-allowed flex items-center">&lsaquo;</span>
                @else
                    <a href="{{ $pesanans->previousPageUrl() }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r border-gray-200 transition flex items-center">&lsaquo;</a>
                @endif

                @foreach ($pesanans->getUrlRange(1, $pesanans->lastPage()) as $page => $url)
                    @if ($page == $pesanans->currentPage())
                        <span class="px-3 py-1.5 bg-gray-100 font-bold text-gray-800 border-r last:border-r-0 border-gray-200 flex items-center">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r last:border-r-0 border-gray-200 transition flex items-center">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($pesanans->hasMorePages())
                    <a href="{{ $pesanans->nextPageUrl() }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 transition flex items-center">&rsaquo;</a>
                @else
                    <span class="px-3 py-1.5 text-gray-300 cursor-not-allowed flex items-center">&rsaquo;</span>
                @endif
            </div>
            @endif
        </div>
        @endif
    </div>

</div>

{{-- Script JS untuk Auto-Hide & Tombol Close Notifikasi --}}
<script>
    function closeAlertSuccess() {
        const alert = document.getElementById('alert-success');
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';
            setTimeout(() => alert.remove(), 400);
        }
    }

    // Menghilang otomatis setelah 4 detik (4000 ms)
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            closeAlertSuccess();
        }, 4000);
    });
</script>
@endsection