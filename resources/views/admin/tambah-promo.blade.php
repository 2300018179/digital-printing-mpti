@extends('layouts.admin')

@section('title', 'Tambah Promo Baru')

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">Tambah Promo Baru</h2>
        <p class="text-[11px] text-gray-400 mt-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a> &nbsp;/&nbsp; 
            <a href="{{ route('admin.promo') }}" class="hover:underline">Data Promo</a> &nbsp;/&nbsp; 
            <span>Tambah Promo</span>
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 max-w-4xl">
        <form action="{{ route('admin.promo.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs font-medium text-gray-700">
                
                {{-- Nama Promo --}}
                <div class="md:col-span-2 flex flex-col gap-1.5">
                    <label for="nama" class="font-semibold text-gray-800">Nama Promo</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Contoh: Promo Diskon Kemerdekaan" class="w-full p-3 border @error('nama') border-red-500 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-red-500">
                    @error('nama')
                        <span class="text-red-500 text-[10px]">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Kode Promo --}}
                <div class="flex flex-col gap-1.5">
                    <label for="kode" class="font-semibold text-gray-800">Kode Promo</label>
                    <input type="text" name="kode" id="kode" value="{{ old('kode') }}" required placeholder="Contoh: MERDEKA79" class="w-full p-3 border @error('kode') border-red-500 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-red-500 uppercase">
                    @error('kode')
                        <span class="text-red-500 text-[10px]">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Diskon --}}
                <div class="flex flex-col gap-1.5">
                    <label for="diskon" class="font-semibold text-gray-800">Besar Diskon (%)</label>
                    <input type="number" name="diskon" id="diskon" value="{{ old('diskon') }}" min="1" max="100" required placeholder="Contoh: 15" class="w-full p-3 border @error('diskon') border-red-500 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-red-500">
                    @error('diskon')
                        <span class="text-red-500 text-[10px]">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tanggal Mulai --}}
                <div class="flex flex-col gap-1.5">
                    <label for="tanggal_mulai" class="font-semibold text-gray-800">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required class="w-full p-3 border @error('tanggal_mulai') border-red-500 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-red-500">
                    @error('tanggal_mulai')
                        <span class="text-red-500 text-[10px]">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tanggal Selesai --}}
                <div class="flex flex-col gap-1.5">
                    <label for="tanggal_selesai" class="font-semibold text-gray-800">Tanggal Berakhir</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required class="w-full p-3 border @error('tanggal_selesai') border-red-500 @else border-gray-200 @enderror rounded-xl focus:outline-none focus:border-red-500">
                    @error('tanggal_selesai')
                        <span class="text-red-500 text-[10px]">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="md:col-span-2 flex flex-col gap-1.5">
                    <label for="status" class="font-semibold text-gray-800">Status Promo</label>
                    <select name="status" id="status" class="w-full p-3 border border-gray-200 rounded-xl bg-white focus:outline-none focus:border-red-500">
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end gap-2 border-t border-gray-100 mt-6 pt-4">
                <a href="{{ route('admin.promo') }}" class="px-5 py-2.5 border border-gray-300 text-gray-600 rounded-full hover:bg-gray-100 transition no-underline flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-red-700 hover:bg-red-800 text-white font-semibold rounded-full shadow-sm transition cursor-pointer">
                    Simpan Promo
                </button>
            </div>
        </form>
    </div>
@endsection