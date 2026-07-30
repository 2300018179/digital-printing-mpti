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
    // TAHAP 1: MENAMPILKAN HALAMAN FORM PEMBAYARAN
    // =========================================================================
    public function prosesPembayaran(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'integer',
        ]);

        $userId = Auth::id();

        $cartItems = Keranjang::whereIn('id', $request->selected_items)
                                ->where('user_id', $userId)
                                ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.pesanan-saya')
                             ->with('error', 'Item belanja tidak ditemukan atau sudah diproses.');
        }

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

        $biayaLayanan = 2000; 
        $grandTotal = $hargaCetak + $biayaLayanan;
        $uangMuka = ceil($grandTotal * 0.5);

        $settings = Setting::pluck('value', 'key')->toArray();

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
            'payment_type' => 'nullable|string|in:dp,full',
            'kode_promo' => 'nullable|string',
            'grand_total' => 'nullable|numeric',
            'nominal_dibayar' => 'nullable|numeric',
        ]);

        $user = Auth::user();
        $userId = $user->id;

        $cartItems = Keranjang::whereIn('id', $request->selected_items)
                              ->where('user_id', $userId)
                              ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.pesanan-saya')
                             ->with('error', 'Sesi belanja Anda kosong atau item sudah diproses.');
        }

        DB::beginTransaction();

        try {
            // 2. Kalkulasi Total Harga Produk
            $hargaCetak = 0;
            foreach ($cartItems as $item) {
                $hargaSatuan = $item->product ? $item->product->price : 0;
                $hargaCetak += ($hargaSatuan * $item->quantity);
            }

            $biayaLayanan = 2000;
            $subTotalAwal = $hargaCetak + $biayaLayanan;

            // Logika Diskon Promo (Backend Security Check)
            $kodePromo = strtoupper(trim($request->input('kode_promo')));
            $diskon = 0;

            $databasePromo = [
                'HUTRI12' => ['tipe' => 'potongan', 'nilai' => 2000],
                'PROMO50' => ['tipe' => 'persen', 'nilai' => 50],
                'HEMAT10' => ['tipe' => 'potongan', 'nilai' => 1000],
            ];

            if (!empty($kodePromo) && isset($databasePromo[$kodePromo])) {
                $promo = $databasePromo[$kodePromo];
                if ($promo['tipe'] === 'persen') {
                    $diskon = ($hargaCetak * $promo['nilai']) / 100;
                } else {
                    $diskon = $promo['nilai'];
                }
            }

            // Hitung Final Grand Total
            $grandTotalFinal = max(0, $subTotalAwal - $diskon);

            // Tentukan Tipe Pembayaran (DP / Full) & Nominal Dibayar
            $paymentType = $request->input('payment_type', 'dp');
            $nominalDibayar = ($paymentType === 'dp') ? ceil($grandTotalFinal / 2) : $grandTotalFinal;

            // 3. Buat Data Induk Pesanan
            $pesanan = new Pesanan(); 
            $pesanan->user_id = $userId; 
            $pesanan->order_id = 'ORD-' . strtoupper(uniqid()); 
            $pesanan->tanggal_pesanan = now();
            $pesanan->nama_pelanggan = $user->name ?? 'Pelanggan Toko';
            
            // Kolom Keuangan Pesanan
            $pesanan->total = $grandTotalFinal;
            $pesanan->diskon = $diskon;
            $pesanan->kode_promo = $kodePromo ?: null;
            $pesanan->tipe_pembayaran = $paymentType; // 'dp' atau 'full'
            $pesanan->nominal_dibayar = $nominalDibayar;
            $pesanan->sisa_pembayaran = max(0, $grandTotalFinal - $nominalDibayar);
            
            $pesanan->status = 'Diproses';

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

            DB::commit();

            // 7. OTOMASI PENGIRIMAN EMAIL NOTIFIKASI
            try {
                $settings = Setting::pluck('value', 'key')->toArray();

                if (($settings['notif_struk_email'] ?? 0) == 1 && !empty($user->email)) {
                    Mail::to($user->email)->send(new NotifikasiPesananMail($pesanan, 'struk_pelanggan'));
                }

                if (($settings['notif_admin_order'] ?? 0) == 1) {
                    $emailAdmin = $settings['email_toko'] ?? config('mail.from.address');
                    if (!empty($emailAdmin)) {
                        Mail::to($emailAdmin)->send(new NotifikasiPesananMail($pesanan, 'notif_admin'));
                    }
                }
            } catch (\Exception $mailEx) {
                Log::error('Gagal mengirimkan notifikasi email: ' . $mailEx->getMessage());
            }

            return redirect()->route('customer.pesanan-saya')
                             ->with('success', 'Pembayaran berhasil dikirim! Pesanan Anda sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}