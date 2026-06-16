<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 object-contain">
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-gray-700">Selamat Datang, <strong class="text-gray-900">Admin</strong></span>
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
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold bg-red-900 hover:bg-red-950 transition text-center justify-center uppercase tracking-wider text-white">
                        <span>🚪</span> Log Out
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <div class="max-w-3xl bg-white p-8 rounded-2xl border border-gray-200 shadow-sm">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Edit Produk: {{ $product->name }}</h2>

                <form action="{{ route('admin.produk.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 border rounded-xl text-sm" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="kategori" class="w-full px-4 py-2 border rounded-xl text-sm" required>
                                <option value="Print On Paper" {{ $product->kategori == 'Print On Paper' ? 'selected' : '' }}>Print On Paper</option>
                                <option value="Print Stiker" {{ $product->kategori == 'Print Stiker' ? 'selected' : '' }}>Print Stiker</option>
                                <option value="Kalender" {{ $product->kategori == 'Kalender' ? 'selected' : '' }}>Kalender</option>
                                <option value="Banner & Spanduk" {{ $product->kategori == 'Banner & Spanduk' ? 'selected' : '' }}>Banner & Spanduk</option>
                                <option value="Sablon" {{ $product->kategori == 'Sablon' ? 'selected' : '' }}>Sablon</option>
                                <option value="Sovenir" {{ $product->kategori == 'Sovenir' ? 'selected' : '' }}>Sovenir</option>
                                <option value="Undangan" {{ $product->kategori == 'Undangan' ? 'selected' : '' }}>Undangan</option>
                                <option value="Papan Informasi" {{ $product->kategori == 'Papan Informasi' ? 'selected' : '' }}>Papan Informasi</option>
                                <option value="Tanda Pengenal" {{ $product->kategori == 'Tanda Pengenal' ? 'selected' : '' }}>Tanda Pengenal</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Harga</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2 border rounded-xl text-sm" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Stok</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full px-4 py-2 border rounded-xl text-sm" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Satuan (Contoh: Pcs, Rim, M2)</label>
                            <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" class="w-full px-4 py-2 border rounded-xl text-sm" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-4 py-2 border rounded-xl text-sm" required>
                                <option value="Aktif" {{ $product->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non-Aktif" {{ $product->status == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-xl text-sm">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 mb-2">Ganti Gambar (Opsional)</label>
                            @if($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded-lg border">
                                </div>
                            @endif
                            <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="submit" class="bg-red-700 text-white px-6 py-2 rounded-xl font-bold text-xs hover:bg-red-800">Update Produk</button>
                        <a href="{{ route('admin.produk') }}" class="bg-gray-100 text-gray-600 px-6 py-2 rounded-xl font-bold text-xs hover:bg-gray-200">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>