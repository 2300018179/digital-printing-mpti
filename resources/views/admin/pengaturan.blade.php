@extends('layouts.admin')

@section('title', 'Pengaturan Toko - Fantastic Digital Printing')

@section('content')
{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800 tracking-wide">Pengaturan Toko</h2>
        <p class="text-xs text-gray-500 mt-1">Kelola profil toko, alamat, jam kerja, dan preferensi lainnya.</p>
    </div>
</div>

{{-- Tab Navigasi Horizontal (Compact / Menyesuaikan Isi) --}}
<div class="bg-white border border-red-200 rounded-xl p-1.5 flex items-center gap-2 shadow-xs w-fit my-6 overflow-x-auto">
    <button type="button" onclick="switchTab('informasi-toko', this)" id="btn-informasi-toko"
        class="tab-btn px-6 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-center bg-red-700 text-white shadow-xs whitespace-nowrap">
        Informasi Toko
    </button>
    <button type="button" onclick="switchTab('alamat-toko', this)" id="btn-alamat-toko"
        class="tab-btn px-6 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-center text-gray-700 hover:text-red-700 whitespace-nowrap">
        Alamat Toko
    </button>
    <button type="button" onclick="switchTab('jam-operasional', this)" id="btn-jam-operasional"
        class="tab-btn px-6 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-center text-gray-700 hover:text-red-700 whitespace-nowrap">
        Jam Operasional
    </button>
    <button type="button" onclick="switchTab('sosial-media', this)" id="btn-sosial-media"
        class="tab-btn px-6 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-center text-gray-700 hover:text-red-700 whitespace-nowrap">
        Sosial Media & Kontak
    </button>
    <button type="button" onclick="switchTab('metode-pembayaran', this)" id="btn-metode-pembayaran"
        class="tab-btn px-6 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-center text-gray-700 hover:text-red-700 whitespace-nowrap">
        Metode Pembayaran
    </button>
    <button type="button" onclick="switchTab('notifikasi', this)" id="btn-notifikasi"
        class="tab-btn px-6 py-2.5 rounded-lg text-xs font-bold transition-all duration-200 cursor-pointer text-center text-gray-700 hover:text-red-700 whitespace-nowrap">
        Notifikasi
    </button>
</div>

{{-- NOTIFIKASI SUKSES (FLASH MESSAGE) --}}
@if (session('success'))
<div id="alert-success" class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-between transition-all duration-300 shadow-sm">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
            ✓
        </div>
        <div>
            <h4 class="text-xs font-bold text-emerald-900">Berhasil Disimpan!</h4>
            <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
        </div>
    </div>
    <button type="button" onclick="document.getElementById('alert-success').remove()" class="text-emerald-500 hover:text-emerald-800 text-sm font-bold px-2 py-1 transition">
        ✕
    </button>
</div>
@endif

{{-- Container Form Utama (Diberi border border-red-200) --}}
<div class="bg-white p-6 rounded-2xl border border-red-200 shadow-sm">
    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data" id="form-pengaturan">
        @csrf
        
        {{-- INPUT HIDDEN UNTUK MENYIMPAN TAB AKTIF --}}
        <input type="hidden" name="active_tab" id="active_tab" value="{{ old('active_tab', 'informasi-toko') }}">

        {{-- TAB 1: INFORMASI TOKO --}}
        <div id="content-informasi-toko" class="tab-content grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Kolom Kiri -->
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800">Nama Toko</label>
                    <input type="text" name="nama_toko" 
                        value="{{ $settings['nama_toko'] ?? '' }}" 
                        placeholder="Masukkan Nama Toko" 
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-red-500 focus:bg-white rounded-xl text-xs font-medium text-gray-700 placeholder-gray-400 focus:outline-none transition">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800">Deskripsi Toko</label>
                    <textarea name="deskripsi_toko" rows="7" 
                            placeholder="Masukkan Deskripsi Toko" 
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-red-500 focus:bg-white rounded-xl text-xs font-medium text-gray-700 placeholder-gray-400 focus:outline-none transition resize-none">{{ $settings['deskripsi_toko'] ?? '' }}</textarea>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800">Logo Toko</label>
                    <input type="file" id="input-logo" name="logo_toko" accept="image/png, image/jpeg" class="hidden" onchange="previewImage(this, 'drop-zone-logo')">
                    
                    <div id="drop-zone-logo" 
                        onclick="document.getElementById('input-logo').click()"
                        class="border-2 border-dashed border-red-300 rounded-2xl p-4 text-center bg-red-50/20 hover:bg-red-50/50 transition cursor-pointer flex flex-col items-center justify-center h-32 relative overflow-hidden">
                        
                        @if(!empty($settings['logo_toko']))
                            <img src="{{ asset('storage/' . $settings['logo_toko']) }}" class="img-preview absolute inset-0 w-full h-full object-contain p-2 z-10">
                        @endif
                        
                        <div class="preview-placeholder flex flex-col items-center justify-center {{ !empty($settings['logo_toko']) ? 'opacity-0' : '' }}">
                            <span class="text-xl mb-1">🖼️</span>
                            <p class="text-[11px] font-medium text-gray-600 leading-tight">Klik atau drag file untuk upload<br><span class="text-gray-400 text-[10px]">JPG dan PNG</span></p>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $banners = json_decode($settings['banner_toko'] ?? '[]', true);
                if (!is_array($banners)) $banners = [];
            @endphp

            <!-- Baris Banner Toko -->
            <div class="space-y-3 col-span-1 lg:col-span-2">
                <div class="flex justify-between items-center">
                    <div>
                        <label class="text-xs font-bold text-gray-800">Banner Toko (Slider)</label>
                        <p class="text-[11px] text-gray-500">
                            Minimal 2 banner. Format: JPG, PNG, WEBP. <span class="text-red-600 font-bold">(Maksimal 2 MB per file)</span>
                        </p>
                    </div>
                    <button type="button" onclick="addBannerSlot()" class="px-3 py-1.5 bg-red-700 hover:bg-red-800 text-white text-xs font-semibold rounded-xl transition flex items-center gap-1 shadow-sm">
                        <span class="text-sm">+</span> Tambah Banner
                    </button>
                </div>

                @error('banners')
                    <p class="text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
                @error('banners.*')
                    <p class="text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror

                <input type="hidden" name="existing_banners[]" value="" disabled id="fallback-existing-banners">

                <div id="banner-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($banners as $index => $bannerPath)
                        <div class="banner-item space-y-1 relative group">
                            <input type="hidden" name="existing_banners[]" value="{{ $bannerPath }}">
                            <div class="border-2 border-red-200 rounded-2xl p-2 text-center bg-gray-50 h-32 relative overflow-hidden flex items-center justify-center">
                                <img src="{{ asset('storage/' . $bannerPath) }}" class="w-full h-full object-cover rounded-xl">
                                <button type="button" onclick="removeBannerSlot(this)" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md hover:bg-red-700 transition z-20">
                                    ✕
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TAB 2: ALAMAT TOKO --}}
        <div id="content-alamat-toko" class="tab-content hidden space-y-4 max-w-3xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800">Nama Jalan / Detail Alamat</label>
                    <input type="text" name="jalan_detail" value="{{ $settings['jalan_detail'] ?? '' }}" placeholder="Contoh: Jl. Raya Timur Wanadadi" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800">Desa / Kelurahan / Dusun</label>
                    <input type="text" name="desa_dusun" value="{{ $settings['desa_dusun'] ?? '' }}" placeholder="Contoh: Dusun Dua" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800">Kecamatan</label>
                    <input type="text" name="kecamatan" value="{{ $settings['kecamatan'] ?? '' }}" placeholder="Contoh: Wanadadi" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800">Kabupaten / Kota</label>
                    <input type="text" name="kota" value="{{ $settings['kota'] ?? '' }}" placeholder="Contoh: Banjarnegara" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800">Provinsi</label>
                    <input type="text" name="provinsi" value="{{ $settings['provinsi'] ?? '' }}" placeholder="Contoh: Jawa Tengah" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800">Kode Pos</label>
                    <input type="text" name="kode_pos" value="{{ $settings['kode_pos'] ?? '' }}" placeholder="Contoh: 53461" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-800 flex items-center gap-1">
                    <span>Tautan Google Maps</span>
                    <span class="text-[10px] font-normal text-gray-400">(Opsional)</span>
                </label>
                <div class="relative flex items-center">
                    <input type="text" name="link_google_maps" value="{{ $settings['link_google_maps'] ?? '' }}" placeholder="https://maps.app.goo.gl/..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-mono text-gray-600 focus:outline-none focus:border-red-500 focus:bg-white transition">
                </div>
            </div>
        </div>

        {{-- TAB 3: JAM OPERASIONAL --}}
        <div id="content-jam-operasional" class="tab-content hidden space-y-3 max-w-xl">
            <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs">
                <span class="font-semibold text-gray-700">Senin - Sabtu</span>
                <input type="text" name="jam_senin_sabtu" value="{{ $settings['jam_senin_sabtu'] ?? '' }}" class="border border-gray-300 rounded px-3 py-1.5 text-center w-40 focus:outline-none focus:border-red-500 bg-white">
            </div>

            <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs">
                <span class="font-semibold text-gray-700">Minggu / Hari Libur</span>
                <input type="text" name="jam_minggu" value="{{ $settings['jam_minggu'] ?? '' }}" class="border border-gray-300 rounded px-3 py-1.5 text-center w-40 focus:outline-none focus:border-red-500 bg-white">
            </div>
        </div>

        {{-- TAB 4: SOSIAL MEDIA & KONTAK --}}
        <div id="content-sosial-media" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 gap-4 max-w-3xl">
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-800">Instagram Username / URL</label>
                <input type="text" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" placeholder="fantastic.printing" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-800">Email Toko</label>
                <input type="email" name="email_toko" value="{{ $settings['email_toko'] ?? '' }}" placeholder="fantasticwnd@gmail.com" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-800">WhatsApp 1</label>
                <input type="text" name="wa_number_1" value="{{ $settings['wa_number_1'] ?? '' }}" placeholder="+62 851-1962-2615" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-800">WhatsApp 2 (Opsional)</label>
                <input type="text" name="wa_number_2" value="{{ $settings['wa_number_2'] ?? '' }}" placeholder="+62 812-2978-3247" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-red-500 focus:bg-white transition">
            </div>
        </div>

        {{-- TAB 5: METODE PEMBAYARAN --}}
        <div id="content-metode-pembayaran" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl">
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-800">Nama Pemilik Akun / Toko</label>
                    <input type="text" 
                        name="qris_nama_pemilik" 
                        value="{{ $settings['qris_nama_pemilik'] ?? '' }}" 
                        placeholder="Contoh: Fantastic Digital Printing" 
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:border-red-500 focus:bg-white outline-none transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-800">Upload QRIS</label>
                <input type="file" 
                    id="input-qris" 
                    name="qris_image" 
                    accept="image/png, image/jpeg" 
                    class="hidden" 
                    onchange="previewImage(this, 'drop-zone-qris')">
                
                <div id="drop-zone-qris" 
                    onclick="document.getElementById('input-qris').click()" 
                    class="border-2 border-dashed border-red-300 rounded-2xl p-4 text-center bg-red-50/20 hover:bg-red-50/50 transition cursor-pointer flex flex-col items-center justify-center h-44 relative overflow-hidden">
                    
                    @if(!empty($settings['qris_image']))
                        <img src="{{ asset('storage/' . $settings['qris_image']) }}" class="img-preview absolute inset-0 w-full h-full object-contain p-2 z-10">
                    @endif
                    
                    <div class="preview-placeholder flex flex-col items-center justify-center {{ !empty($settings['qris_image']) ? 'opacity-0' : '' }}">
                        <span class="text-2xl mb-1">📸</span>
                        <p class="text-[11px] font-medium text-gray-600">
                            Klik untuk upload QRIS<br>
                            <span class="text-gray-400 text-[10px]">JPG atau PNG</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 6: NOTIFIKASI --}}
        <div id="content-notifikasi" class="tab-content hidden space-y-2.5 max-w-xl">
            <input type="hidden" name="notif_struk_email" value="0">
            <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer text-xs font-semibold text-gray-700 hover:bg-gray-100 transition">
                <input type="checkbox" name="notif_struk_email" value="1" {{ ($settings['notif_struk_email'] ?? 0) == 1 ? 'checked' : '' }} class="accent-red-700 w-4 h-4 rounded"> 
                Kirim struk otomatis ke email pelanggan setelah bayar
            </label>

            <input type="hidden" name="notif_admin_order" value="0">
            <label class="flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-xl cursor-pointer text-xs font-semibold text-gray-700 hover:bg-gray-100 transition">
                <input type="checkbox" name="notif_admin_order" value="1" {{ ($settings['notif_admin_order'] ?? 0) == 1 ? 'checked' : '' }} class="accent-red-700 w-4 h-4 rounded"> 
                Beritahu Admin via email jika ada orderan masuk baru
            </label>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center justify-end gap-3 pt-5 border-t border-gray-100 mt-6">
            <button type="button" onclick="handleBatal()" class="px-7 py-2.5 border border-gray-300 text-gray-700 hover:bg-gray-100 font-bold text-xs rounded-full transition shadow-sm">
                Batal
            </button>
            <button type="submit" class="px-7 py-2.5 bg-red-700 hover:bg-red-800 text-white font-bold text-xs rounded-full transition shadow-sm">
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    function switchTab(tabId, element) {
        // 1. Sembunyikan semua tab content
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => content.classList.add('hidden'));

        // 2. Tampilkan tab content yang dipilih
        const targetContent = document.getElementById('content-' + tabId);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }

        // 3. Reset gaya SEMUA tombol ke status non-aktif (Warna Gray + Hover Red)
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(btn => {
            btn.classList.remove('bg-red-700', 'text-white', 'shadow-xs');
            btn.classList.add('text-gray-700', 'hover:text-red-700');
        });

        // 4. Aktifkan gaya tombol yang dipilih (Warna Merah)
        if (element) {
            element.classList.remove('text-gray-700', 'hover:text-red-700');
            element.classList.add('bg-red-700', 'text-white', 'shadow-xs');
        }

        // 5. Simpan tab aktif ke Input Hidden dan URL Hash Fragment
        const activeTabInput = document.getElementById('active_tab');
        if (activeTabInput) {
            activeTabInput.value = tabId;
        }
        
        window.location.hash = tabId;
    }

    // Eksekusi Otomatis Saat Halaman Selesai Di-load / Di-refresh
    document.addEventListener("DOMContentLoaded", function() {
        const currentHash = window.location.hash.replace('#', '');
        const savedTab = currentHash || document.getElementById('active_tab').value;

        if (savedTab) {
            const activeBtn = document.getElementById('btn-' + savedTab);
            if (activeBtn) {
                switchTab(savedTab, activeBtn);
            }
        }

        // Otomatis menghilangkan alert sukses setelah 5 detik (opsional)
        const alertSuccess = document.getElementById('alert-success');
        if (alertSuccess) {
            setTimeout(() => {
                alertSuccess.style.opacity = '0';
                setTimeout(() => alertSuccess.remove(), 300);
            }, 5000);
        }
    });

    function previewImage(input, zoneId) {
        const zone = document.getElementById(zoneId);
        const file = input.files[0];

        if (file && (file.type === "image/jpeg" || file.type === "image/png")) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let imgPreview = zone.querySelector('.img-preview');
                if (!imgPreview) {
                    imgPreview = document.createElement('img');
                    imgPreview.className = 'img-preview absolute inset-0 w-full h-full object-contain p-2 z-10';
                    zone.appendChild(imgPreview);
                }
                imgPreview.src = e.target.result;
                
                const placeholder = zone.querySelector('.preview-placeholder');
                if (placeholder) placeholder.classList.add('opacity-0');
            }
            reader.readAsDataURL(file);
        }
    }

    function handleBatal() {
        if(confirm('Batalkan perubahan?')) {
            document.getElementById('form-pengaturan').reset();
            document.querySelectorAll('.img-preview').forEach(img => img.remove());
            document.querySelectorAll('.preview-placeholder').forEach(p => p.classList.remove('opacity-0'));
        }
    }

    function addBannerSlot() {
        const container = document.getElementById('banner-container');
        const id = Date.now();

        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.name = 'banners[]';
        fileInput.accept = 'image/png, image/jpeg, image/webp';
        fileInput.className = 'hidden';
        fileInput.id = `input-banner-${id}`;

        fileInput.onchange = function () {
            if (fileInput.files && fileInput.files[0]) {
                const file = fileInput.files[0];
                const maxSize = 2 * 1024 * 1024; // 2 MB

                if (file.size > maxSize) {
                    alert(`Ukuran file "${file.name}" terlalu besar (${(file.size / (1024 * 1024)).toFixed(2)} MB).\nMaksimal ukuran file adalah 2 MB!`);
                    fileInput.remove();
                    return;
                }

                const html = `
                    <div class="banner-item space-y-1 relative group" id="item-banner-${id}">
                        <div id="preview-${id}" onclick="document.getElementById('input-banner-${id}').click()" class="border-2 border-dashed border-red-300 rounded-2xl p-2 text-center bg-red-50/20 hover:bg-red-50/50 transition cursor-pointer flex flex-col items-center justify-center h-32 relative overflow-hidden">
                            <div class="preview-placeholder hidden flex flex-col items-center justify-center">
                                <span class="text-lg">✨</span>
                                <p class="text-[10px] font-medium text-gray-600">Klik untuk upload banner</p>
                            </div>
                            <img class="img-preview absolute inset-0 w-full h-full object-cover z-10">
                            <button type="button" onclick="event.stopPropagation(); removeBannerSlot(this);" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md hover:bg-red-700 transition z-20">
                                ✕
                            </button>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);

                const slotItem = document.getElementById(`item-banner-${id}`);
                slotItem.prepend(fileInput);

                previewDynamicBanner(fileInput, `preview-${id}`);
            } else {
                fileInput.remove();
            }
        };

        fileInput.click();
    }

    function removeBannerSlot(btn) {
        btn.closest('.banner-item').remove();
    }

    function previewDynamicBanner(input, containerId) {
        const container = document.getElementById(containerId);
        const preview = container.querySelector('.img-preview');
        const placeholder = container.querySelector('.preview-placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush