<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class KeranjangController extends Controller
{
    // 1. Fungsi Tambah / Update Keranjang (Add to Cart)
    public function tambah(Request $request, $productId)
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Pastikan produk ada dan aktif
        $product = Product::where('id', $productId)->where('status', '1')->firstOrFail();

        // 3. Validasi input dari form detail produk
        $request->validate([
            'cart_id_edit' => 'nullable|integer', 
            'jumlah'       => 'required|integer|min:1',
            'catatan'      => 'nullable|string',
            'file_desain'  => 'nullable|file|mimes:jpg,jpeg,png,pdf,zip,rar|max:10240', // Maksimal 10MB
            'link_desain'  => 'nullable|url',
            // Mendukung fallback jika Blade masih menggunakan name lama:
            'desain_file'  => 'nullable|file|mimes:jpg,jpeg,png,pdf,zip,rar|max:10240',
            'desain_link'  => 'nullable|url',
        ]);

        $userId = Auth::id();

        // 4. Tangkap File atau Link Desain Baru (Flexible handling)
        $fileInput = $request->file('file_desain') ?? $request->file('desain_file');
        $linkInput = $request->input('link_desain') ?? $request->input('desain_link');

        $desainInput = null;

        if ($fileInput) {
            $fileName = time() . '_' . uniqid() . '.' . $fileInput->getClientOriginalExtension();
            $fileInput->move(public_path('uploads/desain'), $fileName);
            $desainInput = 'uploads/desain/' . $fileName;
        } elseif (!empty($linkInput)) {
            $desainInput = $linkInput;
        }

        // =========================================================================
        // KONDISI A: MODE EDIT ITEM KERANJANG
        // =========================================================================
        if ($request->has('cart_id_edit') && !empty($request->cart_id_edit)) {
            $cartItem = Keranjang::where('id', $request->cart_id_edit)
                                 ->where('user_id', $userId)
                                 ->first();
            
            if ($cartItem) {
                // Gunakan desain baru, atau pertahankan desain lama jika tidak ada upload baru
                $desainFinal = $desainInput ?: $cartItem->desain;

                // Jika user mencentang/memicu hapus desain lama
                if ($request->input('hapus_desain_lama') == '1' && !$desainInput) {
                    // Hapus file fisik jika berupa file upload
                    if ($cartItem->desain && File::exists(public_path($cartItem->desain))) {
                        File::delete(public_path($cartItem->desain));
                    }
                    $desainFinal = null;
                }

                // Cek apakah item serupa sudah ada
                $itemSerupa = Keranjang::where('user_id', $userId)
                                      ->where('product_id', $productId)
                                      ->where('id', '!=', $cartItem->id)
                                      ->where('notes', $request->catatan)
                                      ->where('desain', $desainFinal)
                                      ->first();

                if ($itemSerupa) {
                    $itemSerupa->increment('quantity', $request->jumlah);
                    $cartItem->delete();
                } else {
                    $cartItem->update([
                        'quantity' => $request->jumlah,
                        'notes'    => $request->catatan,
                        'desain'   => $desainFinal,
                    ]);
                }
                
                return redirect()->route('customer.dashboard')->with('success', 'Keranjang belanja berhasil diperbarui!');
            }
        }

        // =========================================================================
        // KONDISI B: TAMBAH BARU / AKUMULASI
        // =========================================================================
        $cekKeranjang = Keranjang::where('user_id', $userId)
                                 ->where('product_id', $productId)
                                 ->where('notes', $request->catatan) 
                                 ->where('desain', $desainInput)    
                                 ->first();

        if ($cekKeranjang) {
            $cekKeranjang->increment('quantity', $request->jumlah);
            $targetCartId = $cekKeranjang->id;
        } else {
            $baru = Keranjang::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $request->jumlah,   
                'notes'      => $request->catatan,  
                'desain'     => $desainInput,       
            ]);
            $targetCartId = $baru->id;
        }

        // =========================================================================
        // GERBANG BELI SEKARANG (DIRECT CHECKOUT)
        // =========================================================================
        if ($request->has('checkout_langsung') && $request->checkout_langsung == 'true') {
            return redirect()->route('customer.pembayaran', [
                'selected_items' => [$targetCartId]
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil dimasukkan ke keranjang!');
    }

    // 2. Fungsi Hapus Item dari Keranjang
    public function hapus($id)
    {
        $keranjang = Keranjang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        // Opsional: Hapus file dari folder jika item keranjang dihapus
        if ($keranjang->desain && File::exists(public_path($keranjang->desain))) {
            File::delete(public_path($keranjang->desain));
        }

        $keranjang->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}