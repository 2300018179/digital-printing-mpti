@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<div>
    <h2 class="text-xl font-bold text-gray-800 tracking-wide">Verifikasi Pembayaran</h2>
    <p class="text-xs text-gray-500 mt-1">Periksa bukti transfer dan konfirmasi pembayaran dari pelanggan.</p>
</div>

{{-- Filter Status --}}
<div class="bg-white border border-red-200 rounded-xl p-1.5 flex items-center gap-2 shadow-xs w-fit my-6">
    @foreach(['Menunggu', 'Disetujui', 'Ditolak'] as $s)
        <a href="{{ route('admin.pembayaran', ['status' => $s]) }}" 
           class="px-6 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 no-underline text-center {{ $status == $s ? 'bg-red-700 text-white shadow-xs' : 'text-gray-700 hover:text-red-700' }}">
            {{ $s }} ({{ $counts[$s] ?? 0 }})
        </a>
    @endforeach
</div>

{{-- NOTIFIKASI SUKSES (FLASH MESSAGE) --}}
@if (session('success'))
<div id="alert-success" class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-between transition-all duration-500 shadow-sm">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
            ✓
        </div>
        <div>
            <h4 class="text-xs font-bold text-emerald-900">Berhasil!</h4>
            <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
        </div>
    </div>
    <button type="button" onclick="closeAlertSuccess()" class="text-emerald-500 hover:text-emerald-800 text-sm font-bold px-2 py-1 transition cursor-pointer">
        ✕
    </button>
</div>
@endif

{{-- NOTIFIKASI ERROR / DITOLAK --}}
@if (session('error'))
<div id="alert-error" class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 flex items-center justify-between transition-all duration-500 shadow-sm">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
            ✕
        </div>
        <div>
            <h4 class="text-xs font-bold text-rose-900">Pembayaran Ditolak!</h4>
            <p class="text-xs text-rose-700 mt-0.5">{{ session('error') }}</p>
        </div>
    </div>
    <button type="button" onclick="closeAlertError()" class="text-rose-500 hover:text-rose-800 text-sm font-bold px-2 py-1 transition cursor-pointer">
        ✕
    </button>
</div>
@endif

