<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Kategori; 
use App\Models\SubKategori;
use Illuminate\Support\Str;

class ProductController extends Controller 
{
    public function index(Request $request)
    {
        $query = Product::with(['subKategori.kategori']);

        // 1. Filter Pencarian Nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Kategori Utama
        if ($request->filled('category') && $request->category != 'all') {
            $query->whereHas('subKategori.kategori', function($q) use ($request) {
                $q->where('id', $request->category)
                ->orWhere('name', $request->category);
            });
        }

        // 3. Filter Sub Kategori
        if ($request->filled('subcategory') && $request->subcategory != 'all') {
            $query->whereHas('subKategori', function($q) use ($request) {
                $q->where('id', $request->subcategory)
                ->orWhere('name', $request->subcategory);
            });
        }

        // 4. Filter Status
        if ($request->filled('status') && $request->status != 'all') {
            // Jika request 'Aktif', cari nilai '1'. Selain itu (Non-Aktif), cari '0'.
            $statusVal = ($request->status === 'Aktif') ? '1' : '0';
            $query->where('status', $statusVal);
        }

        // Load Sub Kategori Dinamis berdasarkan Kategori Induk
        $subKategoriQuery = SubKategori::query();

        if ($request->filled('category') && $request->category != 'all') {
            $subKategoriQuery->whereHas('kategori', function($q) use ($request) {
                $q->where('id', $request->category)
                ->orWhere('name', $request->category);
            });
        }

        $subKategoris = $subKategoriQuery->orderBy('name', 'asc')->get();
        
        // TAMBAHAN: Ambil semua data Kategori Induk untuk dropdown Blade
        $kategoris = Kategori::orderBy('name', 'asc')->get();

        $products = $query->latest()->paginate(5)->appends($request->all());

        return view('admin.produk', compact('products', 'subKategoris', 'kategoris'));
    }

    // ==========================================
    // TAMPILKAN FORM TAMBAH
    // ==========================================
    public function create()
    {
        $kategoris = \App\Models\Kategori::all();
        $subKategoris = \App\Models\SubKategori::all(); // Variabel ini WAJIB ada agar dibaca JavaScript

        return view('admin.form-produk', compact('kategoris', 'subKategoris'));
    }

    // ==========================================
    // TAMPILKAN FORM EDIT
    // ==========================================
    public function edit($id)
    {
        // Menggunakan Product:: dan memuat relasi subKategoris
        $product = Product::findOrFail($id);
        $kategoris = Kategori::with('subKategoris')->get(); 

        return view('admin.edit-produk', compact('product', 'kategoris'));
    }

    // ==========================================
    // PROSES SIMPAN PRODUK BARU
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'kategori_id'     => 'required|exists:kategoris,id', 
            'sub_kategori_id' => 'required|exists:sub_kategoris,id', 
            'price'           => 'required|numeric',
            'unit'            => 'required',
            'description'     => 'required',
            'minimum_order'   => 'required|numeric|min:1', 
            'image'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status'          => 'required'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/products'), $imageName);
        }

        Product::create([
            'name'            => $request->name,
            'slug'            => Str::slug($request->name),
            'sub_kategori_id' => $request->sub_kategori_id, // GANTI DARI $request->kategori KE SINI
            'description'     => $request->description,
            'price'           => $request->price,
            'unit'            => $request->unit,
            'minimum_order'   => $request->minimum_order, // TAMBAHKAN INI JUGA BIAR TERSIMPAN
            'image'           => $imageName,
            'status'          => ($request->status == 'Aktif' || $request->status == '1') ? '1' : '0',
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    // ==========================================
    // PROSES UPDATE DATA PRODUK
    // ==========================================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // UBAH VALIDASI DI SINI
        $request->validate([
            'name'            => 'required|string|max:255',
            'kategori_id'     => 'required|exists:kategoris,id', 
            'sub_kategori_id' => 'required|exists:sub_kategoris,id', 
            'price'           => 'required|numeric',
            'unit'            => 'required',
            'minimum_order'   => 'required|numeric|min:1',
            'status'          => 'required',
            'description'     => 'nullable',
            'image'           => 'nullable|image|max:2048'
        ]);

        // UBAH PENGECUALIAN DI SINI
        $data = $request->except(['image', 'kategori_id']); 
        $data['slug'] = Str::slug($request->name); // Update slug jika nama berubah
        $data['status'] = ($request->status == 'Aktif' || $request->status == '1') ? '1' : '0';
        $data['sub_kategori_id'] = $request->sub_kategori_id; // GANTI KE sub_kategori_id

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('assets/products/' . $product->image))) {
                unlink(public_path('assets/products/' . $product->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/products'), $imageName);
            
            $data['image'] = $imageName;
        }

        $product->update($data);
        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image && file_exists(public_path('assets/products/' . $product->image))) {
            unlink(public_path('assets/products/' . $product->image));
        }
        
        $product->delete();
        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus!');
    }
}