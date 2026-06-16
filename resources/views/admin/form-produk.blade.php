<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mode == 'tambah' ? 'Tambah' : 'Edit' }} Produk - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center">
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
        <aside class="w-64 bg-red-700 text-white flex flex-col justify-between min-h-[calc(100vh-57px)] sticky top-[57px]">
            <div class="py-4">
                <nav class="space-y-1 px-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🏠</span> Dashboard
                    </a>
                    <a href="{{ route('admin.produk') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
                        <span>🛍️</span> Produk
                    </a>
                    <a href="{{ route('admin.kategori') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🏷️</span> Kategori
                    </a>
                    <a href="{{ route('admin.pesanan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>📦</span> Pesanan
                    </a>
                    <a href="{{ route('admin.pembayaran') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>💳</span> Pembayaran
                    </a>
                    <a href="{{ route('admin.promo') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🏷️</span> Promo
                    </a>
                    <a href="{{ route('admin.pelanggan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>👥</span> Pelanggan
                    </a>
                    <a href="{{ route('admin.laporan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>📊</span> Laporan
                    </a>
                    <a href="{{ route('admin.pengaturan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>⚙️</span> Pengaturan
                    </a>
                </nav>
            </div>

            <div class="p-3 border-t border-red-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold bg-red-900 hover:bg-red-950 transition text-center justify-center uppercase tracking-wider">
                        <span>🚪</span> Log Out
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-8 max-w-5xl">
            <h2 class="text-xl font-bold text-gray-800 tracking-wide mb-8">
                {{ $mode == 'tambah' ? 'Tambah' : 'Edit' }} Produk
            </h2>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 text-xs rounded-xl shadow-sm">
                    <strong class="block mb-1">Gagal menyimpan data! Silakan periksa kembali:</strong>
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $mode == 'tambah' ? route('admin.produk.store') : route('admin.produk.update', $produk['id'] ?? '') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="space-y-6">
                
                @csrf
                @if($mode == 'edit')
                    @method('PUT') 
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-800 tracking-wide block">Nama Produk</label>
                        <input type="text" name="nama_produk" required
                               value="{{ $mode == 'edit' ? ($produk['name'] ?? '') : old('nama_produk') }}"
                               placeholder="Masukkan Nama Produk" 
                               class="w-full px-4 py-2.5 text-xs bg-white border border-red-400 rounded-xl focus:outline-none focus:ring-1 focus:ring-red-500 text-gray-700 placeholder-gray-400 shadow-sm">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-800 tracking-wide block">Kategori Produk</label>
                        <div class="relative">
                            <select name="kategori_produk" required class="appearance-none w-full bg-white border border-red-400 rounded-xl px-4 py-2.5 text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-red-500 shadow-sm">
                                <option value="" disabled {{ $mode == 'tambah' ? 'selected' : '' }}>Pilih Kategori</option>
                                <option value="Print On Paper" {{ (($mode == 'edit' && ($produk['kategori'] ?? '') == 'Print On Paper') || old('kategori_produk') == 'Print On Paper') ? 'selected' : '' }}>Print On Paper</option>
                                <option value="Print Stiker" {{ (($mode == 'edit' && ($produk['kategori'] ?? '') == 'Print Stiker') || old('kategori_produk') == 'Print Stiker') ? 'selected' : '' }}>Print Stiker</option>
                                <option value="Kalender" {{ (($mode == 'edit' && ($produk['kategori'] ?? '') == 'Kalender') || old('kategori_produk') == 'Kalender') ? 'selected' : '' }}>Kalender</option>
                                <option value="Banner & Spanduk" {{ (($mode == 'edit' && ($produk['kategori'] ?? '') == 'Banner & Spanduk') || old('kategori_produk') == 'Banner & Spanduk') ? 'selected' : '' }}>Banner & Spanduk</option>
                                <option value="Sablon" {{ (($mode == 'edit' && ($produk['kategori'] ?? '') == 'Sablon') || old('kategori_produk') == 'Sablon') ? 'selected' : '' }}>Sablon</option>
                                <option value="Sovenir" {{ (($mode == 'edit' && ($produk['kategori'] ?? '') == 'Sovenir') || old('kategori_produk') == 'Sovenir') ? 'selected' : '' }}>Sovenir</option>
                                <option value="Undangan" {{ (($mode == 'edit' && ($produk['kategori'] ?? '') == 'Undangan') || old('kategori_produk') == 'Undangan') ? 'selected' : '' }}>Undangan</option>
                                <option value="Papan Informasi" {{ (($mode == 'edit' && ($produk['kategori'] ?? '') == 'Papan Informasi') || old('kategori_produk') == 'Papan Informasi') ? 'selected' : '' }}>Papan Informasi</option>
                                <option value="Tanda Pengenal" {{ (($mode == 'edit' && ($produk['kategori'] ?? '') == 'Tanda Pengenal') || old('kategori_produk') == 'Tanda Pengenal') ? 'selected' : '' }}>Tanda Pengenal</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500 text-[10px]">▼</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-800 tracking-wide block">Harga</label>
                        <input type="number" name="harga" required
                               value="{{ $mode == 'edit' ? ($produk['price'] ?? '') : old('harga') }}"
                               placeholder="Rp. 0" 
                               class="w-full px-4 py-2.5 text-xs bg-white border border-red-400 rounded-xl focus:outline-none focus:ring-1 focus:ring-red-500 text-gray-700 placeholder-gray-400 shadow-sm">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-800 tracking-wide block">Stok</label>
                        <input type="number" name="stok" required
                               value="{{ $mode == 'edit' ? ($produk['stock'] ?? '') : old('stok') }}"
                               placeholder="0" 
                               class="w-full px-4 py-2.5 text-xs bg-white border border-red-400 rounded-xl focus:outline-none focus:ring-1 focus:ring-red-500 text-gray-700 placeholder-gray-400 shadow-sm">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-800 tracking-wide block">Satuan Produk</label>
                    <div class="relative">
                        <select name="unit" required class="appearance-none w-full bg-white border border-red-400 rounded-xl px-4 py-2.5 text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-red-500 shadow-sm">
                            <option value="lembar" {{ (($mode == 'edit' && ($produk['unit'] ?? '') == 'lembar') || old('unit') == 'lembar') ? 'selected' : '' }}>Lembar</option>
                            <option value="m" {{ (($mode == 'edit' && ($produk['unit'] ?? '') == 'm') || old('unit') == 'm') ? 'selected' : '' }}>Meter (m)</option>
                            <option value="box" {{ (($mode == 'edit' && ($produk['unit'] ?? '') == 'box') || old('unit') == 'box') ? 'selected' : '' }}>Box</option>
                            <option value="pcs" {{ (($mode == 'edit' && ($produk['unit'] ?? '') == 'pcs') || old('unit') == 'pcs') ? 'selected' : '' }}>Pcs</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500 text-[10px]">▼</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-800 tracking-wide block">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" placeholder="Masukkan Deskripsi Produk" required
                              class="w-full px-4 py-2.5 text-xs bg-white border border-red-400 rounded-2xl focus:outline-none focus:ring-1 focus:ring-red-500 text-gray-700 placeholder-gray-400 shadow-sm resize-none">{{ $mode == 'edit' ? ($produk['description'] ?? '') : old('deskripsi') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-800 tracking-wide block">Gambar Produk</label>
                        <div onclick="document.getElementById('file-input').click()" 
                            class="border border-dashed border-red-400 rounded-2xl p-4 flex flex-col items-center justify-center bg-white cursor-pointer hover:bg-gray-50 transition min-h-[120px] text-center shadow-sm relative overflow-hidden"
                            id="dropzone">
                            
                            <input type="file" id="file-input" name="gambar_produk" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(event)">
                            
                            <div id="upload-text" class="space-y-1">
                                <span class="text-xl">📁</span>
                                <p class="text-[11px] font-medium text-gray-600 leading-relaxed">
                                    Klik atau drag file untuk upload dari device<br>
                                    <span class="text-gray-400 text-[10px]">JPG dan PNG</span>
                                </p>
                            </div>

                            <img id="image-preview" src="#" alt="Pratinjau Gambar" class="absolute inset-0 w-full h-full object-contain p-2 hidden bg-white">
                        </div>
                    </div>
                    
                    <div class="space-y-2 flex flex-col justify-between">
                        <div>
                            <label class="text-xs font-bold text-gray-800 tracking-wide block mb-2">Status</label>
                            <div class="relative">
                                <select name="status" class="appearance-none w-full bg-white border border-red-400 rounded-xl px-4 py-2.5 text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-red-500 shadow-sm">
                                    <option value="Aktif" {{ (($mode == 'edit' && ($produk['status'] ?? '') == 'Aktif') || old('status') == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                                    <option value="Non-Aktif" {{ (($mode == 'edit' && ($produk['status'] ?? '') == 'Non-Aktif') || old('status') == 'Non-Aktif') ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500 text-[10px]">▼</span>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" onclick="goBack()" class="px-8 py-2 border border-red-500 text-red-600 rounded-full text-xs font-bold hover:bg-red-50 transition tracking-wide shadow-sm text-center">
                                Batal
                            </button>
                            <button type="submit" class="px-8 py-2 bg-red-800 hover:bg-red-900 text-white rounded-full text-xs font-bold transition tracking-wide shadow-sm">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
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
        function goBack() {
            window.location.href = "{{ route('admin.produk') }}";
        }
    </script>
</body>
</html>