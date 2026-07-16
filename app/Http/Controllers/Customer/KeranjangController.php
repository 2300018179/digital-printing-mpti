<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

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
            'cart_id_edit' => 'nullable|integer', // Tambahan validasi untuk ID edit
            'jumlah'      => 'required|integer|min:1',
            'catatan'     => 'nullable|string',
            'desain_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,zip,rar|max:10240', // Maksimal 10MB
            'desain_link' => 'nullable|url'
        ]);

        $userId = Auth::id();

        // 4. Proses Penyimpanan File / Link Desain Baru
        $desainInput = null;
        if ($request->hasFile('desain_file')) {
            $file = $request->file('desain_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/desain'), $fileName);
            $desainInput = 'uploads/desain/' . $fileName;
        } elseif ($request->desain_link) {
            $desainInput = $request->desain_link;
        }

        // =========================================================================
        // PERBAIKAN UTAMA: LANGKAH 5 (Logika Cabang Antara Edit atau Tambah Baru)
        // =========================================================================
        
        // KONDISI A: JIKA USER SEDANG DALAM MODE EDIT (Ada parameter cart_id_edit)
        if ($request->has('cart_id_edit') && !empty($request->cart_id_edit)) {
            $cartItem = Keranjang::where('id', $request->cart_id_edit)
                                 ->where('user_id', $userId)
                                 ->first();
            
            if ($cartItem) {
                // Tentukan nilai desain awal
                $desainFinal = $cartItem->desain;

                // 1. Jika user mencentang/menekan tombol hapus desain lama via UI
                if ($request->input('hapus_desain_lama') == '1') {
                    $desainFinal = null;
                }

                // 2. Tapi, jika ternyata user mengunggah file baru atau mengisi link baru, gunakan yang baru
                if ($desainInput) {
                    $desainFinal = $desainInput;
                }

                $cartItem->update([
                    'quantity' => $request->jumlah,
                    'notes'    => $request->catatan,
                    'desain'   => $desainFinal, // Hasil akhir bisa berupa file baru, null (terhapus), atau tetap file lama
                ]);
                
                return redirect()->route('customer.dashboard')->with('success', 'Keranjang belanja berhasil diperbarui!');
            }
        }

        // KONDISI B: JIKA USER TAMBAH BARU (Normal)
        // Cek apakah produk dengan CATATAN dan DESAIN yang BENAR-BENAR SAMA sudah ada
        $cekKeranjang = Keranjang::where('user_id', $userId)
                                 ->where('product_id', $productId)
                                 ->where('notes', $request->catatan) 
                                 ->where('desain', $desainInput)     
                                 ->first();

        if ($cekKeranjang) {
            // JIKA IDENTIK: Cukup tambahkan quantity-nya saja
            $cekKeranjang->increment('quantity', $request->jumlah);
        } else {
            // JIKA ADA YANG BEDA: BUAT KOTAKAN BARU!
            Keranjang::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $request->jumlah,   
                'notes'      => $request->catatan,  
                'desain'     => $desainInput,       
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil dimasukkan ke keranjang!');
    }

    // 2. Fungsi Hapus Item dari Keranjang
    public function hapus($id)
    {
        $keranjang = Keranjang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $keranjang->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}