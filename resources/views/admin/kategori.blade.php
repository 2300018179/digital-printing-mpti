@extends('layouts.admin')

@section('title', 'Data Kategori - Fantastic Digital Printing')

@section('content')
{{-- Container utama --}}
<div class="flex flex-col max-w-7xl space-y-6">
    
    {{-- Header Halaman & Tombol Tambah --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-gray-800 tracking-wide">Data Kategori</h2>
            <p class="text-xs text-gray-500 mt-1">Kelola daftar kategori dan sub kategori produk cetak Anda.</p>
        </div>
        <a href="{{ route('admin.kategori.tambah') }}" class="shrink-0 whitespace-nowrap bg-red-700 hover:bg-red-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 no-underline">
            <span class="text-base leading-none">+</span> Tambah Sub Kategori
        </a>
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

    {{-- Box Putih Tabel --}}
    <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs" id="sub-category-table">
                <thead>
                    <tr class="bg-red-50 text-red-700 font-bold h-9">
                        <th class="py-2.5 px-4 w-12 text-center">No</th>
                        <th class="py-2.5 px-4 w-1/3">Nama Sub Kategori</th>
                        <th class="py-2.5 px-4 w-1/3">Kategori Utama</th>
                        <th class="py-2.5 px-4 w-28 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-600">
                    @forelse($subKategoris as $index => $sub)
                    <tr class="hover:bg-gray-50 transition align-middle h-11">
                        {{-- Nomor berlanjut --}}
                        <td class="py-2.5 px-4 text-center text-gray-400 font-semibold">
                            {{ $subKategoris->firstItem() + $index }}
                        </td>
                        
                        {{-- Nama Sub Kategori --}}
                        <td class="py-2.5 px-4 font-semibold text-gray-800">
                            {{ $sub->name }}
                        </td>
                        
                        {{-- Nama Kategori Utama --}}
                        <td class="py-2.5 px-4 font-semibold text-gray-800">
                            {{ $sub->kategori->name ?? 'Tanpa Kategori' }}
                        </td>

                        {{-- Tombol Edit & Hapus --}}
                        <td class="py-2.5 px-4 text-center">
                            <div class="flex justify-center gap-3 items-center">
                                {{-- Edit --}}
                                <a href="{{ route('admin.kategori.edit', $sub->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>
                                
                                {{-- Hapus --}}
                                <form action="{{ route('admin.kategori.destroy', $sub->id) }}" method="POST" id="form-delete-{{ $sub->id }}" class="inline m-0 p-0 flex items-center">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn-delete text-red-600 hover:text-red-800 transition-colors cursor-pointer flex items-center" 
                                            data-id="{{ $sub->id }}" 
                                            data-name="{{ $sub->name }}" 
                                            title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-6 px-3 text-center text-gray-400 italic">Belum ada kategori di database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Area Pagination --}}
        @if($subKategoris->hasPages() || $subKategoris->total() > 0)
        <div class="flex flex-col sm:flex-row justify-between items-center pt-4 mt-4 border-t border-gray-100 text-xs text-gray-500 gap-3">
            <div>
                Showing <span class="font-semibold text-gray-700">{{ $subKategoris->firstItem() ?? 0 }}</span> 
                to <span class="font-semibold text-gray-700">{{ $subKategoris->lastItem() ?? 0 }}</span> 
                of <span class="font-semibold text-gray-700">{{ $subKategoris->total() }}</span> results
            </div>

            @if($subKategoris->hasPages())
            <div class="inline-flex rounded-lg border border-gray-200 overflow-hidden bg-white shadow-sm">
                @if ($subKategoris->onFirstPage())
                    <span class="px-3 py-1.5 text-gray-300 border-r border-gray-200 cursor-not-allowed flex items-center">&lsaquo;</span>
                @else
                    <a href="{{ $subKategoris->previousPageUrl() }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r border-gray-200 transition flex items-center">&lsaquo;</a>
                @endif

                @foreach ($subKategoris->getUrlRange(1, $subKategoris->lastPage()) as $page => $url)
                    @if ($page == $subKategoris->currentPage())
                        <span class="px-3 py-1.5 bg-gray-100 font-bold text-gray-800 border-r last:border-r-0 border-gray-200 flex items-center">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r last:border-r-0 border-gray-200 transition flex items-center">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($subKategoris->hasMorePages())
                    <a href="{{ $subKategoris->nextPageUrl() }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 transition flex items-center">&rsaquo;</a>
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

{{-- Custom Modal Hapus --}}
@push('modals')
<div id="deleteConfirmModal" class="fixed inset-0 z-[99999] hidden items-center justify-center bg-black/50 opacity-0 transition-opacity duration-300">
    <div class="bg-white w-[90%] max-w-[380px] rounded-[28px] p-7 flex flex-col items-center text-center shadow-2xl transform scale-95 transition-transform duration-300">
        
        <div class="w-14 h-14 bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-4 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
        </div>
        
        <h3 class="text-lg font-bold text-gray-900 mb-1.5 tracking-tight">Konfirmasi Hapus</h3>
        <p id="deleteModalMessage" class="text-xs text-gray-500 mb-6 leading-relaxed max-w-[280px]">
            Apakah Anda yakin ingin menghapus sub kategori ini?
        </p>
        
        <div class="flex gap-3 w-full">                
            <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 border border-gray-300 text-gray-600 rounded-full text-xs font-semibold cursor-pointer transition hover:bg-gray-50 active:scale-95">
                Batal
            </button>
            <button type="button" id="btn-confirm-delete" class="flex-1 py-2.5 bg-red-700 hover:bg-red-800 text-white rounded-full text-xs font-bold text-center cursor-pointer transition active:scale-95 shadow-md">
                Hapus
            </button>
        </div>
    </div>
</div>
@endpush

{{-- Script JS Modal & Notifikasi --}}
@push('scripts')
<script>
    // --- JS ALERT SUKSES AUTO-HIDE ---
    function closeAlertSuccess() {
        const alert = document.getElementById('alert-success');
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';
            setTimeout(() => alert.remove(), 400);
        }
    }

    // --- JS MODAL HAPUS ---
    let currentDeleteForm = null;

    function openDeleteModal(subName, form) {
        currentDeleteForm = form;
        document.getElementById('deleteModalMessage').innerText = `Apakah Anda yakin ingin menghapus sub kategori "${subName}"?`;
        
        const modal = document.getElementById('deleteConfirmModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteConfirmModal');
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.remove('scale-100');
        modal.querySelector('div').classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            currentDeleteForm = null;
        }, 300);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alert setelah 4 detik
        setTimeout(function () {
            closeAlertSuccess();
        }, 4000);

        // Handler tombol delete modal
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const subId = this.getAttribute('data-id');
                const subName = this.getAttribute('data-name');
                const targetForm = document.getElementById(`form-delete-${subId}`);

                openDeleteModal(subName, targetForm);
            });
        });

        document.getElementById('btn-confirm-delete').addEventListener('click', function() {
            if (currentDeleteForm) {
                currentDeleteForm.submit();
            }
        });
    });
</script>
@endpush