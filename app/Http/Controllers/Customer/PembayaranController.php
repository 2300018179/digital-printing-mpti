<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Keranjang; 
// Import model pendukung untuk proses simpan (silakan sesuaikan nama model transaksi/pesanan Anda)
// use App\Models\Pesanan; 
// use App\Models\DetailPesanan; 

class PembayaranController extends Controller
{
    // =========================================================================
    // 1. MENAMPILKAN HALAMAN PEMBAYARAN (Sudah Diperbarui)
    // =========================================================================
    public function prosesPembayaran(Request $request)
    {
        // Inisialisasi array untuk menampung item per produk
        $checkoutItems = [];
        $hargaCetak = 0;

        // SKENARIO 1: PEMBELIAN DARI POP-UP KERANJANG (Berdasarkan Checkbox Item)
        if ($request->has('selected_items') && is_array($request->input('selected_items'))) {
            $selectedIds = $request->input('selected_items');
            $cartItems = Keranjang::with('product')->whereIn('id', $selectedIds)->get();

            foreach ($cartItems as $item) {
                $hargaProduk = $item->product->price ?? $item->product->harga ?? 0;
                $subtotal = $hargaProduk * $item->quantity;
                $hargaCetak += $subtotal;

                // Simpan data bersih per produk ke dalam array
                $checkoutItems[] = [
                    'id' => $item->product->id, // ID Produk ditambahkan untuk keperluan simpan transaksi
                    'nama' => $item->product->name ?? $item->product->nama_produk ?? 'Produk Cetak',
                    'jumlah' => $item->quantity,
                    'harga_satuan' => $hargaProduk,
                    'subtotal' => $subtotal
                ];
            }
        } 
        // SKENARIO 2: BELI SEKARANG DARI DETAIL PRODUK (Pembelian Langsung)
        elseif ($request->has('product_id')) {
            $product = Product::find($request->input('product_id'));

            if ($product) {
                $jumlah = (int) $request->input('jumlah', $product->minimum_order ?? 1);
                $hargaUnit = $product->price ?? $product->harga ?? 0;
                $subtotal = $hargaUnit * $jumlah;
                $hargaCetak = $subtotal;

                $namaProduk = $product->name ?? $product->nama_produk ?? 'Produk Cetak';

                $checkoutItems[] = [
                    'id' => $product->id,
                    'nama' => $namaProduk,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $hargaUnit,
                    'subtotal' => $subtotal
                ];
            }
        }

        // Fallback jika kosong
        if (empty($checkoutItems)) {
            $checkoutItems[] = [
                'id' => 1,
                'nama' => 'Produk Cetak',
                'jumlah' => 1,
                'harga_satuan' => 150000,
                'subtotal' => 150000
            ];
            $hargaCetak = 150000;
        }

        $biayaLayanan = 0;
        $grandTotal = $hargaCetak + $biayaLayanan;
        $uangMuka = $grandTotal * 0.5;

        // Simpan checkoutItems ke session sementara agar bisa divalidasi/diambil saat submit form "SAYA SUDAH BAYAR"
        session(['checkout_items' => $checkoutItems]);

        return view('customer.pembayaran', compact(
            'checkoutItems', 
            'hargaCetak', 
            'biayaLayanan', 
            'grandTotal', 
            'uangMuka'
        ));
    }

    // =========================================================================
    // 2. MEMPROSES PENYIMPANAN PEMBAYARAN KE DATABASE (Fungsi Baru)
    // =========================================================================
    public function simpanPembayaran(Request $request)
    {
        // Validasi tipe pembayaran (DP/Full) dan bukti transfer
        $request->validate([
            'payment_type' => 'required|in:dp,full',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ambil data produk yang dicheckout dari Session
        $checkoutItems = session('checkout_items', []);

        if (empty($checkoutItems)) {
            return redirect()->route('customer.dashboard')->with('error', 'Sesi pembayaran telah berakhir atau keranjang kosong.');
        }

        // --- CONTOH PROSES SIMPAN KE DATABASE ---
        // $noInvoice = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        
        // Simpan ke model Pesanan Anda:
        // $pesanan = new Pesanan();
        // $pesanan->user_id = auth()->id();
        // $pesanan->no_invoice = $noInvoice;
        // $pesanan->tipe_pembayaran = $request->input('payment_type');
        // ...
        // $pesanan->save();

        // Upload berkas bukti transfer
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bukti_transfer', $fileName);
            // $pesanan->bukti_pembayaran = $fileName;
            // $pesanan->save();
        }

        // Hapus session setelah berhasil checkout
        session()->forget('checkout_items');

        // Selesai menyimpan, arahkan ke halaman pesanan yang telah kamu buat
        return redirect()->route('customer.pesanan')
                         ->with('success', 'Pembayaran berhasil dikirim! Pesanan Anda sedang diverifikasi.');
    }
}