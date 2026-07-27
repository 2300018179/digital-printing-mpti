@extends('layouts.admin')

@section('title', 'Data Promo & Pengumuman - Fantastic Digital Printing')

@section('content')
{{-- HEADER ATAS --}}
<div class="flex flex-nowrap justify-between items-center mb-6 gap-4">
    <div class="min-w-0">
        <h2 class="text-xl font-bold text-gray-800 tracking-wide truncate">Data Promo & Pengumuman</h2>
        <p class="text-xs text-gray-500 mt-1 truncate">Kelola voucher promo diskon dan pengumuman informasi toko.</p>
    </div>
    
    {{-- Tombol Tambah Dinamis --}}
    <a id="btn-tambah-dinamis" href="{{ route('admin.promo.tambah') }}" 
       class="shrink-0 whitespace-nowrap bg-red-700 hover:bg-red-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 no-underline">
        <span>+</span> <span id="label-tambah">Tambah Promo</span>
    </a>
</div>

{{-- TAB NAVIGASI (Compact / Menyesuaikan Isi) --}}
<div class="bg-white border border-red-200 rounded-xl p-1.5 flex items-center gap-2 shadow-xs w-fit my-6">
    <button type="button" id="tab-btn-promo" onclick="switchTab('promo')" 
            class="px-6 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-center bg-red-700 text-white shadow-xs">
        Data Promo
    </button>
    <button type="button" id="tab-btn-info" onclick="switchTab('info')" 
            class="px-6 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-center text-gray-700 hover:text-red-700">
        Data Pengumuman / Informasi
    </button>
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

{{-- ========================================================= --}}
{{-- 1. TABEL PROMO --}}
{{-- ========================================================= --}}
<div id="section-promo" class="block">
    <div class="bg-white border border-red-300 rounded-xl shadow-sm overflow-hidden p-6 flex flex-col justify-between min-h-[395px]">
        <div class="overflow-x-auto w-full flex-grow overflow-y-hidden pb-2">
            <table class="w-full text-left border-collapse text-xs table-fixed">
                <thead>
                    <tr class="bg-red-50 text-red-700 font-bold border-b border-red-100 h-9">
                        <th class="p-2.5 w-12 text-center">No</th>
                        <th class="p-2.5 w-48 text-left">Nama Promo</th>
                        <th class="p-2.5 w-32 text-left">Kode Promo</th>
                        <th class="p-2.5 w-24 text-left">Diskon</th>
                        <th class="p-2.5 w-44 text-left">Berlaku</th>
                        <th class="p-2.5 w-24 text-center">Status</th>
                        <th class="p-2.5 w-20 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-600">
                @forelse($promos as $key => $promo)
                <tr class="hover:bg-gray-50/50 transition h-[52px]">
                    <td class="p-2.5 text-center text-gray-400">{{ $loop->iteration }}</td>
                    <td class="p-2.5 font-semibold text-gray-800 text-left">
                        <div class="truncate w-full" title="{{ $promo->nama }}">{{ $promo->nama }}</div>
                    </td>
                    <td class="p-2.5 font-mono font-bold text-red-700 text-left uppercase">
                        {{ $promo->kode ?? '-' }}
                    </td>
                    <td class="p-2.5 font-semibold text-gray-900 text-left">
                        {{ $promo->diskon ? $promo->diskon . '%' : '-' }}
                    </td>
                    <td class="p-2.5 text-left text-gray-500">
                        {{ $promo->tanggal_mulai ? \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') : '-' }} - {{ $promo->tanggal_selesai ? \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d M Y') : '-' }}
                    </td>
                    <td class="p-2.5 text-center">
                        <span class="{{ $promo->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} text-[10px] px-2.5 py-0.5 rounded-full font-bold inline-block whitespace-nowrap">
                            {{ $promo->status }}
                        </span>
                    </td>
                    <td class="p-2.5 text-center">
                        <div class="flex justify-center gap-3 items-center h-full">
                            <a href="{{ route('admin.promo.edit', $promo->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.promo.destroy', $promo->id) }}" method="POST" id="form-delete-{{ $promo->id }}" class="inline m-0 p-0 flex items-center">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('form-delete-{{ $promo->id }}', '{{ $promo->nama }}', 'promo')" class="text-red-600 hover:text-red-800 transition-colors cursor-pointer flex items-center" title="Hapus">
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
                    <td colspan="7" class="text-center py-8 text-xs font-medium text-gray-400 italic">
                        Belum ada data promo.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ========================================================= --}}
{{-- 2. TABEL INFORMASI / PENGUMUMAN --}}
{{-- ========================================================= --}}
<div id="section-info" class="hidden">
    <div class="bg-white border border-red-300 rounded-xl shadow-sm overflow-hidden p-6 flex flex-col justify-between min-h-[395px]">
        <div class="overflow-x-auto w-full flex-grow overflow-y-hidden pb-2">
            <table class="w-full text-left border-collapse text-xs table-fixed">
                <thead>
                    <tr class="bg-red-50 text-red-700 font-bold border-b border-red-100 h-9">
                        <th class="p-2.5 w-12 text-center">No</th>
                        <th class="p-2.5 w-64 text-left">Judul Pengumuman</th>
                        <th class="p-2.5 w-80 text-left">Ringkasan Info</th>
                        <th class="p-2.5 w-44 text-left">Tanggal Tayang</th>
                        <th class="p-2.5 w-24 text-center">Status</th>
                        <th class="p-2.5 w-20 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-600">
                @forelse($informasis ?? [] as $key => $info)
                <tr class="hover:bg-gray-50/50 transition h-[52px]">
                    <td class="p-2.5 text-center text-gray-400">{{ $loop->iteration }}</td>
                    <td class="p-2.5 font-semibold text-gray-800 text-left">
                        <div class="truncate w-full" title="{{ $info->judul }}">{{ $info->judul }}</div>
                    </td>
                    <td class="p-2.5 text-gray-500 text-left">
                        <div class="truncate w-full" title="{{ $info->isi }}">{{ $info->isi }}</div>
                    </td>
                    <td class="p-2.5 text-left text-gray-500">
                        {{ $info->tanggal ? \Carbon\Carbon::parse($info->tanggal)->format('d M Y') : '-' }}
                    </td>
                    <td class="p-2.5 text-center">
                        <span class="{{ $info->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} text-[10px] px-2.5 py-0.5 rounded-full font-bold inline-block whitespace-nowrap">
                            {{ $info->status }}
                        </span>
                    </td>
                    <td class="p-2.5 text-center">
                        <div class="flex justify-center gap-3 items-center h-full">
                            <a href="{{ route('admin.pengumuman.edit', $info->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit Pengumuman">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.pengumuman.destroy', $info->id) }}" method="POST" id="form-delete-info-{{ $info->id }}" class="inline m-0 p-0 flex items-center">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('form-delete-info-{{ $info->id }}', '{{ $info->judul }}', 'pengumuman')" class="text-red-600 hover:text-red-800 transition-colors cursor-pointer flex items-center" title="Hapus">
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
                    <td colspan="6" class="text-center py-8 text-xs font-medium text-gray-400 italic">
                        Belum ada data pengumuman / informasi toko.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS CUSTOM --}}
<div id="deleteConfirmModal" class="fixed inset-0 z-[99999] hidden items-center justify-center bg-black/40 backdrop-blur-xs opacity-0 transition-opacity duration-300">
    <div class="bg-white w-[90%] max-w-[380px] rounded-[28px] p-7 flex flex-col items-center text-center shadow-2xl transform scale-95 transition-transform duration-300">
        
        {{-- Circle Icon --}}
        <div class="w-14 h-14 bg-red-50 text-red-500 rounded-full flex items-center justify-center mb-4 shadow-xs">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
        </div>
        
        <h3 class="text-base font-bold text-gray-800 mb-2 tracking-wide">Konfirmasi Hapus</h3>
        <p id="deleteModalMessage" class="text-xs text-gray-500 leading-relaxed mb-6 max-w-[280px]">
            Apakah Anda yakin ingin menghapus data ini?
        </p>
        
        <div class="flex gap-3 w-full">                
            <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 border border-gray-300 text-gray-700 rounded-full text-xs font-bold cursor-pointer transition hover:bg-gray-50 active:scale-95">
                Batal
            </button>
            <button type="button" id="btn-confirm-delete" class="flex-1 py-2.5 bg-red-700 hover:bg-red-800 text-white rounded-full text-xs font-bold text-center cursor-pointer transition active:scale-95 shadow-xs">
                Hapus
            </button>
        </div>
    </div>