{{-- Container Utama Tabel --}}
<div class="bg-white border border-red-200 rounded-2xl shadow-sm overflow-hidden p-6 flex flex-col justify-between min-h-[395px]">
    <div class="overflow-x-auto w-full flex-grow overflow-y-hidden pb-2">
        <table class="w-full text-left border-collapse text-xs table-fixed">
            <thead>
                <tr class="bg-red-50 text-red-700 font-bold h-9">
                    <th class="p-2.5 w-10 text-center">No</th>
                    <th class="p-2.5 w-28 text-left">Order ID</th>
                    <th class="p-2.5 w-40 text-left">Pelanggan</th>
                    <th class="p-2.5 w-24 text-left">Tanggal</th>
                    <th class="p-2.5 w-28 text-center">Tipe Bayar</th>
                    <th class="p-2.5 w-28 text-center">Bukti Transfer</th>
                    <th class="p-2.5 w-32 text-right">Rincian Bayar</th>
                    <th class="p-2.5 w-24 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 font-medium text-gray-600">
                @forelse($pesanans as $index => $item)
                <tr class="hover:bg-gray-50/50 transition h-[58px]">
                    <td class="p-2.5 text-center text-gray-400 font-semibold">
                        {{ $pesanans->firstItem() + $index }}
                    </td>
                    <td class="p-2.5 font-mono font-bold text-gray-800 text-left">
                        {{ $item->order_id }}
                    </td>
                    <td class="p-2.5 font-semibold text-gray-800 text-left">
                        <div class="truncate w-full" title="{{ $item->nama_pelanggan ?? $item->user->name ?? '-' }}">
                            {{ $item->nama_pelanggan ?? $item->user->name ?? '-' }}
                        </div>
                    </td>
                    <td class="p-2.5 text-gray-500 text-left">
                        {{ $item->tanggal_pesanan ? \Carbon\Carbon::parse($item->tanggal_pesanan)->format('d M Y') : $item->created_at->format('d M Y') }}
                    </td>
                    
                    {{-- Tipe Pembayaran (DP vs Full) --}}
                    <td class="p-2.5 text-center">
                        @if(($item->tipe_pembayaran ?? 'full') === 'dp')
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                DP (50%)
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                LUNAS (100%)
                            </span>
                        @endif
                    </td>

                    {{-- Bukti Transfer --}}
                    <td class="p-2.5 text-center">
                        @if($item->bukti_transfer)
                            <button type="button" 
                                onclick="openModal('{{ $item->order_id }}', '{{ asset('assets/bukti_transfer/' . $item->bukti_transfer) }}')" 
                                class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1 rounded-md text-[11px] font-bold transition cursor-pointer">
                                Lihat Bukti
                            </button>
                        @else
                            <span class="text-gray-300 text-xs italic">Tidak ada</span>
                        @endif
                    </td>

                    {{-- Rincian Tagihan & Nominal Dibayar --}}
                    <td class="p-2.5 text-right">
                        <div class="font-bold text-gray-900">
                            Rp {{ number_format($item->nominal_dibayar > 0 ? $item->nominal_dibayar : $item->total, 0, ',', '.') }}
                        </div>
                        <div class="text-[10px] text-gray-400">
                            Total: Rp {{ number_format($item->total, 0, ',', '.') }}
                        </div>
                        @if(($item->diskon ?? 0) > 0)
                            <div class="text-[9px] text-emerald-600 font-semibold">
                                Hemat: Rp {{ number_format($item->diskon, 0, ',', '.') }}
                            </div>
                        @endif
                    </td>

                    {{-- Aksis / Status --}}
                    <td class="p-2.5 text-center">
                        @if($status == 'Menunggu')
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" 
                                        onclick="openConfirmModal('Disetujui', '{{ $item->id }}', '{{ $item->order_id }}')" 
                                        class="text-green-600 hover:text-green-800 p-1.5 transition rounded-md hover:bg-green-50 cursor-pointer" 
                                        title="Setujui Pembayaran">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>

                                <button type="button" 
                                        onclick="openConfirmModal('Ditolak', '{{ $item->id }}', '{{ $item->order_id }}')" 
                                        class="text-red-600 hover:text-red-800 p-1.5 transition rounded-md hover:bg-red-50 cursor-pointer" 
                                        title="Tolak Pembayaran">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @else
                            <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full inline-block whitespace-nowrap {{ $status == 'Disetujui' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $status }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-8 text-xs font-medium text-gray-400 italic">
                        Tidak ada data pembayaran untuk status <strong>{{ $status }}</strong>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer Pagination --}}
    @if($pesanans->hasPages() || $pesanans->total() > 0)
    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
        <div>
            Showing <span class="font-semibold text-gray-700">{{ $pesanans->firstItem() ?? 0 }}</span> 
            to <span class="font-semibold text-gray-700">{{ $pesanans->lastItem() ?? 0 }}</span> 
            of <span class="font-semibold text-gray-700">{{ $pesanans->total() }}</span> results
        </div>
        <div>
            {{ $pesanans->links() }}
        </div>
    </div>
    @endif
</div>
@endsection

@push('modals')
<!-- 1. MODAL POPUP BUKTI TRANSFER -->
<div id="buktiModal" onclick="closeModalOnBackdrop(event, 'buktiModal')" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-2xl max-w-md w-full overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300 border border-gray-100">
        <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <div>
                <h3 class="text-xs font-bold text-gray-800">Bukti Transfer Pelanggan</h3>
                <p id="modalOrderId" class="text-[10px] font-mono text-red-600 font-bold mt-0.5">#ORD-XXXXX</p>
            </div>
            <button onclick="closeModal('buktiModal')" class="text-gray-400 hover:text-gray-600 text-lg font-bold focus:outline-none transition p-1 cursor-pointer">✕</button>
        </div>
        <div class="p-5 bg-gray-100 flex items-center justify-center min-h-[250px]">
            <img id="modalImage" src="" alt="Bukti Transfer" class="max-h-[450px] w-auto object-contain rounded-lg shadow-sm border border-gray-200">
        </div>
        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex justify-end">
            <button onclick="closeModal('buktiModal')" class="px-4 py-1.5 bg-red-700 hover:bg-red-800 text-white rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- 2. MODAL CUSTOM KONFIRMASI -->
