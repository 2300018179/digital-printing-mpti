<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan - Fantastic Digital Printing</title>
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

            <div class="p-3 border-t border-red-800">
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold bg-red-900 hover:bg-red-950 transition text-center justify-center uppercase tracking-wider">
                        <span>🚪</span> Log Out
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-8 space-y-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Data Pesanan</h2>
                <p class="text-xs text-gray-500 mt-1">Kelola dan pantau seluruh status pesanan pelanggan.</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-gray-400 uppercase text-[10px] tracking-wider font-bold">
                                <th class="p-4 text-center">No</th>
                                <th class="p-4">Order ID</th>
                                <th class="p-4">Pelanggan</th>
                                <th class="p-4">Tanggal</th>
                                <th class="p-4">Total</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @forelse($pesanans as $index => $pesanan)
                            <tr class="hover:bg-gray-50/50 border-b border-gray-100 transition">
                                <td class="p-4 text-center text-gray-400 font-medium">{{ $index + 1 }}</td>
                                <td class="p-4 font-mono text-xs font-bold text-gray-700">{{ $pesanan->order_id }}</td>
                                <td class="p-4 font-semibold text-gray-800">{{ $pesanan->nama_pelanggan }}</td>
                                <td class="p-4 text-gray-500 font-medium text-xs">{{ $pesanan->created_at->format('d M Y') }}</td>
                                <td class="p-4 font-bold text-gray-800 text-xs">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                                <td class="p-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200">
                                        {{ $pesanan->status }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('admin.pesanan.detail', $pesanan->id) }}" 
                                       class="px-4 py-1.5 border border-gray-300 hover:border-red-600 hover:text-red-600 bg-white text-gray-600 rounded-lg text-[11px] font-bold shadow-sm transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-500 italic">Tidak ada data pesanan tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>