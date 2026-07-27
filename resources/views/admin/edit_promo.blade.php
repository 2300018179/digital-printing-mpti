@extends('layouts.admin')

@section('title', 'Edit Promo - Fantastic Digital Printing')

@section('content')
<div class="flex flex-col max-w-4xl space-y-6">
    
    {{-- Header Halaman & Deskripsi --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">
            Edit Promo: {{ $promo->nama }}
        </h2>
        <p class="text-xs text-gray-500 mt-1">
            Perbarui rincian, besaran diskon, atau masa berlaku untuk promo ini.
        </p>
    </div>

    {{-- Form Box Putih --}}
    <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6">
        <form action="{{ route('admin.promo.update', $promo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs font-medium text-gray-700">
                
                {{-- Nama Promo (Full 2 Kolom) --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="nama" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Nama Promo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama"
                           value="{{ old('nama', $promo->nama) }}" 
                           required 
                           placeholder="Masukkan nama promo"
                           class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition">
                    
                    @error('nama')
                        <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kode Promo --}}
                <div class="space-y-2">
                    <label for="kode" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Kode Promo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="kode" 
                           id="kode"
                           value="{{ old('kode', $promo->kode) }}" 
                           required 
                           placeholder="Contoh: DISKON10"
                           class="w-full px-4 py-2.5 text-xs font-medium uppercase font-mono bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition">
                    
                    @error('kode')
                        <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Besar Diskon (%) --}}
                <div class="space-y-2">
                    <label for="diskon" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Besar Diskon (%) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="diskon" 
                           id="diskon"
                           min="1" 
                           max="100" 
                           value="{{ old('diskon', $promo->diskon) }}" 
                           required 
                           placeholder="Masukkan persentase diskon"
                           class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition">
                    
                    @error('diskon')
                        <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Mulai --}}
                <div class="space-y-2">
                    <label for="tanggal_mulai" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal_mulai" 
                           id="tanggal_mulai"
                           value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($promo->tanggal_mulai)->format('Y-m-d')) }}" 
                           required 
                           class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition cursor-pointer">
                    
                    @error('tanggal_mulai')
                        <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Berakhir --}}
                <div class="space-y-2">
                    <label for="tanggal_selesai" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Tanggal Berakhir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal_selesai" 
                           id="tanggal_selesai"
                           value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($promo->tanggal_selesai)->format('Y-m-d')) }}" 
                           required 
                           class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition cursor-pointer">
                    
                    @error('tanggal_selesai')
                        <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Promo (Full 2 Kolom) --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Status Promo <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="status" 
                                id="status" 
                                class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition appearance-none cursor-pointer">
                            <option value="Aktif" {{ old('status', $promo->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status', $promo->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500 text-[10px]">▼</span>
                    </div>

                    @error('status')
                        <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.promo', ['tab' => 'promo']) }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-full text-xs font-bold transition shadow-sm no-underline flex items-center justify-center">
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