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
use App\Models\Product;
use App\Models\Promo;
use App\Models\Setting;
use App\Mail\NotifikasiPesananMail;
use Carbon\Carbon;

class PaymentController extends Controller
{

    public function prosesPembayaran(Request $request)
    {
        $userId = Auth::id();
        $buyType = $request->input('buy_type', 'cart'); 
        $checkoutItems = [];
        $hargaCetak = 0;

        if ($buyType === 'cart') {
            $request->validate([
                'selected_items'   => 'required|array',
                'selected_items.*' => 'integer',
            ]);

            $cartItems = Keranjang::whereIn('id', $request->selected_items)
                                    ->where('user_id', $userId)
                                    ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('customer.semua-produk')
                                 ->with('error', 'Item keranjang tidak ditemukan.');
            }

            foreach ($cartItems as $item) {
                $hargaSatuan = $item->product ? $item->product->price : 0;
                $subtotal = $hargaSatuan * $item->quantity;
                $hargaCetak += $subtotal;

                $checkoutItems[] = [
                    'cart_id'      => $item->id,
                    'product_id'   => $item->product_id,
                    'nama'         => $item->product ? $item->product->name : 'Produk',
                    'jumlah'       => $item->quantity,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal'     => $subtotal,
                    'catatan'      => $item->notes ?? '-',
                    'desain'       => $item->desain ?? null,
                ];
            }
        } 

