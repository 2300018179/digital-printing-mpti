@extends('layouts.admin')

@section('title', 'Tambah Produk - Fantastic Digital Printing')

@section('content')
<div class="space-y-6">
    
    {{-- HEADER HALAMAN & DESKRIPSI --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">
            Tambah Produk Baru
        </h2>
        <p class="text-xs text-gray-500 mt-1">
            Tambahkan produk cetak baru beserta detail harga, kategori, dan gambar pendukung.
        </p>
    </div>

    <!-- Card Utama Form -->
    <div class="w-full bg-white p-6 rounded-2xl border border-red-300 shadow-sm">
        
        {{-- Menampilkan Error Validasi --}}
        @if ($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs font-semibold">
                <p class="font-bold mb-1">Terjadi kesalahan input:</p>
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM ACTION MENGARAH KE STORE --}}
        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-5">
                <!-- Baris 1: Nama Produk, Kategori, Sub Kategori -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    {{-- Kolom 1: Nama Produk --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required
                               value="{{ old('name') }}"
                               placeholder="Masukkan Nama Produk" 
                               class="w-full px-4 py-2.5 bg-white border border-red-300 rounded-xl text-xs font-medium focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 text-gray-700 shadow-sm transition">
                    </div>
                    
                    {{-- Kolom 2: Kategori Induk --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Kategori Induk <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="kategori-select" name="kategori_id" required class="w-full appearance-none px-4 py-2.5 bg-white border border-red-300 rounded-xl text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 text-gray-700 shadow-sm transition cursor-pointer">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->id }}" 
                                            data-subs="{{ json_encode($kat->subKategoris ?? $kat->sub_kategoris ?? []) }}"
                                            {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-gray-500 text-[10px]">▼</span>
                        </div>
                    </div>

                    {{-- Kolom 3: Sub Kategori --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Sub Kategori <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="sub-kategori-select" name="sub_kategori_id" required class="w-full appearance-none px-4 py-2.5 bg-white border border-red-300 rounded-xl text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 text-gray-700 shadow-sm transition cursor-pointer">
                                <option value="" disabled selected>Pilih Sub Kategori</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-gray-500 text-[10px]">▼</span>
                        </div>
                    </div>
                </div>

                <!-- Baris 2: Harga, Satuan, Minimum Order -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Harga <span class="text-red-500">*</span></label>
                        <input type="number" name="price" required min="0"
                               value="{{ old('price') }}"
                               placeholder="Rp. 0" 
                               class="w-full px-4 py-2.5 bg-white border border-red-300 rounded-xl text-xs font-medium focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 text-gray-700 shadow-sm transition">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Satuan Produk <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="unit" required class="w-full appearance-none px-4 py-2.5 bg-white border border-red-300 rounded-xl text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 text-gray-700 shadow-sm transition cursor-pointer">
                                <option value="lembar" {{ old('unit') == 'lembar' || old('unit') == 'lbr' ? 'selected' : '' }}>Lembar</option>
                                <option value="m" {{ old('unit') == 'm' ? 'selected' : '' }}>Meter (m)</option>
                                <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>Box</option>
                                <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-gray-500 text-[10px]">▼</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Minimum Order <span class="text-red-500">*</span></label>
                        <input type="number" name="minimum_order" required min="1"
                               value="{{ old('minimum_order', 1) }}"
                               class="w-full px-4 py-2.5 bg-white border border-red-300 rounded-xl text-xs font-medium focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 text-gray-700 shadow-sm transition">
                    </div>
                </div>

                <!-- Baris 3: Deskripsi -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Deskripsi Produk <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" placeholder="Masukkan deskripsi detail mengenai spesifikasi produk..." required
                              class="w-full px-4 py-2.5 bg-white border border-red-300 rounded-xl text-xs font-medium focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 text-gray-700 shadow-sm resize-none min-h-[100px] transition">{{ old('description') }}</textarea>
                    <p class="text-[10px] text-gray-400 mt-1">Jelaskan spesifikasi bahan, ukuran, dan opsi cetak secara singkat dan padat.</p>
                </div>

                <!-- Baris 4: Gambar & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 border-t border-gray-100 pt-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Gambar Produk</label>
                        <div onclick="document.getElementById('file-input').click()" 
                             class="border border-dashed border-red-300 rounded-xl p-4 flex flex-col items-center justify-center bg-white cursor-pointer hover:bg-gray-50 transition min-h-[115px] text-center shadow-sm relative overflow-hidden"
                             id="dropzone">
                            
                            <input type="file" id="file-input" name="image" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(event)">
                            
                            <div id="upload-text" class="space-y-1">
                                <span class="text-xl">📁</span>
                                <p class="text-[11px] font-semibold text-gray-600 leading-normal">
                                    Klik atau drag file untuk upload dari device<br><span class="text-gray-400 text-[10px] font-normal">Format PNG atau JPG (Maks. 2MB)</span>
                                </p>
                            </div>

                            <img id="image-preview" src="#" alt="Preview" class="absolute inset-0 w-full h-full object-contain p-2 bg-white hidden">
                        </div>
                    </div>
                    
                    <div class="flex flex-col justify-between">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Status Produk</label>
                            <div class="relative">
                                <select name="status" class="w-full appearance-none px-4 py-2.5 bg-white border border-red-300 rounded-xl text-xs font-semibold focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 text-gray-700 shadow-sm transition cursor-pointer">
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Aktif (Ditampilkan)</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Non-Aktif (Disembunyikan)</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-gray-500 text-[10px]">▼</span>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1">Produk non-aktif tidak akan muncul di katalog pelanggan.</p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex justify-end gap-3 pt-5 md:pt-0">
                            <a href="{{ route('admin.produk') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-full text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2.5 bg-red-700 hover:bg-red-800 text-white rounded-full text-xs font-bold transition shadow-sm active:scale-95 cursor-pointer flex items-center gap-1.5">
                                Simpan Produk
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Menyimpan ID sub-kategori jika ada 'old' input dari validasi yang gagal
    const currentSubKategoriId = @json(old('sub_kategori_id'));

    document.addEventListener('DOMContentLoaded', function() {
        const kategoriSelect = document.getElementById('kategori-select');
        
        kategoriSelect.addEventListener('change', updateSubKategoriOptions);

        if (kategoriSelect.value) {
            updateSubKategoriOptions();
        }
    });

    function updateSubKategoriOptions() {
        const kategoriSelect = document.getElementById('kategori-select');
        const subKategoriSelect = document.getElementById('sub-kategori-select');

        subKategoriSelect.innerHTML = '<option value="" disabled selected>Pilih Sub Kategori</option>';
        
        const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];
        
        if (selectedOption && selectedOption.getAttribute('data-subs')) {
            try {
                const subKategoris = JSON.parse(selectedOption.getAttribute('data-subs'));
                
                subKategoris.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.name;
                    
                    if (currentSubKategoriId && sub.id == currentSubKategoriId) {
                        option.selected = true;
                    }
                    subKategoriSelect.appendChild(option);
                });
            } catch (e) {
                console.error("Gagal memproses data sub kategori:", e);
            }
        }
    }

    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');
        const uploadText = document.getElementById('upload-text');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                uploadText.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection