<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Kategori; // <-- 1. Diubah dari Category ke Kategori

class DashboardCSController extends Controller
{
    /**
     * Menampilkan halaman Dashboard utama Customer.
     */
    public function index()
    {
        // 1. Ambil kategori beserta relasi subKategori untuk menu sidebar
        $categories = Kategori::with('subKategoris')->get(); // <-- 2. Diubah di sini juga

        // 2. Ambil 5 produk unggulan (terlaris) disortir langsung dari database
        $products = Product::where('status', '1')
                    ->withSum('detailPesanan', 'jumlah')
                    ->orderByDesc('detail_pesanan_sum_jumlah')
                    ->take(5)
                    ->get();

        // 3. Ambil settings dari database
        $appSettings = DB::table('settings')->pluck('value', 'key')->toArray();

        // 4. Kirim data ke view customer.dashboard
        return view('customer.dashboard', compact('categories', 'products', 'appSettings'));
    }
}