<?php

namespace App\Http\Controllers\Customer; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product; 
use App\Models\Kategori;      
use App\Models\SubKategori;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\Promo;
use App\Models\Pengumuman;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsController extends Controller
{
    // 1. Method untuk menampilkan katalog produk (Dinamis dari Database + Filter + Pencarian)
    public function semuaProduk(Request $request)
    {
        // Ambil semua kategori untuk kebutuhan sidebar/menu
        $categories = Kategori::all(); 

        // Buat query dasar untuk produk (Gunakan string '1' karena tipe data ENUM)
        $query = Product::where('status', '1');

        $judulHalaman = "Semua Produk";
        $title = "Semua Produk"; 
        $breadcrumb = "Semua Produk"; 

        // === FITUR PENCARIAN ===
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
            });

            $judulHalaman = "Hasil Pencarian: \"" . $keyword . "\"";
            $title = "Mencari " . $keyword;
            $breadcrumb = "Pencarian";
        }

        // === FITUR FILTER KATEGORI INDUK ===
        if ($request->has('kategori') && $request->kategori != null) {
            $kategoriInduk = Kategori::find($request->kategori);
            
            if ($kategoriInduk) {
                // Ambil semua ID sub-kategori yang dimiliki oleh kategori induk ini
                $subKategoriIds = SubKategori::where('kategori_id', $request->kategori)->pluck('id');
                
                // Filter produk yang sub_kategori_id-nya ada di dalam daftar tersebut
                $query->whereIn('sub_kategori_id', $subKategoriIds);
                
                $judulHalaman = $kategoriInduk->name;
                $title = $kategoriInduk->name; 
                $breadcrumb = $kategoriInduk->name; 
            }
        }

        // === FITUR FILTER SUB-KATEGORI ===
        if ($request->has('sub') && $request->sub != null) {
            $sub = SubKategori::find($request->sub);
            
            if ($sub) {
                $query->where('sub_kategori_id', $request->sub);
                $judulHalaman = $sub->name;
                $title = $sub->name; 
                $breadcrumb = $sub->name; 
            }
        }

        // Ambil data produk akhir dengan sistem halaman (Pagination) + pertahankan query URL
        $products = $query->latest()->paginate(8)->appends($request->all());

        // Lempar data ke view
        return view('customer.semua-produk', compact('categories', 'products', 'judulHalaman', 'title', 'breadcrumb'));
    }

    // 2. Method untuk menampilkan detail produk saat diklik
    public function detailProduk(Request $request, $id)
    {
        $product = Product::where('id', $id)->where('status', '1')->firstOrFail();
        
        // Ambil data keranjang lama jika user masuk lewat tombol "Edit"
        $editCartData = null;
        if ($request->has('edit_cart')) {
            $editCartData = Keranjang::where('id', $request->edit_cart)
                                    ->where('user_id', auth()->id())
                                    ->first();
        }

        return view('customer.detail-produk', compact('product', 'editCartData'));
    }

    // 3. Halaman Promo
    public function halamanPromo()
    {
        $categories = Kategori::all();
        $title = "Promo Spesial";
        $breadcrumb = "Beranda / Promo";

        // Ambil data promo dari database yang statusnya 'Aktif'
        $promos = Promo::where('status', 'Aktif')->get();

        // Kirim variabel $promos ke view
        return view('customer.promo', compact('categories', 'title', 'breadcrumb', 'promos'));
    }

    // 4. Jam Layanan
    public function jamLayanan()
    {
        return view('customer.jam-layanan');
    }

    // 5. Halaman Pusat Notifikasi
    public function halamanNotifikasi(Request $request)
    {
        $userId = auth()->id();
        $notificationsList = collect();

        // ----------------------------------------------------------------------
        // 1. AMBIL NOTIFIKASI DARI STATUS PESANAN (Diproses / Dicetak / Selesai)
        // ----------------------------------------------------------------------
        if ($userId) {
            $pesanans = Pesanan::where('user_id', $userId)->latest()->get();
            foreach ($pesanans as $pesanan) {
                $pesan = "Pesanan Anda <strong>#{$pesanan->order_id}</strong> saat ini berstatus: <span class='font-semibold text-brandRed'>{$pesanan->status}</span>.";
                
                if ($pesanan->status === 'Selesai') {
                    $pesan = "Pesanan <strong>#{$pesanan->order_id}</strong> telah selesai dan siap diambil/dikirim!";
                } elseif ($pesanan->status === 'Dicetak') {
                    $pesan = "Pesanan <strong>#{$pesanan->order_id}</strong> sedang dalam proses pencetakan oleh tim kami.";
                }

                $notificationsList->push([
                    'id'          => 'order_' . $pesanan->id,
                    'created_at'  => $pesanan->updated_at ?? $pesanan->created_at,
                    'read_at'     => null, // Set null agar dianggap baru/belum dibaca
                    'data' => [
                        'type'        => 'pesanan',
                        'title'       => 'Update Status Pesanan',
                        'message'     => $pesan,
                        'url'         => route('customer.pesanan-saya'),
                        'action_text' => 'Cek Pesanan Saya'
                    ]
                ]);
            }
        }

        // ----------------------------------------------------------------------
        // 2. AMBIL NOTIFIKASI PROMO AKTIF
        // ----------------------------------------------------------------------
        $promos = Promo::where('status', 'Aktif')->latest()->get();
        foreach ($promos as $promo) {
            $notificationsList->push([
                'id'          => 'promo_' . $promo->id,
                'created_at'  => $promo->created_at,
                'read_at'     => null,
                'data' => [
                    'type'        => 'promo',
                    'title'       => $promo->judul ?? $promo->nama_promo ?? 'Promo Spesial Cetak!',
                    'message'     => $promo->deskripsi ?? 'Ada promo menarik untuk kamu, cek sekarang sebelum kehabisan!',
                    'url'         => route('customer.promo'),
                    'action_text' => 'Lihat Promo'
                ]
            ]);
        }

        // ----------------------------------------------------------------------
        // 3. AMBIL NOTIFIKASI PENGUMUMAN / INFORMASI TERBARU
        // ----------------------------------------------------------------------
        $pengumumans = Pengumuman::where('status', 'Aktif')->latest()->get();
        foreach ($pengumumans as $info) {
            $notificationsList->push([
                'id'          => 'info_' . $info->id,
                'created_at'  => $info->created_at,
                'read_at'     => null,
                'data' => [
                    'type'        => 'info',
                    'title'       => $info->judul ?? 'Informasi Terbaru Toko',
                    'message'     => $info->isi ?? $info->keterangan ?? 'Ada pengumuman terbaru dari Fantastic Digital Printing.',
                    'url'         => route('customer.informasi'),
                    'action_text' => 'Baca Selengkapnya'
                ]
            ]);
        }

        // ----------------------------------------------------------------------
        // 4. URUTKAN SEMUA NOTIFIKASI BERDASARKAN TANGGAL TERBARU
        // ----------------------------------------------------------------------
        $sortedList = $notificationsList->sortByDesc('created_at')->values();

        // ----------------------------------------------------------------------
        // 5. MENGUBAH ARRAY KETIAP OBJECT SEPERTI MODEL ELOQUENT (Bisa dipaginate)
        // ----------------------------------------------------------------------
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $sortedList->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Mapping array menjadi array of objects
        $formattedItems = collect($currentItems)->map(function ($item) {
            return (object) [
                'id'         => $item['id'],
                'created_at' => \Carbon\Carbon::parse($item['created_at']),
                'read_at'    => $item['read_at'],
                'data'       => $item['data']
            ];
        });

        $notifications = new LengthAwarePaginator(
            $formattedItems,
            $sortedList->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('customer.notifikasi', compact('notifications'));
    }

    public function markAllRead()
    {
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    // 6. Halaman Riwayat Pesanan / Transaksi
    public function halamanPesanan(Request $request)
    {
        $status = $request->query('status', 'Diproses');
        
        // UBAH DI SINI: Ganti detailPesanan menjadi items sesuai isi modelmu
        $query = Pesanan::where('user_id', auth()->id())->with('items');

        if (in_array($status, ['Diproses', 'Dicetak', 'Selesai'])) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->get();

        return view('customer.pesanan', compact('orders'));
    }

    // 7. Halaman Pusat Informasi / Pengumuman Toko
    public function halamanInformasi()
    {
        // Ambil data pengumuman yang statusnya 'Aktif', urutkan dari yang terbaru
        $pengumumans = Pengumuman::where('status', 'Aktif')
                                ->latest()
                                ->get();

        return view('customer.informasi', compact('pengumumans'));
    }
}