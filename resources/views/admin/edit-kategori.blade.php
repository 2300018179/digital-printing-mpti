@extends('layouts.admin')

@section('title', 'Edit Kategori - Fantastic Digital Printing')

@section('content')
<div class="flex flex-col max-w-4xl space-y-6">
    
    {{-- Header Halaman --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">Edit Kategori</h2>
        <p class="text-xs text-gray-500 mt-1">Perbarui nama kategori utama dan sub kategori produk cetak Anda.</p>
    </div>

    {{-- Form Box Putih --}}
    <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6 max-w-lg">
        <form action="{{ route('admin.kategori.update', $subKategori->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Select / Dropdown Kategori Utama --}}
            <div class="space-y-2">
                <label for="kategori_id" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                    Kategori Utama <span class="text-red-500">*</span>
                </label>
                
                @if(isset($kategoris) && count($kategoris) > 0)
                    {{-- Di-wrap dengan relative untuk menempatkan ikon panah bawaan --}}
                    <div class="relative">
                        <select name="kategori_id" 
                                id="kategori_id" 
                                required 
                                class="w-full appearance-none px-4 py-2.5 pr-10 text-xs font-semibold bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition cursor-pointer">
                            <option value="" disabled>-- Pilih Kategori Utama --</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id', $subKategori->kategori_id) == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-gray-500 text-[10px]">▼</span>
                    </div>
                @else
                    {{-- Input Teks jika Kategori Utama diset via String --}}
                    <input type="text" 
                           name="kategori_name" 
                           id="kategori_name" 
                           value="{{ old('kategori_name', $subKategori->kategori->name ?? '') }}" 
                           required 
                           placeholder="Masukkan nama kategori utama"
                           class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition">
                @endif
                
                @error('kategori_id')
                    <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                @enderror
                @error('kategori_name')
                    <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Nama Sub Kategori --}}
            <div class="space-y-2 pt-1">
                <label for="name" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                    Nama Sub Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $subKategori->name) }}" 
                       required 
                       placeholder="Masukkan nama sub kategori"
                       class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition">
                
                @error('name')
                    <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.kategori') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-full text-xs font-bold transition shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-red-700 hover:bg-red-800 text-white rounded-full text-xs font-bold transition shadow-sm active:scale-95 cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection