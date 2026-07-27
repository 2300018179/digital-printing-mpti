<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Setting;
use App\Mail\NotifikasiPesananMail;

class PaymentController extends Controller
{
    // =========================================================================
    // TAHAP 1: MENAMPILKAN HALAMAN FORM PEMBAYARAN (Saat Klik "Beli Sekarang")
    // =========================================================================
    public function prosesPembayaran(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'integer',
        ]);

        $userId = Auth::id();

        // Ambil data item keranjang yang dicentang beserta relasi produknya
        $cartItems = Keranjang::whereIn('id', $request->selected_items)
                                ->where('user_id', $userId)
                                ->get();

        // Jika kosong (misal karena user me-refresh halaman setelah bayar)
        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.pesanan-saya')
                             ->with('error', 'Item belanja tidak ditemukan atau sudah diproses.');
        }

        // Membentuk struktur array $checkoutItems untuk Blade
        $checkoutItems = [];
        $hargaCetak = 0;

        foreach ($cartItems as $item) {
            $hargaSatuan = $item->product ? $item->product->price : 0;
            $subtotal = $hargaSatuan * $item->quantity;
            $hargaCetak += $subtotal;

            $checkoutItems[] = [
                'id' => $item->id,
                'nama' => $item->product ? $item->product->name : 'Produk',
                'jumlah' => $item->quantity,
                'harga_satuan' => $hargaSatuan,
                'subtotal' => $subtotal
            ];
        }

        // Set nilai biaya layanan (misal: 2000)
        $biayaLayanan = 2000; 
        $grandTotal = $hargaCetak + $biayaLayanan;

        // Hitung Uang Muka (DP 50%)
        $uangMuka = $grandTotal * 0.5;

        // Ambil data pengaturan toko dari database (untuk QRIS & Nama Pemilik)
        $settings = Setting::pluck('value', 'key')->toArray();

        // Kirim seluruh variabel yang dibutuhkan oleh Blade
        return view('customer.pembayaran', compact(
            'checkoutItems', 
            'hargaCetak', 
            'biayaLayanan', 
            'grandTotal', 
            'uangMuka',
            'settings'
        ));
    }

    // =========================================================================
    // TAHAP 2 & 3: SIMPAN KE DB, EMAIL NOTIFIKASI, & HAPUS KERANJANG 
    // =========================================================================
    public function simpanPembayaran(Request $request)
    {
        // 1. Validasi input dari form pembayaran
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'integer',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $userId = $user->id;

        // Ambil kembali data dari database untuk kalkulasi ulang demi keamanan data
        $cartItems = Keranjang::whereIn('id', $request->selected_items)
                              ->where('user_id', $userId)
                              ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.pesanan-saya')
                             ->with('error', 'Sesi belanja Anda kosong atau item sudah diproses.');
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // 2. Hitung Grand Total
            $grandTotal = 0;
            foreach ($cartItems as $item) {
                $hargaSatuan = $item->product ? $item->product->price : 0;
                $grandTotal += ($hargaSatuan * $item->quantity);
            }

            // 3. Buat Data Induk Pesanan
            $pesanan = new Pesanan(); 
            $pesanan->user_id = $userId; 
            $pesanan->order_id = 'ORD-' . strtoupper(uniqid()); 
            $pesanan->tanggal_pesanan = now();
            $pesanan->nama_pelanggan = $user->name ?? 'Pelanggan Toko';
            $pesanan->total = $grandTotal;
            $pesanan->status = 'Diproses'; // Otomatis berstatus diproses karena bukti sudah diupload

            // 4. Upload File Bukti Transfer
            if ($request->hasFile('bukti_transfer')) {
                $file = $request->file('bukti_transfer');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/bukti_transfer'), $fileName);
                $pesanan->bukti_transfer = $fileName; 
            }

            $pesanan->save();

            // 5. Simpan Data Rincian Barang ke Detail Pesanan
            foreach ($cartItems as $item) {

                $fileDesain = null;
                $linkDesain = null;

                if ($item->desain) {
                    // Cek apakah isi kolom 'desain' berupa URL
                    if (filter_var($item->desain, FILTER_VALIDATE_URL) || str_contains($item->desain, 'http')) {
                        $linkDesain = $item->desain; 
                    } else {
                        $fileDesain = $item->desain; 
                    }
                }

                DetailPesanan::create([
                    'pesanan_id'  => $pesanan->id,
                    'product_id'  => $item->product_id,
                    'nama_produk' => $item->product ? $item->product->name : 'Produk Dihapus',
                    'jumlah'      => $item->quantity,
                    'keterangan'  => $item->notes ?? '-',
                    'file_desain' => $fileDesain,
                    'link_desain' => $linkDesain,
                    'harga'       => $item->product ? $item->product->price : 0,
                ]);
            }

            // 6. HAPUS KERANJANG 
            Keranjang::whereIn('id', $request->selected_items)
                      ->where('user_id', $userId)
                      ->delete();

            // Simpan perubahan ke DB
            DB::commit();

            // =========================================================================
            // 7. OTOMASI PENGIRIMAN EMAIL NOTIFIKASI BERDASARKAN SYSTEM SETTINGS
            // =========================================================================
            try {
                $settings = Setting::pluck('value', 'key')->toArray();

                // A. Kirim Struk ke Email Pelanggan (Jika Fitur Dicentang Admin)
                if (($settings['notif_struk_email'] ?? 0) == 1 && !empty($user->email)) {
                    Mail::to($user->email)->send(new NotifikasiPesananMail($pesanan, 'struk_pelanggan'));
                }

                // B. Beritahu Admin via Email jika ada Orderan Masuk (Jika Fitur Dicentang Admin)
                if (($settings['notif_admin_order'] ?? 0) == 1) {
                    $emailAdmin = $settings['email_toko'] ?? config('mail.from.address');
                    if (!empty($emailAdmin)) {
                        Mail::to($emailAdmin)->send(new NotifikasiPesananMail($pesanan, 'notif_admin'));
                    }
                }
            } catch (\Exception $mailEx) {
                // Log kesalahan pengiriman email saja, agar tidak menggagalkan transaksi DB
                Log::error('Gagal mengirimkan notifikasi email: ' . $mailEx->getMessage());
            }

            // Selesai! Alihkan ke halaman Pesanan Saya
            return redirect()->route('customer.pesanan-saya')
                             ->with('success', 'Pembayaran berhasil dikirim! Pesanan Anda sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}