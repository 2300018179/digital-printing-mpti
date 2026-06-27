<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Toko - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-4">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 object-contain">
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-gray-700">Selamat Datang, <strong class="text-gray-900">Admin</strong></span>
            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300">
                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
        </div>
    </header>

    <div class="flex flex-1">
        <aside class="w-64 bg-red-700 text-white flex flex-col min-h-[calc(100vh-57px)] sticky top-[57px]">
            <div class="py-6 px-3">
                <nav class="space-y-1">
                    <button type="button" onclick="switchTab('informasi-toko', this)" class="tab-btn w-full text-left bg-red-800 font-bold flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Informasi Toko
                    </button>
                    <button type="button" onclick="switchTab('alamat-toko', this)" class="tab-btn w-full text-left hover:bg-red-600/40 font-medium flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Alamat Toko
                    </button>
                    <button type="button" onclick="switchTab('jam-operasional', this)" class="tab-btn w-full text-left hover:bg-red-600/40 font-medium flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Jam Operasional
                    </button>
                    <button type="button" onclick="switchTab('sosial-media', this)" class="tab-btn w-full text-left hover:bg-red-600/40 font-medium flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Sosial Media
                    </button>
                    <button type="button" onclick="switchTab('metode-pembayaran', this)" class="tab-btn w-full text-left hover:bg-red-600/40 font-medium flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Metode Pembayaran
                    </button>
                    <button type="button" onclick="switchTab('notifikasi', this)" class="tab-btn w-full text-left hover:bg-red-600/40 font-medium flex items-center gap-3 px-4 py-3.5 rounded-xl text-xs tracking-wide transition">
                        Notifikasi
                    </button>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-10 relative flex flex-col justify-between min-h-[calc(100vh-57px)]">
            
            <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data" id="form-pengaturan">
            @csrf
                
                <div id="content-informasi-toko" class="tab-content grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                            <h2 class="text-xl font-bold text-gray-900 tracking-wide">Informasi Toko</h2>
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 hover:bg-gray-100 rounded-full text-xs font-bold text-gray-600 transition shadow-sm whitespace-nowrap">
                                ← Kembali ke Dashboard
                            </a>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Nama Toko</label>
                            <input type="text" name="nama_toko" 
                                value="{{ $settings['nama_toko'] ?? '' }}" 
                                placeholder="Masukkan Nama Toko" 
                                class="w-full px-4 py-3 bg-white border border-gray-300 focus:border-red-500 rounded-xl text-xs font-medium text-gray-700 placeholder-gray-400 focus:outline-none transition shadow-sm">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Deskripsi Toko</label>
                            <textarea name="deskripsi_toko" rows="8" 
                                    placeholder="Masukkan Deskripsi Toko" 
                                    class="w-full px-4 py-3 bg-white border border-gray-300 focus:border-red-500 rounded-2xl text-xs font-medium text-gray-700 placeholder-gray-400 focus:outline-none transition shadow-sm resize-none">{{ $settings['deskripsi_toko'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="space-y-6 lg:mt-[68px]">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Logo Toko</label>
                            <input type="file" id="input-logo" name="logo_toko" accept="image/png, image/jpeg" class="hidden" onchange="previewImage(this, 'drop-zone-logo')">
                            
                            <div id="drop-zone-logo" 
                                onclick="document.getElementById('input-logo').click()"
                                class="border-2 border-dashed border-red-400 rounded-2xl p-6 text-center bg-white hover:bg-red-50/30 transition cursor-pointer flex flex-col items-center justify-center h-36 relative overflow-hidden">
                                
                                @if(isset($settings['logo_toko']))
                                    <img src="{{ asset('storage/' . $settings['logo_toko']) }}" class="img-preview absolute inset-0 w-full h-full object-cover z-10">
                                @endif
                                
                                <div class="preview-placeholder flex flex-col items-center justify-center {{ isset($settings['logo_toko']) ? 'opacity-0' : '' }}">
                                    <span class="text-lg mb-1">🖼️</span>
                                    <p class="text-[10px] font-medium text-gray-600 leading-relaxed">Klik atau drag file untuk upload<br><span class="text-gray-400">JPG dan PNG</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Banner Toko</label>
                            <input type="file" id="input-banner" name="banner_toko" accept="image/png, image/jpeg" class="hidden" onchange="previewImage(this, 'drop-zone-banner')">
                            
                            <div id="drop-zone-banner" 
                                onclick="document.getElementById('input-banner').click()"
                                class="border-2 border-dashed border-red-400 rounded-2xl p-6 text-center bg-white hover:bg-red-50/30 transition cursor-pointer flex flex-col items-center justify-center h-36 relative overflow-hidden">
                                
                                @if(isset($settings['banner_toko']))
                                    <img src="{{ asset('storage/' . $settings['banner_toko']) }}" class="img-preview absolute inset-0 w-full h-full object-cover z-10">
                                @endif
                                
                                <div class="preview-placeholder flex flex-col items-center justify-center {{ isset($settings['banner_toko']) ? 'opacity-0' : '' }}">
                                    <span class="text-lg mb-1">✨</span>
                                    <p class="text-[10px] font-medium text-gray-600 leading-relaxed">Klik atau drag file untuk upload<br><span class="text-gray-400">JPG dan PNG</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="content-alamat-toko" class="tab-content hidden space-y-6 max-w-4xl">
                    <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                        <h2 class="text-xl font-bold text-gray-900 tracking-wide">Alamat Toko</h2>
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 hover:bg-gray-100 rounded-full text-xs font-bold text-gray-600 transition shadow-sm whitespace-nowrap">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                    
                    <div class="space-y-2 max-w-xl">
                        <label class="text-xs font-bold text-gray-800">Alamat Lengkap Toko</label>
                        <input type="text" name="alamat_lengkap" 
                            value="{{ $settings['alamat_lengkap'] ?? '' }}" 
                            placeholder="Jl. Raya Digital Printing No. 88, Kota" 
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-red-500 transition shadow-sm">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 max-w-xl">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Kota / Kabupaten</label>
                            <input type="text" name="kota" 
                                value="{{ $settings['kota'] ?? '' }}" 
                                placeholder="Surabaya" 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-red-500 transition shadow-sm">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Kode Pos</label>
                            <input type="text" name="kode_pos" 
                                value="{{ $settings['kode_pos'] ?? '' }}" 
                                placeholder="60111" 
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-red-500 transition shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2 max-w-xl">
                        <label class="text-xs font-bold text-gray-800 flex items-center gap-1">
                            <span>Tautan Google Maps</span>
                            <span class="text-[10px] font-normal text-gray-400">(Opsional untuk memudahkan akses rute)</span>
                        </label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-xs">🗺️</span>
                            <input type="url" name="link_google_maps" 
                                value="{{ $settings['link_google_maps'] ?? '' }}" 
                                placeholder="https://maps.google.com/..." 
                                class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-xl text-xs font-mono text-gray-600 placeholder-gray-400 focus:outline-none focus:border-red-500 transition shadow-sm">
                        </div>
                    </div>
                </div>

                <div id="content-jam-operasional" class="tab-content hidden space-y-6 max-w-4xl">
                    <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                        <h2 class="text-xl font-bold text-gray-900 tracking-wide">Jam Operasional Toko</h2>
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 hover:bg-gray-100 rounded-full text-xs font-bold text-gray-600 transition shadow-sm whitespace-nowrap">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                    
                    <div class="space-y-3 max-w-xl">
                        <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl text-xs">
                            <span class="font-semibold text-gray-700">Senin - Jumat</span>
                            <input type="text" 
                                name="jam_senin_jumat" 
                                value="{{ $settings['jam_senin_jumat'] ?? '08:00 - 21:00' }}" 
                                class="border border-gray-300 rounded px-2 py-1 text-center w-32 focus:outline-none focus:border-red-500">
                        </div>

                        <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl text-xs">
                            <span class="font-semibold text-gray-700">Sabtu</span>
                            <input type="text" 
                                name="jam_sabtu" 
                                value="{{ $settings['jam_sabtu'] ?? '09:00 - 17:00' }}" 
                                class="border border-gray-300 rounded px-2 py-1 text-center w-32 focus:outline-none focus:border-red-500">
                        </div>

                        <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl text-xs">
                            <span class="font-semibold text-gray-700">Minggu / Hari Libur</span>
                            <input type="text" 
                                name="jam_minggu" 
                                value="{{ $settings['jam_minggu'] ?? 'Tutup' }}" 
                                class="border border-gray-300 rounded px-2 py-1 text-center w-32 focus:outline-none focus:border-red-500">
                        </div>
                    </div>
                </div>

                <div id="content-sosial-media" class="tab-content hidden space-y-6 max-w-4xl">
                    <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                        <h2 class="text-xl font-bold text-gray-900 tracking-wide">Sosial Media</h2>
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 hover:bg-gray-100 rounded-full text-xs font-bold text-gray-600 transition shadow-sm whitespace-nowrap">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Instagram</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-xs">📷</span>
                                <input type="text" name="ig_link" 
                                    value="{{ $settings['ig_link'] ?? '' }}" 
                                    placeholder="@username_toko" 
                                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-red-500 transition shadow-sm">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">WhatsApp</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-xs">💬</span>
                                <input type="text" name="wa_number" 
                                    value="{{ $settings['wa_number'] ?? '' }}" 
                                    placeholder="628123456789" 
                                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-red-500 transition shadow-sm">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Facebook</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-xs">👥</span>
                                <input type="text" name="fb_link" 
                                    value="{{ $settings['fb_link'] ?? '' }}" 
                                    placeholder="facebook.com/namatoko" 
                                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-red-500 transition shadow-sm">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">TikTok</label>
                            <div class="relative flex items-center">
                                <span class="absolute left-4 text-xs">🎵</span>
                                <input type="text" name="tiktok_link" 
                                    value="{{ $settings['tiktok_link'] ?? '' }}" 
                                    placeholder="@username_tiktok" 
                                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-red-500 transition shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="content-metode-pembayaran" class="tab-content hidden space-y-6 max-w-4xl">
                    <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                        <h2 class="text-xl font-bold text-gray-900 tracking-wide">Metode Pembayaran (QRIS)</h2>
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 hover:bg-gray-100 rounded-full text-xs font-bold text-gray-600 transition shadow-sm whitespace-nowrap">
                            ← Kembali ke Dashboard
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl">
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-800">Nama Pemilik Akun / Toko</label>
                                <input type="text" name="qris_nama_pemilik" 
                                    value="{{ $settings['qris_nama_pemilik'] ?? '' }}" 
                                    placeholder="Contoh: Toko Digital Printing" 
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl text-xs focus:border-red-500 outline-none transition shadow-sm">
                            </div>
                            
                            <p class="text-[11px] text-gray-500 leading-relaxed bg-blue-50 p-3 rounded-lg">
                                <strong>Tips:</strong> Nama yang dimasukkan di sini akan muncul saat pelanggan melakukan pembayaran melalui QRIS untuk memverifikasi bahwa pembayaran ditujukan ke pihak yang benar.
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-800">Upload QRIS</label>
                            <input type="file" id="input-qris" name="qris_image" accept="image/png, image/jpeg" class="hidden" onchange="previewImage(this, 'drop-zone-qris')">
                            
                            <div id="drop-zone-qris" 
                                onclick="document.getElementById('input-qris').click()"
                                class="border-2 border-dashed border-red-400 rounded-2xl p-6 text-center bg-white hover:bg-red-50/30 transition cursor-pointer flex flex-col items-center justify-center h-48 relative overflow-hidden">
                                
                                @if(isset($settings['qris_image']))
                                    <img src="{{ asset('storage/' . $settings['qris_image']) }}" class="absolute inset-0 w-full h-full object-contain p-2 z-10">
                                @endif
                                
                                <div class="preview-placeholder flex flex-col items-center justify-center {{ isset($settings['qris_image']) ? 'opacity-0' : '' }}">
                                    <span class="text-2xl mb-2">📸</span>
                                    <p class="text-[10px] font-medium text-gray-600 leading-relaxed">Klik untuk upload gambar QRIS<br><span class="text-gray-400">JPG atau PNG</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="content-notifikasi" class="tab-content hidden space-y-6 max-w-4xl">
                    <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                        <h2 class="text-xl font-bold text-gray-900 tracking-wide">Sistem Notifikasi</h2>
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 border border-gray-300 hover:bg-gray-100 rounded-full text-xs font-bold text-gray-600 transition shadow-sm whitespace-nowrap">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                    
                    <div class="space-y-2 max-w-xl">
                        <input type="hidden" name="notif_struk_email" value="0">
                        <label class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl cursor-pointer text-xs font-semibold">
                            <input type="checkbox" name="notif_struk_email" value="1" 
                                {{ ($settings['notif_struk_email'] ?? 0) == 1 ? 'checked' : '' }} 
                                class="accent-red-600 w-4 h-4"> 
                            Kirim struk otomatis ke email pelanggan setelah bayar
                        </label>

                        <input type="hidden" name="notif_admin_order" value="0">
                        <label class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl cursor-pointer text-xs font-semibold">
                            <input type="checkbox" name="notif_admin_order" value="1" 
                                {{ ($settings['notif_admin_order'] ?? 0) == 1 ? 'checked' : '' }} 
                                class="accent-red-600 w-4 h-4"> 
                            Beritahu Admin via email jika ada orderan masuk baru
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-10 border-t border-gray-100 mt-12">
                    <button type="button" onclick="handleBatal()" class="px-8 py-2.5 border border-red-500 text-red-700 hover:bg-red-50 font-bold text-xs rounded-full transition shadow-sm min-w-[110px] text-center">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-2.5 bg-red-700 hover:bg-red-800 text-white font-bold text-xs rounded-full transition shadow-sm min-w-[110px] text-center">
                        Simpan
                    </button>
                </div>

            </form>
        </main>
    </div>

    <script>
        function switchTab(tabId, element) {
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.add('hidden'));

            document.getElementById('content-' + tabId).classList.remove('hidden');

            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => {
                btn.classList.remove('bg-red-800', 'font-bold');
                btn.classList.add('hover:bg-red-600/40', 'font-medium');
            });

            element.classList.remove('hover:bg-red-600/40', 'font-medium');
            element.classList.add('bg-red-800', 'font-bold');
        }

        // LOGIKA DRAG & DROP & PREVIEW
        function handleDragOver(event, zone) {
            event.preventDefault();
            zone.classList.add('bg-red-50', 'border-red-600');
        }

        function handleDragLeave(zone) {
            zone.classList.remove('bg-red-50', 'border-red-600');
        }

        function handleDrop(event, zone, inputId) {
            event.preventDefault();
            zone.classList.remove('bg-red-50', 'border-red-600');
            
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                const fileInput = document.getElementById(inputId);
                fileInput.files = files;
                previewImage(fileInput, zone.id);
            }
        }

        function previewImage(input, zoneId) {
            const zone = document.getElementById(zoneId);
            const file = input.files[0];

            if (file && (file.type === "image/jpeg" || file.type === "image/png")) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let imgPreview = zone.querySelector('.img-preview');
                    if (!imgPreview) {
                        imgPreview = document.createElement('img');
                        imgPreview.className = 'img-preview absolute inset-0 w-full h-full object-cover z-10';
                        zone.appendChild(imgPreview);
                    }
                    imgPreview.src = e.target.result;
                    
                    const placeholder = zone.querySelector('.preview-placeholder');
                    if (placeholder) placeholder.classList.add('opacity-0');
                }
                reader.readAsDataURL(file);
            } else {
                alert("Format file tidak didukung! Sila gunakan berkas gambar JPG atau PNG.");
            }
        }

        function handleSimpan(event) {
            event.preventDefault(); 
            alert('Sukses! Konfigurasi perubahan pengaturan toko berhasil disimpan ke dalam basis data.');
        }

        function handleBatal() {
            if(confirm('Apakah Anda yakin ingin membatalkan perubahan dan mereset form pengaturan?')) {
                document.getElementById('form-pengaturan').reset();
                document.querySelectorAll('.img-preview').forEach(img => img.remove());
                document.querySelectorAll('.preview-placeholder').forEach(p => p.classList.remove('opacity-0'));
            }
        }
    </script>
</body>
</html>