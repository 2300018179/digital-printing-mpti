@extends('layouts.admin')

@section('title', 'Data Produk - Fantastic Digital Printing')

@section('content')
{{-- Header & Deskripsi Halaman --}}
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800 tracking-wide">Data Produk</h2>
            <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                Kelola seluruh katalog produk.
            </p>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('admin.produk.create') }}" class="shrink-0 whitespace-nowrap bg-red-700 hover:bg-red-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 no-underline">
                <span>+</span> Tambah Produk
            </a>
        </div>
    </div>
</div>

<div class="flex flex-wrap gap-4 items-center mb-6">
    {{-- Search Input (Menggunakan Enter) --}}
    <div class="relative w-full max-w-xs">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <input type="text" 
            id="search-input" 
            placeholder="Cari Produk (Tekan Enter)" 
            class="w-full pl-10 pr-4 py-2 text-xs font-medium bg-white border border-red-400 rounded-xl focus:outline-none focus:ring-1 focus:ring-red-500 text-gray-700 placeholder-gray-400 shadow-sm">
    </div>

    {{-- Filter Kategori Induk --}}
    <div class="relative">
        <select id="category-filter" onchange="resetPageAndFilter('category')" class="appearance-none bg-white border border-red-400 rounded-xl pl-4 pr-10 py-2 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-1 focus:ring-red-500 shadow-sm min-w-[150px]">
            <option value="all">Semua Kategori</option>
            @if(isset($kategoris))
                @foreach($kategoris as $kat)
                    <option value="{{ $kat->name }}" {{ request('category') == $kat->name ? 'selected' : '' }}>
                        {{ $kat->name }}
                    </option>
                @endforeach
            @endif
        </select>
        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500 text-[10px]">▼</span>
    </div>

    {{-- Filter Sub Kategori --}}
    <div class="relative">
        <select id="subcategory-filter" onchange="resetPageAndFilter()" class="appearance-none bg-white border border-red-400 rounded-xl pl-4 pr-10 py-2 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-1 focus:ring-red-500 shadow-sm min-w-[150px]">
            <option value="all">Semua Sub Kategori</option>
            @if(isset($subKategoris))
                @foreach($subKategoris as $sub)
                    <option value="{{ $sub->name }}" {{ request('subcategory') == $sub->name ? 'selected' : '' }}>
                        {{ $sub->name }}
                    </option>
                @endforeach
            @endif
        </select>
        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500 text-[10px]">▼</span>
    </div>

    {{-- Filter Status --}}
    <div class="relative">
        <select id="status-filter" onchange="resetPageAndFilter()" class="appearance-none bg-white border border-red-400 rounded-xl pl-4 pr-10 py-2 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-1 focus:ring-red-500 shadow-sm min-w-[140px]">
            <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>Semua Status</option>
            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="Non-Aktif" {{ request('status') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
        </select>
        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500 text-[10px]">▼</span>
    </div>
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

<div class="bg-white border border-red-400 rounded-2xl shadow-sm overflow-hidden p-6 flex flex-col justify-between min-h-[395px]">
    <div class="overflow-x-auto w-full flex-grow overflow-y-hidden pb-2">
        <table class="w-full text-left border-collapse text-xs table-fixed" id="product-table">
            <thead>
                <tr class="bg-red-50 text-red-700 font-bold border-b border-red-100 h-9">
                    <th class="p-2.5 w-10 text-center">No</th>
                    <th class="p-2.5 w-16 text-center">Gambar</th>
                    <th class="p-2.5 w-40 text-left">Nama Produk</th>
                    <th class="p-2.5 w-48 text-left">Deskripsi</th>
                    <th class="p-2.5 w-28 text-left">Kategori</th>
                    <th class="p-2.5 w-32 text-left">Sub Kategori</th>
                    <th class="p-2.5 w-24 text-left">Harga</th>
                    <th class="p-2.5 w-16 text-center">Satuan</th>
                    <th class="p-2.5 w-20 text-center">Status</th>
                    <th class="p-2.5 w-16 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium text-gray-600" id="table-body">
            @forelse($products as $key => $product)
            <tr class="product-row hover:bg-gray-50/50 transition h-[52px]">
                <td class="p-2.5 text-center text-gray-400 row-number">{{ $key + 1 }}</td>
                <td class="p-2.5 text-center">
                    <div class="flex justify-center items-center h-full">
                        @if($product->image)
                            <img src="{{ asset('assets/products/' . $product->image) }}" class="w-8 h-8 object-cover rounded-lg border border-gray-200" alt="{{ $product->name }}">
                        @else
                            <div class="w-8 h-8 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-xs font-bold">📄</div>
                        @endif
                    </div>
                </td>
                <td class="p-2.5 font-semibold text-gray-800 text-left">
                    <div class="truncate w-full product-name" title="{{ $product->name }}">{{ $product->name }}</div>
                </td>
                <td class="p-2.5 text-gray-500 text-left">
                    <div class="truncate w-full" title="{{ $product->description }}">{{ $product->description }}</div>
                </td>
                <td class="p-2.5 text-left product-category" data-category="{{ $product->subKategori->kategori->name ?? 'Tanpa Kategori' }}">
                    {{ $product->subKategori->kategori->name ?? '-' }}
                </td>
                <td class="p-2.5 text-left text-gray-700 font-medium">
                    <div class="truncate w-full" title="{{ $product->subKategori->name ?? '-' }}">
                        {{ $product->subKategori->name ?? '-' }}
                    </div>
                </td>
                <td class="p-2.5 font-semibold text-gray-900 text-left">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="p-2.5 text-center">
                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase">{{ $product->unit }}</span>
                </td>
                <td class="p-2.5 text-center">
                    <span class="product-status {{ ($product->status == 'Aktif' || $product->status == '1') ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} text-[10px] px-2.5 py-0.5 rounded-full font-bold inline-block whitespace-nowrap" data-status="{{ ($product->status == '1' || $product->status == 'Aktif') ? 'aktif' : 'non-aktif' }}">
                        {{ ($product->status == '1' || $product->status == 'Aktif') ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </td>
                <td class="p-2.5 text-center">
                    <div class="flex justify-center gap-3 items-center h-full">
                        <a href="{{ route('admin.produk.edit', $product->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        
                        <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" id="form-delete-{{ $product->id }}" class="inline m-0 p-0 flex items-center">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    class="btn-delete text-red-600 hover:text-red-800 transition-colors cursor-pointer flex items-center" 
                                    data-id="{{ $product->id }}" 
                                    data-name="{{ $product->name }}" 
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
                <td colspan="10" class="text-center py-8 text-xs font-medium text-gray-400 italic">
                    Belum ada data produk di database.
                </td>
            </tr>
            @endforelse
            
            <tr id="no-data" class="hidden">
                <td colspan="10" class="text-center py-8 text-xs font-medium text-gray-400">
                    Data produk tidak ditemukan yang cocok dengan filter.
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    @if($products->hasPages() || $products->total() > 0)
    <div class="flex flex-col sm:flex-row justify-between items-center pt-4 mt-4 border-t border-gray-100 text-xs text-gray-500 gap-3 w-full">
        {{-- Info Hasil Data --}}
        <div>
            Showing <span class="font-semibold text-gray-700">{{ $products->firstItem() ?? 0 }}</span> 
            to <span class="font-semibold text-gray-700">{{ $products->lastItem() ?? 0 }}</span> 
            of <span class="font-semibold text-gray-700">{{ $products->total() }}</span> results
        </div>

        {{-- Tombol Pagination --}}
        @if($products->hasPages())
        <div class="inline-flex rounded-lg border border-gray-200 overflow-hidden bg-white shadow-sm">
            @if ($products->onFirstPage())
                <span class="px-3 py-1.5 text-gray-300 border-r border-gray-200 cursor-not-allowed flex items-center">&lsaquo;</span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r border-gray-200 transition flex items-center">&lsaquo;</a>
            @endif

            @php
                $currentPage = $products->currentPage();
                $lastPage = $products->lastPage();
                
                $start = max(1, $currentPage - 1);
                $end = min($lastPage, $currentPage + 1);

                if ($currentPage <= 2) {
                    $end = min($lastPage, 3);
                }
                if ($currentPage >= $lastPage - 1) {
                    $start = max(1, $lastPage - 2);
                }
            @endphp

            @if($start > 1)
                <a href="{{ $products->url(1) }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r border-gray-200 transition flex items-center">1</a>
                @if($start > 2)
                    <span class="px-2.5 py-1.5 text-gray-400 border-r border-gray-200 flex items-center">...</span>
                @endif
            @endif

            @foreach (range($start, $end) as $page)
                @if ($page == $currentPage)
                    <span class="px-3 py-1.5 bg-gray-100 font-bold text-gray-800 border-r last:border-r-0 border-gray-200 flex items-center">{{ $page }}</span>
                @else
                    <a href="{{ $products->url($page) }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r last:border-r-0 border-gray-200 transition flex items-center">{{ $page }}</a>
                @endif
            @endforeach

            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span class="px-2.5 py-1.5 text-gray-400 border-r border-gray-200 flex items-center">...</span>
                @endif
                <a href="{{ $products->url($lastPage) }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 border-r last:border-r-0 border-gray-200 transition flex items-center">{{ $lastPage }}</a>
            @endif

            @if ($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="px-3 py-1.5 text-gray-600 hover:bg-gray-50 transition flex items-center">&rsaquo;</a>
            @else
                <span class="px-3 py-1.5 text-gray-300 cursor-not-allowed flex items-center">&rsaquo;</span>
            @endif
        </div>
        @endif
    </div>
    @endif
</div>

<!-- Custom Popup Modal -->
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
            Apakah Anda yakin ingin menghapus produk ini?
        </p>
        
        <div class="flex gap-3 w-full">                
            <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 border border-gray-300 text-gray-600 rounded-full text-xs font-semibold cursor-pointer transition hover:bg-gray-50 active:scale-95">
                Batal
            </button>
            <button type="button" id="btn-confirm-delete" class="flex-1 py-2.5 bg-[#c40000] hover:bg-[#a30000] text-white rounded-full text-xs font-bold text-center cursor-pointer transition active:scale-95 shadow-md">
                Hapus
            </button>
        </div>
    </div>
</div>
@endpush

<script>
    let currentDeleteForm = null;

    // Fungsi untuk menutup alert sukses dengan animasi smooth
    function closeAlertSuccess() {
        const alert = document.getElementById('alert-success');
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }
    }

    function resetPageAndFilter(triggeredBy = '') {
        const search = document.getElementById('search-input').value.trim(); 
        const category = document.getElementById('category-filter').value;
        let subcategory = document.getElementById('subcategory-filter').value;
        const status = document.getElementById('status-filter').value;

        if (triggeredBy === 'category') {
            subcategory = 'all';
        }

        const params = new URLSearchParams();

        if (search !== '') params.append('search', search);
        if (category && category !== 'all') params.append('category', category);
        if (subcategory && subcategory !== 'all') params.append('subcategory', subcategory);
        if (status && status !== 'all') params.append('status', status);

        window.location.href = window.location.pathname + '?' + params.toString();
    }

    function openDeleteModal(productName, form) {
        currentDeleteForm = form;
        document.getElementById('deleteModalMessage').innerText = `Apakah Anda yakin ingin menghapus produk "${productName}"?`;
        
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
        const searchInput = document.getElementById('search-input');
        const urlParams = new URLSearchParams(window.location.search);
        
        // Auto-hide alert sukses setelah 4 detik (4000 ms)
        const alertSuccess = document.getElementById('alert-success');
        if (alertSuccess) {
            setTimeout(() => {
                closeAlertSuccess();
            }, 4000);
        }

        // Memuat query search yang ada di URL saat halaman pertama kali dimuat
        if (urlParams.has('search')) {
            searchInput.value = urlParams.get('search');
            searchInput.focus();
            const valLength = searchInput.value.length;
            searchInput.setSelectionRange(valLength, valLength);
        }

        // Listener untuk mendeteksi penekanan tombol Enter pada kolom pencarian
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                resetPageAndFilter();
            }
        });

        // Event listener untuk modal hapus
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const targetForm = document.getElementById(`form-delete-${productId}`);

                openDeleteModal(productName, targetForm);
            });
        });

        document.getElementById('btn-confirm-delete').addEventListener('click', function() {
            if (currentDeleteForm) {
                currentDeleteForm.submit();
            }
        });
    });
</script>
@endsection