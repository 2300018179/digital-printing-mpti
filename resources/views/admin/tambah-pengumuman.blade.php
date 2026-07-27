@extends('layouts.admin')

@section('title', 'Tambah Pengumuman Baru - Fantastic Digital Printing')

@section('content')
<div class="flex flex-col max-w-4xl space-y-6">
    
    {{-- Header Halaman & Deskripsi --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">
            Tambah Pengumuman Baru
        </h2>
        <p class="text-xs text-gray-500 mt-1">
            Buat pengumuman atau informasi terbaru yang akan ditampilkan kepada pelanggan.
        </p>
    </div>

    {{-- Form Box Putih --}}
    <div class="bg-white border border-red-300 rounded-2xl shadow-sm p-6">
        <form action="{{ route('admin.pengumuman.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs font-medium text-gray-700">
                
                {{-- Judul Pengumuman (Full 2 Kolom) --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="judul" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Judul Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="judul" 
                           id="judul"
                           value="{{ old('judul') }}" 
                           required 
                           placeholder="Contoh: Perubahan Jam Operasional Hari Raya"
                           class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition">
                    
                    @error('judul')
                        <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Tayang --}}
                <div class="space-y-2">
                    <label for="tanggal" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Tanggal Tayang <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal" 
                           id="tanggal"
                           value="{{ old('tanggal', date('Y-m-d')) }}" 
                           required 
                           class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition cursor-pointer">
                    
                    @error('tanggal')
                        <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Informasi --}}
                <div class="space-y-2">
                    <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Status Informasi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="status" 
                                id="status" 
                                class="w-full px-4 py-2.5 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition appearance-none cursor-pointer">
                            <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500 text-[10px]">▼</span>
                    </div>

                    @error('status')
                        <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Isi / Detail Pengumuman (Full 2 Kolom) --}}
                <div class="md:col-span-2 space-y-2">
                    <label for="isi" class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Isi / Detail Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <textarea name="isi" 
                              id="isi" 
                              rows="5" 
                              required 
                              placeholder="Tuliskan detail pengumuman atau informasi toko secara lengkap di sini..."
                              class="w-full p-4 text-xs font-medium bg-white border border-red-300 rounded-xl focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 text-gray-700 shadow-sm transition resize-none overflow-y-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">{{ old('isi') }}</textarea>
                    
                    @error('isi')
                        <p class="text-red-500 text-[10px] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.promo', ['tab' => 'info']) }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-full text-xs font-bold transition shadow-sm no-underline flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-red-700 hover:bg-red-800 text-white rounded-full text-xs font-bold transition shadow-sm active:scale-95 cursor-pointer">
                    Simpan Pengumuman
                </button>
            </div>
        </form>
    </div>

</div>
@endsection