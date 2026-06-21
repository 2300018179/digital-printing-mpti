<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelanggan - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <header class="bg-white border-b border-gray-200 px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 object-contain">
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-gray-700">Selamat Datang, <strong class="text-gray-900">Admin</strong></span>
            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300">
                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
        </div>
    </header>

    <div class="flex flex-1">
        <aside class="w-64 bg-red-700 text-white flex flex-col justify-between min-h-[calc(100vh-57px)] sticky top-[57px]">
            <nav class="py-4 space-y-1 px-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium transition">🏠 Dashboard</a>
                <a href="{{ route('admin.produk') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium transition">🛍️ Produk</a>
                <a href="{{ route('admin.kategori') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium transition">🏷️ Kategori</a>
                <a href="{{ route('admin.pesanan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium transition">📦 Pesanan</a>
                <a href="{{ route('admin.pembayaran') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium transition">💳 Pembayaran</a>
                <a href="{{ route('admin.promo') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium transition">% Promo</a>
                <a href="{{ route('admin.pelanggan') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition">👥 Pelanggan</a>
                <a href="{{ route('admin.laporan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium transition">📊 Laporan</a>
                <a href="{{ route('admin.pengaturan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium transition">⚙️ Pengaturan</a>
            </nav>
            <div class="p-3 border-t border-red-800">
                <a href="#" class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-xl text-xs font-bold bg-red-900 hover:bg-red-950 transition uppercase tracking-wider">🚪 Log Out</a>
            </div>
        </aside>

        <main class="flex-1 p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Profil & Riwayat Pelanggan</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Informasi akun mendalam beserta history transaksi cetak.</p>
                </div>
                <a href="{{ route('admin.pelanggan') }}" class="px-4 py-2 border border-gray-300 hover:bg-gray-100 rounded-full text-xs font-bold text-gray-600 shadow-sm">← Kembali</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white border border-red-400 rounded-2xl shadow-sm p-6 space-y-4">
                    <div class="flex flex-col items-center border-b border-gray-100 pb-4">
                        <div class="w-20 h-20 bg-red-50 text-red-700 rounded-full flex items-center justify-center border-2 border-red-200 text-3xl font-bold mb-3">
                            {{ substr($pelanggan->name, 0, 1) }}
                        </div>
                        <h3 class="text-sm font-bold text-gray-800">{{ $pelanggan->name }}</h3>
                        <span class="px-2.5 py-0.5 bg-green-50 border border-green-200 text-green-600 rounded-full text-[10px] font-bold mt-1">Pelanggan</span>
                    </div>

                    <div class="space-y-4 text-xs">
                        <div>
                            <span class="text-gray-400 block uppercase font-bold tracking-wider">Email</span>
                            <span class="text-gray-700 font-semibold">{{ $pelanggan->email }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block uppercase font-bold tracking-wider">Telepon</span>
                            <span class="text-gray-700 font-mono font-semibold">{{ $pelanggan->phone ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block uppercase font-bold tracking-wider">Alamat</span>
                            <span class="text-gray-600 font-medium leading-relaxed">Jl. Malioboro No. 45, Kota Yogyakarta</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white border border-red-400 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Log Riwayat Pesanan</h4>
                        <span class="px-2.5 py-1 bg-red-700 text-white rounded-lg text-[10px] font-bold">Total: {{ $pelanggan->pesanan->count() }} Pesanan</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/50 text-gray-400 uppercase text-[9px] font-bold">
                                <tr>
                                    <th class="p-3.5 text-center">No</th>
                                    <th class="p-3.5">ID Pesanan</th>
                                    <th class="p-3.5">Total Bayar</th>
                                    <th class="p-3.5 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                                @forelse($pelanggan->pesanan as $index => $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-3.5 text-center">{{ $index + 1 }}</td>
                                        <td class="p-3.5 font-mono font-bold text-red-700">{{ $item->order_id }}</td>
                                        <td class="p-3.5 font-bold">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                        <td class="p-3.5 text-center">
                                            <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold">{{ $item->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-4 text-center text-gray-500">Belum ada riwayat pesanan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>