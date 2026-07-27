@extends('layouts.admin')

@section('title', 'Tambah Kategori - Fantastic Digital Printing')

@section('content')
<div class="flex flex-col max-w-4xl space-y-6">
    
    {{-- Header Halaman --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">Tambah Kategori Baru</h2>
        <p class="text-xs text-gray-500 mt-1">Buat kategori dan sub kategori baru untuk produk cetak Anda.</p>
    </div>

    {{-- Form Box Putih --}}
    <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6 max-w-lg">
        <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Input Nama Kategori Utama --}}
            <div class="space-y-2">
                <label for="kategori_name" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                    Nama Kategori Utama <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="kategori_name" 
                       id="kategori_name" 
                       list="kategori_list"
                       value="{{ old('kategori_name') }}" 
                       required 
                       placeholder="Contoh: Print On Paper"
                       autocomplete="off"
                       class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition">
                
                {{-- Datalist rekomendasi kategori yang sudah ada (jika dikirim dari controller) --}}
                @if(isset($kategoris))
                    <datalist id="kategori_list">
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->name }}">
                        @endforeach
                    </datalist>
                @endif

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
                       value="{{ old('name') }}" 
                       required 
                       placeholder="Contoh: Print A3+"
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
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>

</div>
@endsection