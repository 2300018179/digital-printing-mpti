<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Promo - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href="{{ route('admin.produk') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
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
                    <a href="{{ route('admin.promo') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
                        <span>%</span> Promo
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
                <a href="#" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold bg-red-900 hover:bg-red-950 transition text-center justify-center uppercase tracking-wider">
                    <span>🚪</span> Log Out
                </a>
            </div>
        </aside>

        <main class="flex-1 p-8 space-y-6">

        <div class="max-w-4xl mx-auto">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Edit Promo: {{ $promo->nama }}</h2>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <form action="{{ route('admin.promo.update', $promo->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs font-medium text-gray-700">
                        
                        <div class="md:col-span-2 flex flex-col gap-2">
                            <label class="font-semibold">Nama Promo</label>
                            <input type="text" name="nama" value="{{ old('nama', $promo->nama) }}" required class="w-full p-3 border border-gray-200 rounded-xl">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="font-semibold">Kode Promo</label>
                            <input type="text" name="kode" value="{{ old('kode', $promo->kode) }}" required class="w-full p-3 border border-gray-200 rounded-xl uppercase">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="font-semibold">Besar Diskon (%)</label>
                            <input type="number" name="diskon" value="{{ old('diskon', $promo->diskon) }}" required class="w-full p-3 border border-gray-200 rounded-xl">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="font-semibold">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ $promo->tanggal_mulai }}" required class="w-full p-3 border border-gray-200 rounded-xl">
                        </div>

                        <div class="flex flex-col gap-2">
                            <label class="font-semibold">Tanggal Berakhir</label>
                            <input type="date" name="tanggal_selesai" value="{{ $promo->tanggal_selesai }}" required class="w-full p-3 border border-gray-200 rounded-xl">
                        </div>

                        <div class="md:col-span-2 flex flex-col gap-2">
                            <label class="font-semibold">Status Promo</label>
                            <select name="status" class="w-full p-3 border border-gray-200 rounded-xl">
                                <option value="Aktif" {{ $promo->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ $promo->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-6 pt-4 border-t">
                        <a href="{{ route('admin.promo') }}" class="px-5 py-2.5 border border-gray-300 rounded-full hover:bg-gray-100">Batal</a>
                        <button type="submit" class="px-6 py-2.5 bg-red-700 text-white rounded-full hover:bg-red-800">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
        </main>    
</body>
</html>