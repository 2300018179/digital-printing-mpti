<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Fantastic Digital Printing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- ATAS: NAVBAR ADMIN -->
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
        <!-- KIRI: SIDEBAR NAVIGASI -->
        <aside class="w-64 bg-red-700 text-white flex flex-col justify-between min-h-[calc(100vh-57px)] sticky top-[57px]">
            <div class="py-4">
                <nav class="space-y-1 px-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🏠</span> Dashboard
                    </a>
                    <a href="{{ route('admin.produk') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>🛍️</span> Produk
                    </a>
                    <a href="{{ route('admin.kategori') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
                        <span>🏷️</span> Kategori
                    </a>
                    <a href="{{ route('admin.pesanan') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-medium tracking-wide transition">
                        <span>📦</span> Pesanan
                    </a>
                    <a href="{{ route('admin.pembayaran') }}" class="hover:bg-red-600/50 flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold tracking-wide transition">
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

            <!-- Tombol Log Out -->
            <div class="p-3 border-t border-red-800">
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?')">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold bg-red-900 hover:bg-red-950 transition text-center justify-center uppercase tracking-wider text-white">
                        <span>🚪</span> Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- KANAN: UTAMA KONTEN DASHBOARD -->
        <main class="flex-1 p-6 space-y-6">
            
            <!-- BARIS 1: 3 KOTAK CARD UTAMA (Sesuai Figma Tanpa Total Pendapatan) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <!-- Total Pesanan -->
                <div class="bg-white p-6 border border-red-500 rounded-2xl shadow-sm">
                    <p class="text-[11px] font-bold text-gray-500 uppercase">Total Pesanan</p>
                    <h3 class="text-4xl font-bold text-gray-800 mt-2">{{ $totalOrder }}</h3>
                </div>
                <!-- Produk -->
                <div class="bg-white p-6 border border-red-500 rounded-2xl shadow-sm">
                    <p class="text-[11px] font-bold text-gray-500 uppercase">Produk</p>
                    <h3 class="text-4xl font-bold text-gray-800 mt-2">{{ $totalProduk }}</h3>
                </div>
                <!-- Pelanggan -->
                <div class="bg-white p-6 border border-red-500 rounded-2xl shadow-sm">
                    <p class="text-[11px] font-bold text-gray-500 uppercase">Pelanggan</p>
                    <h3 class="text-4xl font-bold text-gray-800 mt-2">{{ $totalPelanggan }}</h3>
                </div>
            </div>

            <!-- BARIS 2: TABEL PESANAN TERBARU & STATUS PESANAN -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Kiri Luar: Tabel Pesanan Terbaru (Lebih Luas) -->
                <div class="bg-white p-5 border border-red-500 rounded-2xl shadow-sm lg:col-span-2 overflow-x-auto">
                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4">Pesanan Terbaru</h4>
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-red-50 text-red-700 font-bold border-b border-red-100">
                                <th class="p-2.5">No</th>
                                <th class="p-2.5">Order ID</th>
                                <th class="p-2.5">Pelanggan</th>
                                <th class="p-2.5">Total</th>
                                <th class="p-2.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-medium text-gray-600">
                            @foreach($latestOrders as $index => $order)
                            <tr>
                                <td class="p-2.5">{{ $index + 1 }}</td>
                                <td class="p-2.5 font-semibold text-gray-800">{{ $order->order_id }}</td>
                                <td class="p-2.5">{{ $order->customer_name }}</td>
                                <td class="p-2.5 text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="p-2.5 text-center">
                                    <span class="bg-blue-100 text-blue-700 text-[10px] px-2.5 py-0.5 rounded-full font-bold">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $latestOrders->links() }}
                    </div>
                </div>

                <!-- Kanan: Status Pesanan (Donut Data Lingkaran) -->
                <div class="bg-white p-5 border border-red-500 rounded-2xl shadow-sm">
                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4">Status Pesanan</h4>
                    <div class="w-full text-[11px] font-medium text-gray-600 space-y-1.5">
                        @foreach($statusCounts as $label => $count)
                        <div class="flex justify-between items-center">
                            <p class="capitalize">{{ $label }}</p> 
                            <span class="font-bold text-gray-800">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- BARIS 3: PRODUK TERLARIS (Melebar Penuh di Bawah) -->
            <div class="bg-white p-5 border border-red-500 rounded-2xl shadow-sm w-full">
                <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-4">Produk Terlaris</h4>
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-6">
                    @foreach($produkTerlaris as $produk)
                    <div class="text-xs">
                        <div class="flex justify-between font-semibold text-gray-700 mb-1">
                            <span>{{ $loop->iteration }}. {{ $produk->name }}</span>
                            <span class="text-red-600">{{ $produk->total_sold }} Terjual</span>
                        </div>
                        <div class="w-full bg-gray-100 h-2 rounded-full">
                            <div class="bg-red-600 h-2 rounded-full" style="width: {{ ($produk->total_sold / 100) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </main>
    </div>

</body>
</html>