<div id="confirmModal" onclick="closeModalOnBackdrop(event, 'confirmModal')" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300 opacity-0">
    <div class="bg-white rounded-2xl max-w-sm w-full overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300 border border-gray-100 text-center p-6">
        
        <div id="confirmIconBg" class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 transition-colors">
            <svg id="confirmIconApprove" class="w-8 h-8 text-green-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
            </svg>
            <svg id="confirmIconReject" class="w-8 h-8 text-red-600 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>

        <h3 id="confirmTitle" class="text-base font-bold text-gray-800">Konfirmasi Pembayaran</h3>
        <p id="confirmDesc" class="text-xs text-gray-500 mt-2 leading-relaxed">
            Apakah Anda yakin ingin memproses pesanan <span id="confirmOrderId" class="font-bold text-gray-800"></span>?
        </p>

        <form id="confirmForm" method="POST" action="" class="mt-6 flex items-center justify-center gap-3">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" id="confirmStatusInput" value="">

            <button type="button" onclick="closeModal('confirmModal')" class="w-1/2 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-bold transition cursor-pointer">
                Batal
            </button>
            <button type="submit" id="confirmSubmitBtn" class="w-1/2 py-2.5 text-white rounded-xl text-xs font-bold transition shadow-sm cursor-pointer">
                Ya, Lanjutkan
            </button>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function closeAlertSuccess() {
        const alert = document.getElementById('alert-success');
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }
    }

    function closeAlertError() {
        const alert = document.getElementById('alert-error');
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(closeAlertSuccess, 4000);
        setTimeout(closeAlertError, 4000);
    });

    function openModal(orderId, imageUrl) {
        document.getElementById('modalOrderId').innerText = '#' + orderId;
        document.getElementById('modalImage').src = imageUrl;
        showModal('buktiModal');
    }

    function openConfirmModal(actionType, id, orderId) {
        const form = document.getElementById('confirmForm');
        const statusInput = document.getElementById('confirmStatusInput');
        const iconBg = document.getElementById('confirmIconBg');
        const iconApprove = document.getElementById('confirmIconApprove');
        const iconReject = document.getElementById('confirmIconReject');
        const title = document.getElementById('confirmTitle');
        const desc = document.getElementById('confirmDesc');
        const submitBtn = document.getElementById('confirmSubmitBtn');

        form.action = `{{ route('admin.pembayaran.update', ':id') }}`.replace(':id', id);
        statusInput.value = actionType;
        document.getElementById('confirmOrderId').innerText = '#' + orderId;

        if (actionType === 'Disetujui') {
            iconBg.className = 'w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 bg-green-100';
            iconApprove.classList.remove('hidden');
            iconReject.classList.add('hidden');
            title.innerText = 'Setujui Pembayaran?';
            desc.innerHTML = `Apakah Anda yakin ingin menyetujui pembayaran untuk order <span class="font-bold text-gray-800">#${orderId}</span>? Status pesanan akan diubah menjadi <strong class="text-green-600">Dicetak</strong>.`;
            submitBtn.className = 'w-1/2 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold transition shadow-sm cursor-pointer';
        } else {
            iconBg.className = 'w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4 bg-red-100';
            iconApprove.classList.add('hidden');
            iconReject.classList.remove('hidden');
            title.innerText = 'Tolak Pembayaran?';
            desc.innerHTML = `Apakah Anda yakin ingin menolak pembayaran untuk order <span class="font-bold text-gray-800">#${orderId}</span>? Status pesanan akan diubah menjadi <strong class="text-red-600">Ditolak</strong>.`;
            submitBtn.className = 'w-1/2 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold transition shadow-sm cursor-pointer';
        }

        showModal('confirmModal');
    }

    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
        }, 10);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.remove('scale-100');
        modal.querySelector('div').classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    function closeModalOnBackdrop(event, modalId) {
        if (event.target.id === modalId) {
            closeModal(modalId);
        }
    }
</script>
@endpush