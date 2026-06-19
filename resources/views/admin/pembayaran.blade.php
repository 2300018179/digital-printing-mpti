<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran - Fantastic Digital Printing</title>
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
                    <a href="{{ route('admin.pembayaran') }}" class="bg-red-800 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
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
                <a href="#" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold bg-red-900 hover:bg-red-950 transition text-center justify-center uppercase tracking-wider">
                    <span>🚪</span> Log Out
                </a>
            </div>
        </aside>

        <main class="flex-1 p-8 space-y-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800 tracking-wide">Verifikasi Pembayaran</h2>
                <p class="text-xs text-gray-500 mt-1">Periksa bukti transfer dan konfirmasi pembayaran dari pelanggan.</p>
            </div>

                <div class="flex gap-3 mb-6">
                @foreach(['Menunggu', 'Disetujui', 'Ditolak'] as $s)
                <a href="{{ route('admin.pembayaran', ['status' => $s]) }}" 
                class="px-5 py-2.5 font-bold text-xs rounded-full transition {{ $status == $s ? 'bg-red-700 text-white' : 'bg-white border text-gray-600' }}">
                {{ $s }} ({{ $counts[$s] ?? 0 }})
                </a>
                @endforeach
            </div>

            <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-[10px] uppercase text-gray-400 font-bold">
                        <tr>
                            <th class="p-4">Order ID</th>
                            <th class="p-4">Pelanggan</th>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Bukti Transfer</th>
                            <th class="p-4">Total</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanans as $item)
                        <tr class="border-b">
                            <td class="p-4 font-mono text-xs font-bold">{{ $item->id }}</td>
                            <td class="p-4 text-xs">{{ $item->user->name ?? 'User' }}</td>
                            <td class="p-4 text-xs">{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td class="p-4 text-center">
                                @if($item->bukti_transfer)
                                    <a href="{{ asset('storage/' . $item->bukti_transfer) }}" 
                                    download 
                                    class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                    📥 Unduh
                                    </a>
                                @else
                                    <span class="text-gray-300 text-xs italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="p-4 text-xs">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                <form action="{{ route('admin.pembayaran.update', $item->id) }}" method="POST" class="flex justify-center gap-2">
                                    @csrf @method('PUT')
                                    <button name="status" value="Disetujui" class="bg-green-100 p-2 rounded-lg text-xs">✔️</button>
                                    <button name="status" value="Ditolak" class="bg-red-100 p-2 rounded-lg text-xs">❌</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="p-8 text-center text-gray-400">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-center gap-1.5 text-xs pt-2">
                <button class="w-7 h-7 bg-gray-100 text-gray-400 rounded flex items-center justify-center font-bold cursor-not-allowed">‹</button>
                <button class="w-7 h-7 bg-red-700 text-white rounded flex items-center justify-center shadow-sm font-bold">1</button>
                <button class="w-7 h-7 bg-gray-100 text-gray-400 rounded flex items-center justify-center font-bold cursor-not-allowed">›</button>
            </div>
        </main>
    </div>

    <!-- ========================================== -->
    <!-- POP-UP MODAL BUKTI TRANSFER (TAMBAHAN BARU) -->
    <!-- ========================================== -->
    <div id="buktiModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-2xl max-w-sm w-full overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300 border border-gray-100">
            <!-- Header Modal -->
            <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <div>
                    <h3 class="text-xs font-bold text-gray-800">Bukti Transfer Pelanggan</h3>
                    <p id="modalOrderId" class="text-[10px] font-mono text-red-600 font-bold mt-0.5">#ORD-XXXXX</p>
                </div>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-lg font-bold focus:outline-none transition p-1">
                    ✕
                </button>
            </div>
            <!-- Konten Foto Resi -->
            <div class="p-5 bg-gray-100 flex items-center justify-center">
                <!-- Di sini gambar mockup resi struk bank dipasang -->
                <img id="modalImage" src="https://i.pinimg.com/736x/8a/05/89/8a0589df464972e391b1580f4f9f40dc.jpg" 
                     alt="Bukti Transfer Mockup" class="max-h-96 w-auto object-contain rounded-lg shadow-sm border border-gray-200">
            </div>
            <!-- Footer Modal -->
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex justify-end">
                <button onclick="closeModal()" class="px-4 py-1.5 bg-red-700 hover:bg-red-800 text-white rounded-xl text-xs font-bold transition shadow-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</body>
</html>