        else if ($buyType === 'direct') {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'jumlah'     => 'required|integer|min:1',
                'catatan'    => 'nullable|string',
                'link_desain'=> 'nullable|url',
                'file_desain'=> 'nullable|file|mimes:jpg,jpeg,png,pdf,zip,rar|max:2048',
            ]);

            $product = Product::findOrFail($request->product_id);
            $hargaSatuan = $product->price;
            $subtotal = $hargaSatuan * $request->jumlah;
            $hargaCetak = $subtotal;

            $desainPath = null;
            if ($request->hasFile('file_desain')) {
                $file = $request->file('file_desain');
                $desainPath = $file->store('desain_temp', 'public');
            } elseif ($request->filled('link_desain')) {
                $desainPath = $request->link_desain;
            }

            $checkoutItems[] = [
                'cart_id'      => null,
                'product_id'   => $product->id,
                'nama'         => $product->name,
                'jumlah'       => $request->jumlah,
                'harga_satuan' => $hargaSatuan,
                'subtotal'     => $subtotal,
                'catatan'      => $request->catatan ?? '-',
                'desain'       => $desainPath,
            ];
        }

        $biayaLayanan = 0; 
        $grandTotal = $hargaCetak + $biayaLayanan;
        $uangMuka = ceil($grandTotal * 0.5);

        $settings = Setting::pluck('value', 'key')->toArray();

        $today = Carbon::today()->toDateString();
        $databasePromo = Promo::where('status', 'Aktif')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->get()
            ->keyBy('kode');

        return view('customer.pembayaran', compact(
            'checkoutItems', 
            'hargaCetak', 
            'biayaLayanan', 
            'grandTotal', 
            'uangMuka',
            'settings',
            'databasePromo',
            'buyType'
        ));
    }

    public function simpanPembayaran(Request $request)
    {
        $request->validate([
            'buy_type'        => 'required|in:cart,direct',
            'bukti_transfer'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'payment_type'    => 'nullable|string|in:dp,full',
            'kode_promo'      => 'nullable|string',
            'items_data'      => 'required|string', 
        ]);

        $user = Auth::user();
        $userId = $user->id;
        $items = json_decode($request->items_data, true);

        if (empty($items)) {
            return redirect()->route('customer.semua-produk')->with('error', 'Item pesanan kosong.');
        }

        DB::beginTransaction();

        try {

            $hargaCetak = 0;
            foreach ($items as $item) {
                $hargaCetak += ($item['harga_satuan'] * $item['jumlah']);
            }

            $biayaLayanan = 0;
            $subTotalAwal = $hargaCetak + $biayaLayanan;

            $kodePromo = strtoupper(trim($request->input('kode_promo')));
            $diskon = 0;

            if (!empty($kodePromo)) {
                $today = Carbon::today()->toDateString();
                $promo = Promo::where('kode', $kodePromo)
                    ->where('status', 'Aktif')
                    ->whereDate('tanggal_mulai', '<=', $today)
                    ->whereDate('tanggal_selesai', '>=', $today)
                    ->first();

                if ($promo) {
                    $nilaiDiskon = (float) $promo->diskon;
                    $diskon = ($nilaiDiskon <= 100) ? ($hargaCetak * $nilaiDiskon) / 100 : $nilaiDiskon;
                } else {
                    $kodePromo = null; 
                }
            }

            $grandTotalFinal = max(0, $subTotalAwal - $diskon);
            $paymentType = $request->input('payment_type', 'dp');
            $nominalDibayar = ($paymentType === 'dp') ? ceil($grandTotalFinal / 2) : $grandTotalFinal;

            $pesanan = new Pesanan(); 
            $pesanan->user_id = $userId; 
            $pesanan->order_id = 'ORD-' . strtoupper(uniqid()); 
            $pesanan->tanggal_pesanan = now();
            $pesanan->nama_pelanggan = $user->name ?? 'Pelanggan Toko';
            $pesanan->total = $grandTotalFinal;
            $pesanan->diskon = $diskon;
            $pesanan->kode_promo = $kodePromo ?: null;
            $pesanan->tipe_pembayaran = $paymentType; 
            $pesanan->nominal_dibayar = $nominalDibayar;
            $pesanan->sisa_pembayaran = max(0, $grandTotalFinal - $nominalDibayar);
            $pesanan->status = 'Diproses';

            if ($request->hasFile('bukti_transfer')) {
                $file = $request->file('bukti_transfer');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/bukti_transfer'), $fileName);
                $pesanan->bukti_transfer = $fileName; 
            }

            $pesanan->save();

            $cartIdsToDelete = [];
            foreach ($items as $item) {
                $fileDesain = null;
                $linkDesain = null;

                if (!empty($item['desain'])) {
                    if (filter_var($item['desain'], FILTER_VALIDATE_URL) || str_contains($item['desain'], 'http')) {
                        $linkDesain = $item['desain'];
                    } else {
                        $fileDesain = $item['desain'];
                    }
                }

                DetailPesanan::create([
                    'pesanan_id'  => $pesanan->id,
                    'product_id'  => $item['product_id'],
                    'nama_produk' => $item['nama'],
                    'jumlah'      => $item['jumlah'],
                    'keterangan'  => $item['catatan'] ?? '-',
                    'file_desain' => $fileDesain,
                    'link_desain' => $linkDesain,
                    'harga'       => $item['harga_satuan'],
                ]);

                if (!empty($item['cart_id'])) {
                    $cartIdsToDelete[] = $item['cart_id'];
                }
            }

            if ($request->buy_type === 'cart' && !empty($cartIdsToDelete)) {
                Keranjang::whereIn('id', $cartIdsToDelete)
                         ->where('user_id', $userId)
                         ->delete();
            }

            DB::commit();

            try {
                
                if (!empty($user->email)) {
                    Mail::to($user->email)->send(new NotifikasiPesananMail($pesanan, 'struk_pelanggan'));
                }

                $settings = Setting::pluck('value', 'key')->toArray();
                $adminEmail = $settings['admin_email'] ?? 'fantasticwnd@gmail.com';

                if (!empty($adminEmail)) {
                    Mail::to($adminEmail)->send(new NotifikasiPesananMail($pesanan, 'notif_admin'));
                }

            } catch (\Exception $mailEx) {
                Log::error('Gagal kirim email notifikasi: ' . $mailEx->getMessage());
            }

            return redirect()->route('customer.pesanan-saya')
                             ->with('success', 'Pembayaran berhasil dikirim! Pesanan Anda sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customer.semua-produk')->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}