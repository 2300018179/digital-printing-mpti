<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); 
        return view('admin.produk', compact('products'));
    }

    public function create()
    {
        return view('admin.form-produk', ['mode' => 'tambah']);
    }

    // 1. TAMBAHKAN INI: Fungsi untuk menampilkan form edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.edit-produk', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'     => 'required|string|max:255',
            'kategori_produk' => 'required|string',
            'harga'           => 'required|numeric|min:0',
            'stok'            => 'required|integer|min:0',
            'unit'            => 'required|string',
            'deskripsi'       => 'required|string',
            'gambar_produk'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status'          => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('gambar_produk')) {
            $imagePath = $request->file('gambar_produk')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->nama_produk,
            'slug'        => Str::slug($request->nama_produk),
            'kategori'    => $request->kategori_produk,
            'description' => $request->deskripsi,
            'price'       => $request->harga,
            'stock'       => $request->stok,
            'unit'        => $request->unit,
            'image'       => $imagePath,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    // 2. PERBAIKAN: Gunakan nama input yang konsisten dengan form kamu
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'kategori' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'unit' => 'required',
            'status' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) \Storage::delete('public/' . $product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus!');
    }
}