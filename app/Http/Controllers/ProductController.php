<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product; 
use App\Models\Kategori;      
use App\Models\SubKategori;
use App\Models\Keranjang;

class ProductController extends Controller
{
    // 1. Method untuk menampilkan katalog produk (Dinamis dari Database + Filter + Pencarian)
    public function semuaProduk(Request $request)
    {
        // 1. Ambil semua kategori untuk kebutuhan sidebar/menu
        $categories = Kategori::all(); 

        // 2. Buat query dasar untuk produk (Gunakan string '1' karena tipe data ENUM)
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

        // 4. Ambil data produk akhir dengan sistem halaman (Pagination) + pertahankan query URL
        $products = $query->latest()->paginate(8)->appends($request->all());

        // 5. Lempar data ke view
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

    // 3. Halaman Promo (SUDAH DIPERBAIKI AGAR TIDAK ERROR COBA LIAT)
    public function halamanPromo()
    {
        // Mengambil kategori, judul, dan breadcrumb agar layout aside-nya sinkron
        $categories = Kategori::all();
        $title = "Promo Spesial";
        $breadcrumb = "Beranda / Promo";

        return view('customer.promo', compact('categories', 'title', 'breadcrumb'));
    }

    // 4. Jam Layanan
    public function jamLayanan()
    {
        return view('customer.jam-layanan');
    }

    // 5. Halaman Pusat Notifikasi
    public function halamanNotifikasi()
    {
        return view('customer.notifikasi');
    }

    // 6. Halaman Riwayat Pesanan / Transaksi
    public function halamanPesanan()
    {
        return view('customer.pesanan');
    }

    // 7. Halaman Pusat Informasi / Pengumuman Toko
    public function halamanInformasi()
    {
        return view('customer.informasi');
    }
}