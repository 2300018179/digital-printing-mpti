<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan {{ $pesanan->order_id ?? 'N/A' }} - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50">

    <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center fixed top-0 w-full z-50 h-[60px] shadow-sm">
        <div class="flex items-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 object-contain">
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-gray-700">Selamat Datang, <strong class="text-gray-900">Admin</strong></span>
        </div>
    </header>

    <div class="flex pt-[60px]"> <aside class="w-64 bg-red-700 text-white min-h-[calc(100vh-60px)] flex flex-col fixed">
            <div class="py-4">
                <nav class="space-y-1 px-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🏠</span> Dashboard
                    </a>
                    <a href="{{ route('admin.produk') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🛍️</span> Produk
                    </a>
                    <a href="{{ route('admin.kategori') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
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
            <div class="p-3 border-t border-red-800 mt-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold bg-red-900 hover:bg-red-950 transition"><span>🚪</span> Log Out</button>
                </form>
            </div>
        </aside>

        <main class="ml-64 flex-1 p-8 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Detail Pesanan <span class="font-mono text-red-700">{{ $pesanan->order_id }}</span></h2>
                </div>
                <a href="{{ route('admin.pesanan') }}" class="px-4 py-2 border bg-white hover:bg-gray-100 rounded-full text-xs font-bold text-gray-600 shadow-sm">← Kembali</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                    <h3 class="text-xs font-bold text-gray-700 uppercase border-b pb-2 mb-4">Item Cetakan</h3>
                    @foreach($pesanan->items as $item)
                        <div class="flex justify-between py-3 border-b">
                            <h4 class="text-xs font-bold">{{ $item->nama_produk }}</h4>
                            <p class="text-xs">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-6">
                    <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" method="POST">
                        @csrf
                        @method('PUT') 

                        <select name="status" class="...">
                            <option value="Menunggu" {{ $pesanan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        
                        <button type="submit">Simpan Status</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>