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

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category != 'all') {
            $query->whereHas('subKategori.kategori', function($q) use ($request) {
                $q->where('id', $request->category)
                ->orWhere('name', $request->category);
            });
        }

        if ($request->filled('subcategory') && $request->subcategory != 'all') {
            $query->whereHas('subKategori', function($q) use ($request) {
                $q->where('id', $request->subcategory)
                ->orWhere('name', $request->subcategory);
            });
        }

        if ($request->filled('status') && $request->status != 'all') {
            $statusVal = ($request->status === 'Aktif') ? '1' : '0';
            $query->where('status', $statusVal);
        }

        $subKategoriQuery = SubKategori::query();

        if ($request->filled('category') && $request->category != 'all') {
            $subKategoriQuery->whereHas('kategori', function($q) use ($request) {
                $q->where('id', $request->category)
                ->orWhere('name', $request->category);
            });
        }

        $subKategoris = $subKategoriQuery->orderBy('name', 'asc')->get();
        
        $kategoris = Kategori::orderBy('name', 'asc')->get();

        $products = $query->latest()->paginate(5)->appends($request->all());

        return view('admin.produk', compact('products', 'subKategoris', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::with('subKategoris')->get();

        return view('admin.form-produk', compact('kategoris'));
    }

    public function edit($id)
    {
        $product = Product::with('subKategori')->findOrFail($id);
        $kategoris = Kategori::with('subKategoris')->get(); 

        return view('admin.edit-produk', compact('product', 'kategoris'));
    }

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
            'sub_kategori_id' => $request->sub_kategori_id,
            'description'     => $request->description,
            'price'           => $request->price,
            'unit'            => $request->unit,
            'minimum_order'   => $request->minimum_order,
            'image'           => $imageName,
            'status'          => ($request->status == 'Aktif' || $request->status == '1') ? '1' : '0',
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

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

        $data = $request->except(['image', 'kategori_id']); 
        $data['slug'] = Str::slug($request->name);
        $data['status'] = ($request->status == 'Aktif' || $request->status == '1') ? '1' : '0';
        $data['sub_kategori_id'] = $request->sub_kategori_id;

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