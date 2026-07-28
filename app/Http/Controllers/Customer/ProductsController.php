<?php

namespace App\Http\Controllers\Customer; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product; 
use App\Models\Kategori;      
use App\Models\SubKategori;
use App\Models\Keranjang;
use App\Models\Promo;
use App\Models\Pengumuman;

class ProductsController extends Controller
{
    // 1. Method untuk menampilkan katalog produk (Dinamis dari Database + Filter + Pencarian)
    public function semuaProduk(Request $request)
    {
        // Ambil semua kategori untuk kebutuhan sidebar/menu
        $categories = Kategori::all(); 

        // Buat query dasar untuk produk
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
                $subKategoriIds = SubKategori::where('kategori_id', $request->kategori)->pluck('id');
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

        $products = $query->latest()->paginate(8)->appends($request->all());

        return view('customer.semua-produk', compact('categories', 'products', 'judulHalaman', 'title', 'breadcrumb'));
    }

    // 2. Method untuk menampilkan detail produk saat diklik
    public function detailProduk(Request $request, $id)
    {
        $product = Product::where('id', $id)->where('status', '1')->firstOrFail();
        
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

        $promos = Promo::where('status', 'Aktif')->get();

        return view('customer.promo', compact('categories', 'title', 'breadcrumb', 'promos'));
    }

    // 4. Jam Layanan
    public function jamLayanan()
    {
        return view('customer.jam-layanan');
    }

    // 5. Halaman Pusat Informasi / Pengumuman Toko
    public function halamanInformasi()
    {
        $pengumumans = Pengumuman::where('status', 'Aktif')
                                ->latest()
                                ->get();

        return view('customer.informasi', compact('pengumumans'));
    }
}