</div>

{{-- SCRIPT DYNAMIC LOGIC --}}
<script>
    const urlTambahPromo = "{{ route('admin.promo.tambah') }}";
    const urlTambahInfo = "{{ route('admin.pengumuman.tambah') }}"; 

    // 1. SWITCH TAB LOGIC
    function switchTab(type, updateHash = true) {
        const promoSec = document.getElementById('section-promo');
        const infoSec = document.getElementById('section-info');
        const promoBtn = document.getElementById('tab-btn-promo');
        const infoBtn = document.getElementById('tab-btn-info');
        
        const btnTambah = document.getElementById('btn-tambah-dinamis');
        const labelTambah = document.getElementById('label-tambah');

        if(type === 'promo') {
            promoSec.classList.remove('hidden');
            infoSec.classList.add('hidden');
            
            promoBtn.className = "shrink-0 px-6 py-2.5 rounded-lg text-xs font-bold transition-all cursor-pointer bg-red-700 text-white shadow-sm whitespace-nowrap";
            infoBtn.className = "shrink-0 px-6 py-2.5 rounded-lg text-xs font-semibold transition-all cursor-pointer bg-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50 whitespace-nowrap";

            btnTambah.setAttribute('href', urlTambahPromo);
            labelTambah.innerText = 'Tambah Promo';
            
            if (updateHash) history.replaceState(null, null, '#promo');
        } else {
            promoSec.classList.add('hidden');
            infoSec.classList.remove('hidden');

            infoBtn.className = "shrink-0 px-6 py-2.5 rounded-lg text-xs font-bold transition-all cursor-pointer bg-red-700 text-white shadow-sm whitespace-nowrap";
            promoBtn.className = "shrink-0 px-6 py-2.5 rounded-lg text-xs font-semibold transition-all cursor-pointer bg-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50 whitespace-nowrap";

            btnTambah.setAttribute('href', urlTambahInfo);
            labelTambah.innerText = 'Tambah Pengumuman';
            
            if (updateHash) history.replaceState(null, null, '#info');
        }
    }

    // 2. CEK TAB SAAT HALAMAN DIMUAT (REFRESH ATAU SETELAH SIMPAN)
    document.addEventListener('DOMContentLoaded', function () {
        // A. Priority 1: Cek Session Flash dari Controller (setelah submit simpan/edit/hapus)
        const sessionTab = "{{ session('active_tab') }}";
        
        // B. Priority 2: Cek URL Hash (#info atau #promo)
        const urlHash = window.location.hash.replace('#', '');

        if (sessionTab === 'info' || urlHash === 'info') {
            switchTab('info', false);
        } else {
            switchTab('promo', false);
        }

        // Auto-Hide Alert Success
        const alert = document.getElementById('alert-success');
        if (alert) {
            setTimeout(() => {
                closeAlertSuccess();
            }, 4000);
        }
    });

    // 3. AUTO-HIDE FLASH MESSAGE LOGIC
    function closeAlertSuccess() {
        const alert = document.getElementById('alert-success');
        if (alert) {
            alert.classList.add('opacity-0', '-translate-y-2');
            setTimeout(() => {
                alert.remove();
            }, 500);
        }
    }

    // 4. CUSTOM DELETE MODAL LOGIC
    let targetFormId = null;

    function confirmDelete(formId, itemName, type = 'data') {
        targetFormId = formId;
        const messageElem = document.getElementById('deleteModalMessage');
        
        if (messageElem) {
            messageElem.innerHTML = `Apakah Anda yakin ingin menghapus ${type} <span class="font-semibold text-gray-700">"${itemName}"</span>?`;
        }
        
        const modal = document.getElementById('deleteConfirmModal');
        
        // Dipindahkan langsung ke root body agar tidak terkurung container
        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }

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
            targetFormId = null;
        }, 300);
    }

    document.getElementById('btn-confirm-delete').addEventListener('click', function() {
        if (targetFormId) {
            const form = document.getElementById(targetFormId);
            if (form) form.submit();
        }
    });
</script>
@endsection